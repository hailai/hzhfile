<?php
    require 'common/functions.php';

    $itemid = $_GET['itemid'];
    $itemlabel = $_GET['lastitemlabel'];

    if(!empty($itemlabel) ) {
    	item_retrieve(2,$itemid,$itemlabel);
    }
