<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function main()
    {
    	return $this->fetch();
    }

}

