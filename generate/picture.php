<?php
header('content-type: image/jpeg');

if(!isset($_GET['verse'])){
$reference = rand(0,199);
}else{
$reference = (int)$_GET['verse'];
$reference--;
}

	include"../data/english/translation-sahih-international.php";

	$translation =  stripslashes($verses_translation[$reference]['content']);

	$verse_file = '../data/arabic/images/verses/'.$verses_translation[$reference]['chapter_number'].'_'.$verses_translation[$reference]['verse_number'].'.png';
	$chapter_file = '../data/arabic/images/chapters/'.$verses_translation[$reference]['chapter_number'].'.png';
	$surah_file = '../data/arabic/images/chapters/surah.png';
	$quran_reference = "The Holy Quran: ".$verses_translation[$reference]['chapter_number'].':'.$verses_translation[$reference]['verse_number'];

    $dir = opendir('backgrounds/'); # This is the directory it will count from
    $i = 0; # Integer starts at 0 before counting
	$photos = array();
    # While false is not equal to the filedirectory
    while (false !== ($file = readdir($dir))) { 
        if (!in_array($file, array('.', '..')) AND !is_dir($file)) array_push($photos,$file);
    }

	$background = $photos[array_rand($photos)];


$background ="backgrounds/$background";
$watermark = $verse_file;
$watermark_02 = $chapter_file;
$watermark_03 = $surah_file;

list($background_width,$background_height) = getimagesize($background);
list($watermark_width,$watermark_height) = getimagesize($watermark);
list($watermark_02_width,$watermark_02_height) = getimagesize($watermark_02);

$text     = $translation;
$height_per_line = 23;
$maxchar_per_line = ceil($watermark_width/8.5);
$size  = 15;
$size_translation = 9;
$size_reference = 11;
$position_translation = 0;
if($watermark_height>'330'){
$height_per_line = 12;
$maxchar_per_line = ceil($watermark_width/5.3);
$size  = 9;
$size_translation = 8;
$size_reference = 8;
$position_translation = -2;
}

$lines = explode('|', wordwrap($text, $maxchar_per_line, '|'));
$translation_height = 0;

	foreach ($lines as $line)
	{

		$translation_height += $height_per_line;
	}

$translation_height += ($height_per_line*2);





$watermark = imagecreatefrompng($watermark);
$watermark_02 = imagecreatefrompng($watermark_02);
$watermark_03 = imagecreatefrompng($watermark_03);
$background = imagecreatefromjpeg($background);



 $dst_x = ceil(($background_width-$watermark_width)/2);
 $dst_y = ceil(($background_height-$watermark_height-$translation_height)/2);
 $x1 = ceil($dst_x/2);
 $x2 = ceil($background_width-$x1);
 $y1 = ceil($dst_y/2);
 $y2 = ceil($background_height-$y1);





$color = imagecolorallocatealpha($background, 255, 255, 255, 50);
imagefilledrectangle($background, $x1, $y1, $x2, $y2, $color);




///////////////////




$font  = "fonts/arial.ttf";







$color = imagecolorallocate($background, 0, 0, 0);


$translation_x = $dst_x;
$translation_y = ceil((($background_height-$translation_height-$watermark_height)/2)+$watermark_height);
$translation_y += $height_per_line;
	foreach ($lines as $line)
	{
		imagettftext($background, $size, 0, $translation_x, $translation_y, $color, $font, $line);
		$translation_y += $height_per_line;
	}
		imagettftext($background, $size_translation, 0, $translation_x, $translation_y-$position_translation, $color, $font, $translation_description);
		imagettftext($background, $size_reference, 0, $translation_x, $translation_y+18, $color, $font, $quran_reference);


////////////////


imagecopy($background, $watermark, $dst_x, $dst_y, 0, 0, $watermark_width, $watermark_height);
imagecopy($background, $watermark_02, $dst_x+(ceil($watermark_width/2))-(($watermark_02_width+47)/2), $dst_y-30, 0, 0, $watermark_02_width, $watermark_02_height);
imagecopy($background, $watermark_03, $dst_x+(ceil($watermark_width/2))-(($watermark_02_width+47)/2)+$watermark_02_width, $dst_y-30+(ceil(($watermark_02_height-21)/2)), 0, 0, 47, 21);



//imagejpeg($background);//does not product HD results
imagepng($background);
imagedestroy($background);
imagedestroy($watermark);