<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

/**
 * 登陆类
 */
class Login extends Controller
{

	/**
	 * 登陆
	 */
	public function login()
	{
		if (request()->isPost()) {

			$data['username'] = trim(input('post.username'));
			$data['password'] = trim(md5(md5(input('post.password'))));
			
			//通过用户名找对应的信息
			$info = Db::table('hospit_user')->field(['id,username,password,status,name,is_admin,hospitauth_id'])->where(['username'=>$data['username']])->find();

			if ($info) {
			
				// 验证密码
				if ($info['password'] == $data['password']) {
			
					// 账户审核状态
					if ($info['status'] == 0) {
			
						//是否是超级管理员 
						if ($info['is_admin'] == 1) {	//超级管理员

							$rule = '*';
						}else{
							$rule = $this->getAuthInfo($info['hospitauth_id']);
						}
						session('hid',$info['id']);
						session('rule',$rule);
						session('auth_id',$info['hospitauth_id']);

						return apiResponse('200','登陆成功');
					}else{
						return apiResponse('110','该账户审核暂未通过');
					}
				}else{
					return apiResponse('密码错误');
				}
			}else{

				return apiResponse('110','用户名不存在');
			}

		}else{
			// return apiResponse('110','非法操作');
		}
		return $this->fetch();
	}

	/**
	 * 通过权限id获取对应的权限信息
	 */
	private function getAuthInfo($hospitauth_id)
	{	
		$rule = [];
		// $where = 'id in(' . $result['rule'] . ')';
		$list = Db::table('hospit_auth')->where('id','in',$hospitauth_id)->field('url')->select();

		// 取出url，并存到一维数组
		foreach ($list as $key => $value) {
			$rule[] = $value['url'];
		}
		return $rule;
	}

	/**
	 * 退出
	 */
	public function logout()
	{
		session(null);
        $this->redirect('/home/login/login');
	}

}