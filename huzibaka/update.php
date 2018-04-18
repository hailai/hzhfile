<?php
require '../common/functions.php';
$now_user = now_user();
    if(!$now_user) {
    	header('Location:login.php');
    }

$title = $_POST['title'];
$content = $_POST['article-main'];
$itemid = $_POST['itemid'];

$title_sql = "UPDATE `huka_items` SET `title`='".$title."' WHERE `id`=$itemid";
$content_sql = "UPDATE `huka_blogs` SET `item_blog`='".$content."' WHERE `item_id`=$itemid";

$con = connect_db();
$con->query($title_sql);
$con->query($content_sql);
if($con->affected_rows > 0){
	echo "修改成功";
	echo "<a href='index.php'>返回</a>";
}else {
	echo 'no';
}