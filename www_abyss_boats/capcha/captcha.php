<?php
session_start();

//code a stoker pour la capcha
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$code = substr(str_shuffle($characters), 0, 6);
$pass = $_SESSION['code'] = $code;

$img = imagecreate(400, 70);
$font = "./font.ttf";

//couleur de l'image de font
$bg = imagecolorallocate($img, 255, 255, 255);
$textcolor = imagecolorallocate($img, 98, 78, 136);
$noisecolor = imagecolorallocate($img, 180, 180, 180);

// placement des petits point en fond
for ($i = 0; $i < 300; $i++) {
    imagesetpixel($img, rand(0, 400), rand(0, 70), $noisecolor);
}

// placment des petites ligne de font
for ($i = 0; $i < 5; $i++) {
    imageline($img, rand(0, 400), rand(0, 70), rand(0, 400), rand(0, 70), $noisecolor);
}

//boucle pour mettez en un distortion et les placer dans le cadre
for ($i = 0; $i < strlen($code); $i++){
    $angle = rand(-15, 15); 
    $xDist = rand(-5, 5); 
    $xDist = rand(-5, 5);

    $xPosition = 30 + ($i * 55) + $xDist;
    imagettftext($img, 30, $angle, $xPosition, 50 + $xDist, $textcolor, $font, $code[$i]);
}
header("Content-Type: image/jpeg");
imagejpeg($img);

imagedestroy($img);

