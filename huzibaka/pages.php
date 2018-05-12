<?php
require('../common/functions.php');

$current_page = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$perpage = PERPAGE;
$rst_pages = output_page($current_page,$perpage);

?>
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
<?php
if(!empty($rst_pages)) {
    foreach ($rst_pages as $row) {
        ?>
        <tr style="text-align: center">
            <td><?php echo $row[0] ?></td>
            <td><?php echo $row[2] ?></td>
            <td><?php echo $row[1] ?></td>
            <td><?php echo $row[3] ?></td>
            <td><a href="javascript:void(0);" name="del">删除</a>
                <?php if($row[1] == 'blog'){ echo "<a href='modify.php?itemid=$row[0]' name='mod'>修改</a>";} ?>
                <a href="view.php?itemid=<?php echo $row[0] ?>">查看</a></td>
        </tr>
        <?php
    }
    ?>
    </tbody></table></div>
    <div class="page-list" ><?php page_list($current_page); ?></div></section></div>
    <?php
}