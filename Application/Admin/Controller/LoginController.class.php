<?php 


namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
	public function login()
	{

		$this->display();


	}

	public function dologin()
	{
		$uname=$_POST['uname'];

		$upwd=$_POST['upwd'];

		$code=$_POST['code'];

		$verify = new \Think\Verify();

	    if( !$verify->check($code)){

	    	$this->error('验证失败','/index.php?m=admin&c=login&a=login');
	    }



		$user=M('bbs_user')->where("uname='$uname'")->find();

		if($user  && password_verify($upwd,$user['upwd']) ){

		//保存当前登录成功的用户信息 
			
		$_SESSION['userInfo']=$user; 
		//是否登陆成功,true是成功,false失败
		
		$_SESSION['flag']=true;

			$this->success('登录成功','/index.php?m=admin&c=index&a=index');

		}else{

			$this->error('帐号或密码不对');
		}
		
	}

		//退出 

	public function logout()
	{
		$_SESSION['flag']=false;

		$_SESSION['userInfo']=NULL;

		$this->success('退出成功....','/index.php?m=admin&c=login&a=login');

	}	

	public function code()
	{
		$config = array(

	  'fontSize' => 15, // 验证码字体大小
	  'length' => 3, // 验证码位数
	  'useNoise' => false, // 关闭验证码杂点
	  'imageW' =>120,
	  'imageH' =>40,
	  'useCurve'=> false,

		);
		$Verify = new \Think\Verify($config);

		$Verify->entry();



	}














}
















































 ?>