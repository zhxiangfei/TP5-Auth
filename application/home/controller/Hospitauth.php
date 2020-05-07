<?php
namespace app\home\controller;
use think\Db;

/**
 * 系统权限类
 */
class Hospitauth extends Base
{
	/**
	 * 权限列表
	 */
	public function index()
	{
		$list = Db::table('hospit_auth')
			->field('id,url,title,is_menu,level,sort,status,create_time')
			->order('sort asc,level asc')
			->paginate(15);
		$this->assign(['list'=>$list]);
		return $this->fetch();
	}

	/**
	 * 添加权限
	 */
	public function add()
	{
		if (request()->isPost()) {
			$data = input('post.');

			if (!empty($data)) {

				if ($data['pid'] == '') {
					$data['pid'] = 0;
				}
				$data['create_time'] = $_SERVER['REQUEST_TIME'];
				$res = Db::table('hospit_auth')->insert($data);
				if ($res) {
					return apiResponse('200','添加成功');
				}else{

					return apiResponse('110','添加失败');
				}
			}else{
				return apiResponse('110','数据不能为空');
			}
		}else{
			// 获取权限列表（到模块）
			$list = Db::table('hospit_auth')->where('level','<=',2)->field('id,title,level')->order('sort asc,level asc')->select();
			// p($list);
			$this->assign(['list'=>$list]);
		}
		return $this->fetch();
	}

	/**
	 * 通过所属菜单获取对应的排序
	 */
	public function getSort()
	{
		$pid = input('pid');
		$sort = Db::table('hospit_auth')->where(['id'=>$pid])->value('sort');
		if ($sort) {
			return apiResponse('200','',$sort);
		}else{
			return apiResponse('110');
		}
	}

	/**
	 * 修改权限
	 */
	public function edit()
	{
		$id = input('id');
		if (request()->isPost()) {
			$data = input('post.');
			if (!empty($data)) {

				// 修改
				if ($data['pid'] == '') {
					$data['pid'] = 0;
				}
				$res = Db::table('hospit_auth')->update($data);
				if ($res) {
					return apiResponse('200','修改成功');
				}else{
					return apiResponse('110','修改失败');
				}
			}else{
				return apiResponse('110','数据不能为空');
			}
		}else{
			$info = Db::table('hospit_auth')->find($id);
			// 获取权限列表
			$list = Db::table('hospit_auth')->where('level','<=',2)->field('id,title,level')->order('sort asc,level asc')->select();
			$this->assign(['info'=>$info,'list'=>$list]);
		}
		return $this->fetch();
	}

	/**
	 * 删除权限
	 */
	public function del()
	{
		$id = input('id');
		$res = Db::table('hospit_auth')->delete($id);
		if ($res) {
			return apiResponse('200','删除成功');
		}else{
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
						Db::table('hospit_auth')->where(['id'=>$value])->delete();
						Db::table('hospit_auth')->where(['pid'=>$value])->delete();
					}
					Db::commit();
					return apiResponse('200','删除成功');
				} catch (Exception $e) {
					Db::rollback();
					return apiResponse('110','删除失败');
				}
			}else{
				return apiResponse('请选择要删除的项');
			}
		}else{
			return apiResponse('非法请求');
		}
	}



}