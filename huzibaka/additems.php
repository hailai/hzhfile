<?php 
require('../common/functions.php');
$now_user = now_user();
    if(!$now_user) {
        header('Location:login.php');
    }
    require 'header.html'; 
?>
<article>
    <div id="con-list">
        <form method="post" action="addresult.php" enctype="multipart/form-data">
            <div>标题：<input type="text" name="title"></div>
            <div>类别：<label><input type="radio" name="label" value="photo" >照片</label>
                <label><input type="radio" name="label" value="blog" checked>文章</label>
            </div>
            <div id="hukaadd_cont" >
                <div id="photo-block" style="display:none">请选择上传<input type="file" name="photo" accept="image/*" >
                    <div id="preview"></div>
                </div>
                <div id="blog-block" >
                    <textarea id="article-main" name="article-main" placeholder="这里输入博文" ></textarea>
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