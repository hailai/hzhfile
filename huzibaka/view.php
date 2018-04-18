<?php
require './header.html'; 
session_start();
if(empty($_SESSION['username']) ) {
    echo "<script>window.location.href='http://".$_SERVER['HTTP_HOST']."/huzibaka/login.php'</script>";
    // header("Location:login.php");
}
?>
<article>
	<div id="con-list">
		<div align="center">$title</div>
	</div>
	<div id="content" align="center">$content</div>
</article>