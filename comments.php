<?php
    require 'common/functions.php';

    $item_id = $_GET["item_id"];
    $comments_name = $_GET["comments_name"];
    $comment_email = $_GET["comment_email"];
    $comments_content = $_GET["comments_content"];

    $con = connect_db();
    $sql = "INSERT INTO `huka_comments`( `item_id`, `coments_name`, `comment_email`, `comments_content`) VALUES ($item_id,'".$comments_name."','".$comment_email."','".$comments_content."') ";
    $con->query($sql);
    if($con->affected_rows){
    	echo item_comments($item_id);
    }




    