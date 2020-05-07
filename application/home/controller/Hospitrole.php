<?php
namespace app\home\controller;
use think\Db;

/**
 * 系统角色类
 */
class Hospitrole extends Base
{
	/**
	 * 角色列表
	 */
	public function index()
	{
		$list = Db::table('hospit_role')
			->field('id,pid,role_name,status,create_time,remark,level,sort')
			->where('pid','<>','0')
			->order('sort asc,level asc')
			->paginate(15);
		$this->assign(['list'=>$list]);
		return $this->fetch();
	}

	/**
	 * 添加角色
	 */
	public function add()
	{
		if (request()->isPost()) {
			$data = input('post.');
			if (!empty($data)) {

				// 先看所选角色组的排序是多少，如果选的不是顶级角色组(排序不等于1)，新增角色就和该角色组排序相同；如果是顶级角色组(排序等于1)，就查看最后一个角色组排序+1
				// 查看当前所选角色的排序
				$info = Db::table('hospit_role')->where(['id'=>$data['pid']])->field('sort,level,hospitauth_id')->find();
				if ($info['sort'] == 1) {	//属于顶级角色
					$maxsort = Db::table('hospit_role')->max('sort');	//最大的排序
					$data['sort'] = $maxsort + 1;	//在最大排序的基础上+1
				}else{
					$data['sort'] = $info['sort'];
				}

				
				// 如果添加的角色是三级角色,那添加的时候自动添加其二级角色对应的权限
				Db::startTrans();
				try {
					// 获取所属角色组的权限
					if ($info['level'] == '2') {
						$data['hospitauth_id'] = $info['hospitauth_id'];
					}
					// 等级 在所选等级的基础上+1
					$data['level'] = $info['level']+1;
					$data['create_time'] = $_SERVER['REQUEST_TIME'];
					// p($data);die;
					Db::table('hospit_role')->insert($data);
					Db::commit();
					return apiResponse('200','添加成功');	

				} catch (Exception $e) {

					Db::rollback();
					return apiResponse('110','添加失败');					
				}
				
			}else{
				return apiResponse('110','提交数据不能为空');
			}
		}else{

			// 先查看是否有角色存在，存在就直接查出来，不存在就新增一个超级管理员
			if (!Db::table('hospit_role')->find()) {
				// 获取角色组列表
				Db::table('hospit_role')->insert(['role_name'=>'超级管理员','hospitauth_id'=>'0','sort'=>1,'level'=>1,'create_time'=>$_SERVER['REQUEST_TIME'],'remark'=>'先检查是否有角色，没有就系统新增一个超级管理员角色']);
			}
			$list = Db::table('hospit_role')->where(['status'=>0])->where('level','<=','2')->field('id,role_name,level')->order('sort asc,level asc')->select();
			$this->assign(['list'=>$list]);
		}
		return $this->fetch();
	}

	/**
	 * 修改角色信息
	 */
	public function edit()
	{
		$id = input('id');
		if (request()->isPost()) {
			$data = input('post.');
			if (!empty($data)) {

				// 查找已选角色组的排序和等级，把要修改的角色和选择的角色组的排序和等级一致
				$info = Db::table('hospit_role')->field('sort,level')->where(['id'=>$data['pid']])->find();
				$data['sort'] = $info['sort']+1;
				$data['level'] = $info['level']+1;
				
				$res = Db::table('hospit_role')->where(['id'=>$data['id']])->update($data);
				if ($res) {
				
					return apiResponse('200','修改成功');					
				}else{
					return apiResponse('110','修改失败');					
				}
			}else{
				return apiResponse('110','提交数据不能为空');
			}

		}else{
			$info = Db::table('hospit_role')->field('id,pid,role_name,remark,status')->find($id);
			$role = Db::table('hospit_role')->where(['status'=>0])->where('level','<=','2')->field('id,role_name,level')->order('sort asc,level asc')->select();
			$this->assign(['info'=>$info,'role'=>$role]);
		}
		return $this->fetch();
	}

	/**
	 * 删除角色
	 */
	public function del()
	{
		$id = input('id');
		Db::startTrans();
		try {
			
			Db::table('hospit_role')->delete($id);
			Db::table('hospit_role')->where(['pid'=>$id])->delete();
			
			Db::commit();
			return apiResponse('200','删除成功');
		} catch (Exception $e) {
			Db::rollback();			
			return apiResponse('110','删除失败');
		}
	}

	/**
	 * 批量删除
	 */
	public function batchdel()
	{
		if (request()->isPost()) {
			
			$items = input('post.');
			if (!empty($items)) {

				Db::startTrans();
				try {
					foreach ($items['items'] as $key => $value) {

						// 如果下面有子级，就连子级一块删除
						Db::table('hospit_role')->where(['id'=>$value])->delete();
						Db::table('hospit_role')->where(['pid'=>$value])->delete();
					}
					Db::commit();
					return apiResponse('200','删除成功');
				} catch (Exception $e) {
					Db::rollback();
					return apiResponse('110','删除失败');
				}
			}else{
				return apiResponse('110','请选择要删除的项');
			}

		}else{
			return apiResponse('110','非法请求');
		}
	}

	/**
	 * 分配权限
	 */
	public function match()
	{
		$id = input('id');
		$role_name = input('role_name');
		if (request()->isPost()) {
			$data = input('post.');
			if (!empty($data['items'])) {
				$hospitauth_id = implode(',', $data['items']);

				// 更新角色表
				$res = Db::table('hospit_role')->where(['id'=>$data['id']])->update(['hospitauth_id'=>$hospitauth_id]);
				if ($res) {
					return apiResponse('200','操作成功');
				}else{
					return apiResponse('110','操作失败');
				}
			}else{
				return apiResponse('110','您未选择...');
			}
		}
		$this->assign(['id'=>$id,'role_name'=>$role_name]);
		return $this->fetch();
	}

	/**
	 * 权限列表
	 */
	public function authlist()
	{
		// 当前角色id
		$id = input('id');
		// 先获取所有二级(模块)权限列表
		$list = Db::table('hospit_auth')->where(['status'=>0,'level'=>2])->field('id,title,sort')->order('sort asc,level asc')->select();

		// 获取当前角色的权限列表
		$nowList = Db::table('hospit_role')->where(['id'=>$id])->value('hospitauth_id');
		$nowList = explode(',', $nowList);
		$newList = array();
		$childcheck = array();	//子菜单列表

		foreach ($list as $key => $value) {

			// 组装一级菜单格式
			$value['spread'] = 'true';	//树状展开
			
			$children = Db::table('hospit_auth')->where(['status'=>0,'level'=>3,'pid'=>$value['id']])->field('id,title')->order('sort asc,level asc')->select();

			// 组装二级菜单格式
			foreach ($children as $k => $v) {

				// 判断该角色是否已有该权限
				if (in_array($v['id'], $nowList)) {
					$v['checked'] = 'true';	//选中状态
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