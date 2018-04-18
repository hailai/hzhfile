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
                <div id="header-list"><div class="urif"></div><div class="urif"></div></div>
                <div id="items">
                    <table name="jkls">
                        <thead>
                        <tr>
                            <th style="width: 50px;">id</th>
                            <th style="width: 160px;">title</th>
                            <th style="width: 80px;">label</th>
                            <th style="width: 180px;">time</th>
                            <th style="width: 180px;">operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php require 'pages.php'; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </div>
</body>
</html>