<?php
require 'config.php';


function connect_db(){
    $con = new mysqli(servername,username,password,database);
    if($con->errno){
        exit('connect error'.$con->error);
    } else {
        $con->query("SET NAMES UTF8");
        return $con;
    }
}

function words_cut($item_content){
	
	if(strlen($item_content) > 300) {
        if(preg_match('/[^<\/p>]+<\/p>/', $item_content,$item_prg)){
            if(strlen($item_prg[0]) <= 300) {
                $item_content = $item_prg[0];
            }else { 
                $item_content = mb_substr($item_content,0,140,'utf-8');
            }
        }
    }
    return $item_content;
}




function item_comments($item_id) {
	$con = connect_db();
	$sql = "SELECT `coments_name`,`comments_content` FROM `huka_comments` WHERE item_id={$item_id}";
	$rst = $con->query($sql);
	if($rst->num_rows){
		while ($row = $rst->fetch_row()) {
			$comments[] = $row;
		}
		$output = "<div class='content-comments'><ul>";
		foreach($comments as $row){
			$output .= "<li><span class='visitor-name'>".$row[0]."</span><span class='vistior-says'>".$row[1]."</span></li>";
		}
		$output .= "</ul></div>";
	} else {
		$output = "<div class='content-comments'></div>";
	}
	return $output;
}

function maxid(){
    $con = connect_db();
    $maxid_sql = "SELECT id FROM `huka_items` ORDER BY id DESC LIMIT 1";
    $maxidrst = $con->query($maxid_sql)->fetch_row();
    $maxid = $maxidrst[0];
    return $maxid;
}

function item_retrieve($length=2,$itemid=0,$itemlabel='mixed'){

	$con = connect_db();
    if($itemlabel == 'photo') {
        $minid_sql = "SELECT id FROM `huka_items` WHERE label='photo' LIMIT 1";
    }elseif($itemlabel == 'blog'){
        $minid_sql = "SELECT id FROM `huka_items` WHERE label='blog' LIMIT 1";
    }else{
        $minid_sql = "SELECT id FROM `huka_items` LIMIT 1";
    }
	$minidrst = $con->query($minid_sql)->fetch_row();
	$minid = $minidrst[0];
    if(empty($itemid)) {
        $itemid  = maxid() + 1;
    }
	if($itemid <= $minid) {
        echo "<div class='endline'>wo de di xian ..</div>";
        return;
    } 

    $label_arr = array('photo','blog');

    if($itemlabel == 'mixed'){
        $content_sql = "SELECT `huka_items`.*,`huka_photos`.`item_photo`,`huka_blogs`.`item_blog` FROM `huka_items` LEFT JOIN `huka_photos` ON `huka_photos`.`item_id`=`huka_items`.`id` LEFT JOIN `huka_blogs` ON `huka_blogs`.`item_id`=`huka_items`.`id` WHERE `huka_items`.`id`< $itemid ORDER BY `huka_items`.`id` DESC LIMIT $length";
    }elseif(in_array($itemlabel, $label_arr ) ){
        $content_sql = "SELECT `huka_items`.*,`huka_photos`.`item_photo`,`huka_blogs`.`item_blog` FROM `huka_items` LEFT JOIN `huka_photos` ON `huka_photos`.`item_id`=`huka_items`.`id` LEFT JOIN `huka_blogs` ON `huka_blogs`.`item_id`=`huka_items`.`id` WHERE `huka_items`.`id`< $itemid AND `huka_items`.`label`='".$itemlabel."' ORDER BY `huka_items`.`id` DESC LIMIT $length";
        
    }else{
        $search = array("<",">","'","\"","/","$","script",";","and","=");
        $sql_val  = str_replace($search, '', $itemlabel);
        $content_sql = "SELECT `huka_items`.*,`huka_photos`.`item_photo`,`huka_blogs`.`item_blog` FROM `huka_items` LEFT JOIN `huka_photos` ON `huka_photos`.`item_id`=`huka_items`.`id` LEFT JOIN `huka_blogs` ON `huka_blogs`.`item_id`=`huka_items`.`id` WHERE `huka_items`.`id`< $itemid AND `huka_items`.`title` LIKE '%".$itemlabel."%' ORDER BY `huka_items`.`id` DESC LIMIT 10";
    }
	
	$rst_content = $con->query($content_sql);
	while($row=$rst_content->fetch_row()){
        $id = $row[0];
        $label = $row[1];
        $title = $row[2];
        $likes = $row[3];
        $time = $row[4];
        $item_content = empty($row[5]) ? $row[6] : $row[5];
        if($label == 'blog'){
           $item_content = words_cut($item_content);
        }
        ?>
                <div class="content-block">
                    <div style="display:none" class="item-id"><?php echo $id?></div>
                    <div style="display:none" class="item-label"><?php echo $label?></div>
                    <div class="content-title"><span class="icon-label"><?php if($label == 'blog'){
                        echo "<img src='/upload/image/book.png'>";
                    }else{echo "<img src='/upload/image/camera.png'>";} ?></span><span class="tile-words"><?php echo $title ?></span></div>
                    <div class="content-main"><?php if($label=='photo'){echo '<img class="photo" src="'.$item_content.'">';}else{echo "<div class='blog'>".$item_content."</div>";}?></div>
                    <div class="content-else">
                        <div><a class="icon likes-icon" href="javascript:;"><img src="../upload/image/culike.png"></a><a class="icon comments-icon" href="javascript:;"><img src="../upload/image/commentsicon.png"></a></div>
                        <div class="number-of-likes"><?php if(!empty($likes)){echo $likes.'次赞';} ?></div>
                        
                                <div class="content-comments-<?php echo $id ?>">
                                    <?php echo item_comments($id); ?>
                                </div>
                                
                        
                        <div class="post-time"><?php echo $time ?></div>
                        <div class="write-comments">
                            <form class="comment-form">
                                <div style="display:none" class="item-id"><?php echo $id?></div>
                                <textarea placeholder="添加评论..." class="_bilrf"></textarea>
                                <div class="writer-info" style="display: ;"><input class="writer-input" placeholder="eamil"><input class="writer-input" placeholder="name"><a class="comment-sub" href="javascript:;"><img src="/upload/image/sendicon.png"></a></div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                }
}



//belows are about backend.
function total(){
    $con = connect_db();
    $sql = "SELECT COUNT(*) FROM huka_items";
    $rst = $con->query($sql)->fetch_row();
    $row = $rst[0];
    return $row;
}

function output_page($page,$perpage=2){
    $total = total();
    if(!empty($total)){
        $offset = $page*$perpage-$perpage;
        $con = connect_db();
        $sql = "SELECT id,label,title,time FROM huka_items ORDER BY id DESC LIMIT $offset,$perpage";
        $rst = $con->query($sql);
        while ($row = $rst->fetch_row()){
            $arr[] = $row;
        }
        return $arr;
    } else {
        return null;
    }
}

function addItems($title,$label,$content){
    $con = connect_db();
    $maxid = maxid();
    $itemid = $maxid + 1;
    if($label == 'photo') {
        $phitem_ins_sql = 'INSERT INTO huka_items(label,title,likes) VALUES("photo","'.$title.'",0)'; 
        $con->query($phitem_ins_sql);
        if($con->affected_rows){
            $ph_ins_sql = 'INSERT INTO huka_photos(item_id,item_photo) VALUES("'.$itemid.'","'.$content.'")';
            $con->query($ph_ins_sql);
            if($tt = $con->affected_rows > 0){
                echo 'ok';
                return $tt;
            }
        }
        echo 'wrong';
        return $ph_ins_sql;
    } else {
        $blitem_ins_sql = 'INSERT INTO huka_items(label,title,likes) VALUES("blog","'.$title.'",0)';
        $con->query($blitem_ins_sql);
        if($con->affected_rows) {
            $bl_ins_sql = 'INSERT INTO huka_blogs(item_id,item_blog) VALUES("'.$itemid.'","'.$content.'")';
            $con->query($bl_ins_sql);
            if($con->affected_rows > 0) {
                return 1;
            }
        }
        return 0;
    }
}

function now_user(){
    session_start();
    $user = isset($_SESSION['username']) ? $_SESSION['username'] : false;
    return $user;
}
//others
