<?php
require('../common/functions.php');
$now_user = now_user();
if(!$now_user) {
        header('Location:login.php');
}
require 'header.html';
$itemid = $_GET['itemid'];
$title_sql = "SELECT title FROM `huka_items` WHERE id=$itemid";
$con = connect_db();
$title = $con->query($title_sql)->fetch_row();

$content_sql = "SELECT `item_blog` FROM `huka_blogs` WHERE `item_id`=$itemid";
$content =  $con->query($content_sql)->fetch_row();
?>

<article>
    <div id="con-list">
        <form method="post" action="update.php" enctype="multipart/form-data">
            <div>标题：<input type="text" name="title" value="<?php echo $title[0]; ?>"></div>
            
                <label style="display: none"><input type="text" name="itemid" value="<?php echo $itemid ?>"></label>
            
            <div id="hukaadd_cont">
                <div id="blog-block">
                    <textarea id="article-main" name="article-main" placeholder="这里输入博文" ><?php echo $content[0]; ?></textarea>
                    <script>
                       var article_main = new Simditor({
                           textarea: $('#article-main'),
                           toolbar:['bold', 'italic', 'underline', 'strikethrough', 'fontScale',
                               'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link',
                               'image', 'hr', '|', 'indent', 'outdent', 'alignment']});
                    </script>
                </div>
            </div>
            <div><input type="submit" value="提交"></div>
        </form>
    </div>
</article>
</div>
</body>
</html>