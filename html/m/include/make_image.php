<?
include "../../include/include_function.php";

function textToImage($text, $fname, $fsize) { 
    $text = iconv("EUC-KR", "UTF-8", $text); // 한글지원 
    $padding = 0; // 이미지여백 
    $ttf='../include/H2GPRM.TTF'; 

    $size = imagettfbbox($fsize, 0, $ttf, $text); 
    $xsize = abs($size[0]) + abs($size[2])+($padding*2)+5; 
    $ysize = abs($size[5]) + abs($size[1])+($padding*2)+2; 
    $image = imagecreate($xsize, $ysize); 
    $bcolor = imagecolorallocate ($image, 255, 255, 255); 
    $fcolor = imagecolorallocate ($image, 255, 0, 0); 
    imagefilledrectangle($image, 0, 0, $xsize, $ysize, $bcolor); 
    imagettftext($image, $fsize, 0, $padding, $fsize+$padding, $fcolor, $ttf, $text); 
    imagettftext($image, $fsize, 0, $padding+1, $fsize+$padding, $fcolor, $ttf, $text); 
    //imagejpeg($image,$fname, 90); 
    imagepng($image); 
    imagedestroy($image); 
}

$make_text = makeRand5();

$_SESSION["make_text_image"] = $make_text;

textToImage($make_text,'11','18')
?>