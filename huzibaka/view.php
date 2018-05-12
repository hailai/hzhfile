<?php
require './header.html';
require('../common/functions.php');
session_start();
if(empty($_SESSION['username']) ) {
    echo "<script>window.location.href='http://".$_SERVER['HTTP_HOST']."/huzibaka/login.php'</script>";
}
$itemid = $_GET['itemid'];
$title_sql = "SELECT title FROM `huka_items` WHERE id=$itemid";
$con = connect_db();
$title = $con->query($title_sql)->fetch_row();

$label_sql = "SELECT label FROM `huka_items` WHERE id=$itemid";
$label = $con->query($label_sql)->fetch_row();
?>
<article>
	<div id="con-list">
		<div align="center"><?php echo $title[0]; ?></div>
	</div>
<?php

if($label[0] == 'photo') {
	$photo_sql = "SELECT item_photo FROM `huka_photos` WHERE item_id=$itemid";
	$photo_addr = $con->query($photo_sql)->fetch_row();
	echo "<div id='content' align='center' style='width:45%;max-height:700px;margin:0 auto;'><img style='max-width:575px;' src='$photo_addr[0]'></div>";
} else {
	$content_sql = "SELECT `item_blog` FROM `huka_blogs` WHERE `item_id`=$itemid";
	$content =  $con->query($content_sql)->fetch_row();
	echo "<div id='content' align='center' style='width:50%;margin:0 auto;'>$content[0]</div>";
}
?>
</article>