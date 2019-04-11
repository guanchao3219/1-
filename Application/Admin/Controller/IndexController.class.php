<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {	
    	//显示某个页面: 默认index.html
       $this->display();
    }
}