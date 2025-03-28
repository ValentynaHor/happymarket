<?	
	if(!empty($_GET['adr']))
	{
		//$adr = $name."@".$server;
		$adr = str_rot13($_GET['adr']);
		//$size = 2; 
		$im = imagecreate(imagefontwidth($_GET['size'])*strlen($adr), imagefontheight($_GET['size'])); 
		$bg = imagecolorallocate($im, 255, 255, 255); 
		//$black = imagecolorallocate($im, 140, 140, 140); 
		$black = imagecolorallocate($im, $_GET['red'], $_GET['green'], $_GET['blue']); 
		imagecolortransparent($im,$bg); 
		imagestring($im, $_GET['size'], 0, 1, $adr, $black); 
		header('Content-type: image/png'); 
		imagepng($im);
	}
	else exit;
?>
