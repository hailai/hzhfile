<?php
require '../common/functions.php';
$now_user = now_user();
    if(!$now_user) {
    	header('Location:login.php');
    }

$item_id = isset($_GET['itemid'])?$_GET['itemid']:null;
if(!empty($item_id)){
    $con = connect_db();
    $sql = "DELETE FROM huka_items WHERE id={$item_id}";
    $con->query($sql);
    if($con->affected_rows){
        echo json_encode(['st'=>1]);
    }else{
        echo json_encode(['st'=>0]);
    }
}
