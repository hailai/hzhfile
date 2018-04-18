<?php
require('../common/functions.php');

$page = 1;
$perpage = 3;
$rst_pages = output_page($page,$perpage);

if(!empty($rst_pages)) {
    foreach ($rst_pages as $row) {
        ?>
        <tr style="text-align: center">
            <td><?php echo $row[0] ?></td>
            <td><?php echo $row[2] ?></td>
            <td><?php echo $row[1] ?></td>
            <td><?php echo $row[3] ?></td>
            <td><a href="#" name="del">删除</a>
                <?php if($row[1] == 'blog'){ echo "<a href='modify.php?itemid=$row[0]' name='mod'>修改</a>";} ?>
                <a href="view.php">查看</a></td>
        </tr>
        <?php
    }
}