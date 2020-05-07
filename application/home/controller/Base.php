<?php
namespace app\home\controller;
use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
    	parent::_initialize();
    	
    	if (!session('hid')) {
            $this->redirect('/home/login/login',302);
        }else{
        	$this->hid = session('hid');
        }
    }
}

