<?php
namespace app\home\controller;
use think\Db;

/**
 * 系统管理员类
 */
class Hospituser extends Base
{

	/**
	 * 管理员列表
	 */
    public function index()
    {
    	// 搜索条件
		$map = array();
		$search = trim(input('post.name'));
		$map['hospit_user.name'] = array('like',"%$search%");
		
		$list = Db::view('hospit_user')
    		->view('hospit_role','role_name','hospit_user.hospitrole_id = hospit_role.id')
    		->where($map)
    		->paginate(15);
    	
    	$this->assign(['list'=>$list]);
        return $this->fetch();
    }

    /**
     * 添加管理员
     */
    public function add()
    {
    	if (request()->isPost()) {

			$data = input('post.');
    		// 接收数据，并转换成数组
    		if (!empty($data)) {

    			// 检测用户名是否存在
    			if (Db::table('hospit_user')->where(['username'=>$data['username']])->find()) {
    				return apiResponse('110','用户名已经存在');
    			}

                // 查询所选角色组的权限，并添加到用户表中
                $data['hospitauth_id'] = Db::table('hospit_role')->where(['id'=>$data['hospitrole_id']])->value('hospitauth_id');
                $data['password'] = md5(md5($data['password']));
    			$data['create_time'] = $_SERVER['REQUEST_TIME'];

    			// 添加数据库
    			$res = Db::table('hospit_user')->insert($data);
    			if ($res) {
    				return apiResponse('200','添加成功');
    			}else{
    				return apiResponse('110','添加失败');
    			}
    		}else{
    			return apiResponse('110','数据不能为空');
    		}
    	}else{
            // 获取角色列表
            $list = Db::table('hospit_role')->field('id,role_name,level')->order('sort asc,level asc')->where('level','<>',1)->select();
            $this->assign(['list'=>$list]);
        }
    	return $this->fetch();
    }

    /**
     * 修改管理员信息
     */
    public function edit()
    {
        $id = input('id');
        if (request()->isPost()) {
            
            $data = input('post.');
            if (!empty($data)) {

                if ($data['password'] == '*********') {
                    unset($data['password']);
                }else{
                    $data['password'] = md5(md5($data['password']));
                }
                // 查询所选角色组的权限，并更新到用户表中
                $data['hospitauth_id'] = Db::table('hospit_role')->where(['id'=>$data['hospitrole_id']])->value('hospitauth_id');

                $res = Db::table('hospit_user')->update($data);
                if ($res) {
                    return apiResponse('200','修改成功');
                }else{
                    return apiResponse('110','修改失败');
                }
            }else{
                return apiResponse('110','数据不能为空');
            }
        }else{
            // 获取信息
            $info = Db::table('hospit_user')->find($id);
            // 角色列表
            $list = Db::table('hospit_role')->field('id,role_name,level')->order('sort asc,level asc')->where('level','<>',1)->select();
            $this->assign(['info'=>$info,'list'=>$list]);
        }
        return $this->fetch();
    }

    /**
     * 更新审核状态
     */
    public function upStatus()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $res = Db::table('hospit_user')->update($data);
            if ($res) {
                return apiResponse('200','操作成功');                
            }else{
                return apiResponse('110','操作失败');                
            }
        }else{
            return apiResponse('110','非法请求');            
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        $id = input('id');
        $res = Db::table('hospit_user')->delete($id);
        if ($res) {
            return apiResponse('200','删除成功');
        }else{
            return apiResponse('110','删除失败');
        }
    }

    /**
     * 分配权限
     */
    public function match()
    {
        $id = input('id');
        $name = input('name');
        if (request()->isPost()) {
            $data = input('post.');
            if (!empty($data['items'])) {
                $hospitauth_id = implode(',', $data['items']);

                // 更新用户表
                $res = Db::table('hospit_user')->where(['id'=>$data['id']])->update(['hospitauth_id'=>$hospitauth_id]);
                if ($res) {
                    return apiResponse('200','操作成功');
                }else{
                    return apiResponse('110','操作失败');
                }
            }else{
                return apiResponse('110','您未选择...');
            }
        }
        $this->assign(['id'=>$id,'name'=>$name]);
        return $this->fetch();
    }

    /**
     * 权限列表
     */
    public function authlist()
    {
        // 当前用户id
        $id = input('id');
        // 先获取所有二级(模块)权限列表
        $list = Db::table('hospit_auth')->where(['status'=>0,'level'=>2])->field('id,title,sort')->order('sort asc,level asc')->select();

        // 获取当前用户的权限列表
        $nowList = Db::table('hospit_user')->where(['id'=>$id])->value('hospitauth_id');
        $nowList = explode(',', $nowList);
        $newList = array();
        $childcheck = array();  //子菜单列表

        foreach ($list as $key => $value) {

            // 组装一级菜单格式
            $value['spread'] = 'true';  //树状展开

            $children = Db::table('hospit_auth')->where(['status'=>0,'level'=>3,'pid'=>$value['id']])->field('id,title')->order('sort asc,level asc')->select();

            // 组装二级菜单格式
            foreach ($children as $k => $v) {

                // 判断该角色是否已有该权限
                if (in_array($v['id'], $nowList)) {
                    $v['checked'] = true; //选中状态
                }
                // 子菜单列表
                $value['children'][] = $v;
            }
            $newList[] = $value;
        }
        
        if ($newList) {
            return apiResponse('200','',$newList);
        }else{
            return apiResponse('110');
        }
    }

}

