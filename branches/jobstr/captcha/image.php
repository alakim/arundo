<?php 

// Устанавливаем переменную img_dir, которая примет значение пути к папке со шрифтами и (если потребуется) изображениями
define ( 'DOCUMENT_ROOT', dirname ( __FILE__ ) );
define("img_dir", DOCUMENT_ROOT."/img/"); // Если скрипт отказывается работать, то скорее всего ваш сервер не поддерживает $HTTP_SERVER_VARS. В таком случае, закомментируйте эту строчку и раскомментируйте следующую.
define("img_dir", "/img/");
 
include('code.php');

$key = $_REQUEST["k"];

function img_code($code){
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                   
	header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");         
	header("Cache-Control: post-check=0, pre-check=0", false);           
	header("Pragma: no-cache");                                           
	header("Content-Type:image/png");
	//header("Content-Type:text");
	$linenum = rand(3, 7);
	
	$img_arr = array("1.png", "2.png", "3.png");

	$font_arr = array();
	$font_arr[0]["fname"] = "fonts/couri.ttf";
	$font_arr[0]["size"] = rand(40, 60);
	$font_arr[1]["fname"] = "fonts/BuxtonSketch.ttf";
	$font_arr[1]["size"] = rand(40, 60);
		
	// Генерируем "подстилку" для капчи со случайным фоном
	$n = rand(0,sizeof($font_arr)-1);
	$img_fn = $img_arr[rand(0, sizeof($img_arr)-1)];
	$im = imagecreatefrompng (img_dir . $img_fn); 

	// Рисуем линии на подстилке
	for ($i=0; $i<$linenum; $i++){
		$color = imagecolorallocate($im, rand(0, 150), rand(0, 100), rand(0, 150)); 
		imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
	}
	$color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200)); 

	// Накладываем текст капчи
	$x = rand(0, 35);
	for($i = 0; $i < strlen($code); $i++){
		$x=$i*25;
		$letter=substr($code, $i, 1);
		imagettftext ($im, $font_arr[$n]["size"], rand(2, 4), $x, rand(60, 75), $color, $font_arr[$n]["fname"], $letter);
	}

	// Опять линии, уже сверху текста
	for ($i=0; $i<$linenum; $i++){
		$color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
		imageline($im, rand(0, 20), rand(1, 90), rand(150, 180), rand(1, 90), $color);
	}
	ImagePNG ($im);
	ImageDestroy ($im);
}

img_code(captcha_generateCode($key)); 
