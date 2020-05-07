<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
    	// 获取左侧菜单
        $menu = $this->getMenu(session('auth_id'));
        // p($menu);die;
        $this->assign(['menu'=>$menu]);
        return $this->fetch();
    }

    public function main()
    {
    	return $this->fetch();
    }

    /**
     * 根据节点数据获取对应的菜单
     * @param $nodeStr
     */
    public function getMenu($nodeStr = '')
    {
        if(empty($nodeStr)){
            return [];
        }
        
        // 超级管理员没有节点数组 * 号表示
        $where = '#' == $nodeStr ? 'is_menu = 2' : 'is_menu = 2 and id in(' . $nodeStr . ')';
        $result = Db::table('hospit_auth')->field('id,pid,menu_icon,url,level,title')
            ->where($where)->order('sort')->select();
        $menu = prepareMenu($result);
        return $menu;
    }

}

