<?php 
require './header.html'; 
session_start();
if(empty($_SESSION['username']) ) {
    echo "<script>window.location.href='http://".$_SERVER['HTTP_HOST']."/huzibaka/login.php'</script>";
}
?>
        <article>
            <div id="con-list">
                <div id="header-list"><div class="urif"></div><div class="urif"></div></div>
                <section class="page-con">
                
                        <?php require 'pages.php'; ?>
        </article>
    </div>
</body>
</html>