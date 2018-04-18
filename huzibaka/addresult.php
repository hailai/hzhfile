<?php
header('content-type:text/html;charset=utf-8');
require '../common/functions.php';
$now_user = now_user();
    if(!$now_user) {
    	header('Location:login.php');
    }

$label = $_POST['label'];
$title = $_POST['title'];

if($label == 'photo'){
	$file = $_FILES['photo'];
	$maxSize = $file['size'];
    $allowType = array('image/jpg','image/png','image/jpeg','image/gif');
    $maxSize = 2097152;
    $destination = 'upload/image/';
    if($file['error'] == 0) {
	    if($file['size'] > $maxSize) {
		    exit('文件过大');
	    }
	    if(!in_array($file['type'], $allowType)){
		    exit('不支持格式');
	    }
	    if(move_uploaded_file($file['tmp_name'],"../upload/image/".$file['name'])){
	    	if($rr = addItems($title,'photo','/upload/image/'.$file['name']) ){
	    		var_dump($rr);
	    		echo "上传成功";
		        echo "<div><a href='index.php'>返回</a></div>";
		        return;
	    	}   
	    }
    }
    var_dump($rr);
	echo "失1败";
	echo "<div><a href='index.php'>重试</a></div>"; 
    
}else {
	if(addItems($title,'blog',$_POST['article-main'])) {
		echo "上传成功";
		echo "<div><a href='index.php'>返回</a></div>";
	} else {
		echo "失败";
	    echo "<div><a href='index.php'>重试</a></div>"; 
	}
}

