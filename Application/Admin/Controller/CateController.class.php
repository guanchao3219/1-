<?php

namespace Admin\Controller;

use Think\Controller;

class CateController extends CommonController
{
    //添加板块

	public function create()
	{
		//获取所有分区
		
		$parts=M('bbs_part')->select();

		//获取所有用户
		
		$users=M('bbs_user')->where("auth<3")->select();

		$this->assign('users',$users);
		$this->assign('parts',$parts);
		// view/Cate/create.html
		$this->display();

	}

	public function save()
	{
		$row= M('bbs_cate')->add($_POST);

		if($row){

			$this->success('版块添加成功');
		}else{
			$this->error('版块添加失败');
		}



	}

  //查看板块

	public function index()
	{
		//获取数据
		$cates= M('bbs_cate')->select();
		//获取分区信息
		$parts = M('bbs_part')->select();
		$parts = array_column($parts, 'pname', 'pid');
		

		//获取用户信息
		$users = M('bbs_user')->select();
		$users = array_column($users, 'uname', 'uid');	
		

		$this->assign('cates', $cates);
		$this->assign('parts', $parts);
		$this->assign('users', $users);
		$this->display();

	}


	//删除板块
	public function del()
	{
		$cid =$_GET['cid'];
		$row=M('bbs_cate')->delete($cid);

		if($row){
			$this->success('删除成功');

		}else{

			$this->error('删除失败');
		}


	}


	//修改版块
	public function edit()
	{
		$cid=$_GET['cid'];

		//获取版块
		$cate=M('bbs_cate')->find($cid);
		$users=M('bbs_user')->where("auth<3")->select();

		//获取分区 
		$parts=M('bbs_part')->select();

		$this->assign('users',$users);
		$this->assign('parts',$parts);
		$this->assign('cate',$cate);		
		$this->display();


	}

	public function update()
	{
		$cid=$_GET['cid'];

		$row=M('bbs_cate')->where("cid=$cid")->save($_POST);

		if($row){
			$this->success('修改成功');

		}else{

			$this->error('删除失败');
		}



	}





}