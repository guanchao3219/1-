<?php

namespace Admin\Controller;

use Think\Controller;

class 	CommonController extends Controller
{
    public function __construct()
    {	

    	parent::__construct();
    	//判读是否在登陆状态,如果没有登录,就跳转到登录界面
    	if( empty($_SESSION['flag'])){

    		$this->error('请先登录','/index.php?m=admin&c=login&a=login');
    	}

       
    }
}