<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class Base extends Controller
{
    public function _initialize()
    {
    	parent::_initialize();
    	
    	session('hid',1);
    	if (!session('hid')) {
            $this->redirect('/home/login/login',302);
        }else{
        	$this->hid = session('hid');
        }
    }

}

