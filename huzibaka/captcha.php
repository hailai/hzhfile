<?php
function mkRandomString($type=1,$length=4){
    if($type==1){
        $char=implode('', range(0, 9));
    }elseif($type==2){
        $char=implode('', array_merge(range('a', 'z'),range('A', 'Z')));
    }elseif($type==3){
        $char=implode('', array_merge(range(0,9),range('a', 'z'),range('A', 'Z')));
    }
    $char=str_shuffle($char);
    if($length>strlen($char)){
        die('too long');
    }else{
        return substr($char, 0, $length);
    }
}
function buildCaptcha($width,$height,$pixel=0,$line=0){
    $img=imagecreatetruecolor($width, $height);
    $white=imagecolorallocate($img, 255, 255, 255);
    $dark=imagecolorallocate($img, mt_rand(0,120), mt_rand(0,120), mt_rand(0,120));

    imagefilledrectangle($img, 0, 0, $width, $width, $white);

    $string=mkRandomString(3,4);
    session_start();
    $_SESSION['captcha']=$string;
    $fontfile = array('comic.ttf','comicbd.ttf','comici.ttf','comicz.ttf','msyh.ttc','msyhbd.ttc','msyhl.ttc');

    for($i=0;$i<4;$i++){
        $size=mt_rand(15,24);
        $angle=mt_rand(-15,15);
        $x=$i*$size+10;
        $y=rand(24,26);
        $fontget='../upload/fonts/'.$fontfile[mt_rand(0,count($fontfile)-1)];
        imagettftext($img, $size, $angle, $x, $y, $dark, $fontget, $string[$i]);
    }

    if($pixel){
        for($i=0;$i<$pixel;$i++){
            imagesetpixel($img, mt_rand(0,$width-1), mt_rand(0,$height-1), $dark);
        }
    }

    if($line){
        for($i=0;$i<$line;$i++){
            imageline($img, mt_rand(0,$width-1), mt_rand(0,$height-1), mt_rand(0,$width-1), mt_rand(0,$height-1),$dark);
        }
    }

    header("Content-type: image/png");
    imagepng($img);
    imagedestroy($img);

}
buildCaptcha(120,30,20,5);