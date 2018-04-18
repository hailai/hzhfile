<?php
    require 'common/functions.php';

    $itemid = $_GET["itemid"];

    $sql = "SELECT `item_blog` FROM `huka_blogs` WHERE `item_id`=$itemid";
    $con = connect_db();
    $rst = $con->query($sql);
    if($rst){
    	$row = $rst->fetch_row();
    	echo $row[0];
    }
