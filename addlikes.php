<?php
    require 'common/functions.php';

    if(is_numeric($_GET['itemid']) ){
    	$itemid = $_GET['itemid'];
    }else {
    	echo 0;
    	return;
    }

    $sel_sql = "SELECT likes FROM `huka_items` WHERE id=$itemid";

    $con = connect_db();
    $sel_rst = $con->query($sel_sql)->fetch_row();
    $likes = ++$sel_rst[0];

    $update_sql = "UPDATE `huka_items` SET likes=".$likes." WHERE id=$itemid";
    $con->query($update_sql);
    if($con->affected_rows > 0){
    	echo $likes;
    }