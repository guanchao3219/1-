<?php 

/*
	添加一个功能`	根据大图片名称返回小图片名称
	
	接受大图片信息

	生成一个缩略图
 */

	function getSm($filename)
	{

		$arr = explode('/',$filename);

		$arr[3]='sm_'.$arr[3];

		return implode('/',$arr);

	}


 	

