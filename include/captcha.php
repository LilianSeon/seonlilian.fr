<?php
session_start();
$_SESSION['captcha'] = rand(1000,9999);
header ('Content-Type: image/png');
$im = @imagecreatetruecolor(50, 20)
      or die('Impossible de crée un flux d\'image GD');
$grey = imagecolorallocate($im, 0, 0, 0);
imagefill($im, 0, 0, $grey);
$text_color = imagecolorallocate($im, 255, 255, 255);
$font = './police.ttf';
imagestring($im, 50, 8, 3, $_SESSION['captcha'], $text_color);
imagepng($im);
imagedestroy($im);
?>
