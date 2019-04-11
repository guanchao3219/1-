<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Image;


class UserController extends CommonController
{


    //显示表单 
    public  function create()
    {

        $this->display();

    }

    //接受表单数据,保存
    public  function save()
    {
       $data = $_POST;

       //添加时间
       $data['created_at'] = time();

       //密码不能为空 
       if (empty($data['upwd']) || empty($data['reupwd'])) {

            $this->error('密码不能为空');
        }
        // 两次密码要一致
       if ($data['upwd'] !== $data['reupwd']) {

            $this->error('两次密码不一致!');
        }

        //加密密码
        
       $data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);


        //处理上传文件
	     $data['uface']= $this->doUp();

	     // 生成一个缩略图
	     $this->doSm();

	     //添加文件到数据库,返回一个受影响行数	
        $row = M('bbs_user') ->add($data);

        if($row){

            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }


    }

    
    //查看用户
    public  function  index()
    {
    	// 定义一个空数组
    	
    	$condition=[];
    	//是否有性别条件
    	if(!empty($_GET['sex'])){

		  $condition['sex'] =['EQ',"{$_GET['sex']}"];

    	}


    	//是否有姓名条件
    	if(!empty($_GET['uname'])){

		  $condition['uname'] = ['like',"%{$_GET['uname']}%"];

    	}
 		// 先实例化一个表对象	
    	$Users= M('bbs_user');
      $cnt=$Users->where($condition) -> count();

    //实例化分页类,传入总记录数和每页显示的记录数
      $Page = new \Think\Page($cnt,2);

    //得到分页显示html代码
    
      $html_page = $Page -> show();
   
        //获取数据
      $users = M('bbs_user')->where($condition)->limit($Page->firstRow,$Page->listRows)->select();
/*
        //将头像缩略图上传到表单
        		foreach($users as $k=>$v){
        		$arr=explode('/',$v['uface']);

       			$arr[3]='sm_'.$arr[3];

       			$users[$k]['uface'] =implode('/',$arr);

       			} 
      			 
        //显示数据
 
 
        echo '<pre>';
        print_r($users);
*/
        $this->assign('users',$users);
        $this->assign('html_page',$html_page);

        $this->display();


    }

    //删除一个指定用户
    
    public function del()
      {
        $uid =$_GET['uid'];

       $row =M('bbs_user')->delete($uid);

       if($row){

        $this->success('删除成功');
       }else{
        
        $this->error('删除失败');
       }


      }


      //在表单中显示原有数据

      public function  edit()
      {
        $uid = $_GET['uid'];
        $user= M('bbs_user')->find($uid);
/*
        $arr=explode('/',$user['uface']);

        $arr[3]='sm_'.$arr[3];

        $user['uface']=implode('/',$arr);
*/
        $this->assign('user',$user);
        $this->display();


      }
 

      // 收到修改数据后,进行更新

      public function update()
      {
        $uid= $_GET['uid'];

       $data=$_POST; 

       //如果上传新的头像

       if($_FILES['uface']['error'] !==4){

       		//处理上传文件
       		$data['uface']=$this->doUp();
       		//处理缩略图
       		$this->doSm();
       }

        $row= M('bbs_user')->where("uid=$uid")->save($data);


        if($row){

            $this->success('修改成功','/index.php?m=admin&c=user&a=index');


        }else{
            $this->error('修改失败');
        }


      }



    //处理文件上传

    private function doUp()
    {

    	        //头像文件上传
	    $config =[
	    		  'maxSize'=>3145728,    	
	    		  'rootPath'=>'./',
	    		  'savePath'=>'Public/Uploads/',
	    		  'saveName'=>array('uniqid',''),
	    		  'exts'=>array('jpg','gif','png','jpeg'),
	    		  'autoSub'=>true,
	    		  'subName'=>array('date','Ymd'),

	    		 ];

	    //实例化上传类
	    $up = new \Think\Upload($config);

	    $info =$up->upload();

	    if(!$info){
	    	//上传错误提示信息
	    	$this->error( $up->getError);

	    }

	   return $this->filename = $info['uface']['savepath'].$info['uface']['savename'];

    }

    private function doSm()
    {
    	$image= new Image(Image::IMAGE_GD, $this->filename);
	    
	    $image->thumb(150,150)->save('./'.getSm($this->filename));
 		
    	
    }

















}