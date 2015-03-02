<?php 
	/*$vid=$_REQUEST[vid];
	switch($vid)
	{
		case '1':
			$rtspUrl="rtsp://v5.cache2.c.youtube.com/CjYLENy73wIaLQk9b-oYqXDHTxMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '2':
			$rtspUrl="rtsp://v8.cache7.c.youtube.com/CjYLENy73wIaLQmCv0MMwCy07RMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '3':
			$rtspUrl="rtsp://v4.cache6.c.youtube.com/CjYLENy73wIaLQloV10b6tfQNRMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '4':
			$rtspUrl="rtsp://v7.cache8.c.youtube.com/CjYLENy73wIaLQkXdz41wIPPVxMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '5':
			$rtspUrl="rtsp://v4.cache4.c.youtube.com/CjYLENy73wIaLQmeNeLWW69mvRMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '6':
			$rtspUrl="rtsp://v8.cache1.c.youtube.com/CjYLENy73wIaLQnkCnvCujzl1RMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '7':
			$rtspUrl="rtsp://v5.cache6.c.youtube.com/CjYLENy73wIaLQnfy-FGmbcmPRMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '8':
			$rtspUrl="rtsp://v8.cache8.c.youtube.com/CjYLENy73wIaLQllW2bMTVTYqBMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '9':
			$rtspUrl="rtsp://v2.cache1.c.youtube.com/CjYLENy73wIaLQkgkcui4eai2RMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '10':
			$rtspUrl="rtsp://v1.cache6.c.youtube.com/CjYLENy73wIaLQllWv4G00Ad2hMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '11':
			$rtspUrl="rtsp://v8.cache5.c.youtube.com/CjYLENy73wIaLQkBt3GWTWdV5RMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
		case '12':
			$rtspUrl="rtsp://v3.cache7.c.youtube.com/CjYLENy73wIaLQnZWDaeTECEcxMYDSANFEIJbXYtZ29vZ2xlSARSBXdhdGNoYK23y_L3973AUQw=/0/0/0/video.3gp";
		break;
	}
	if($rtspUrl)
	header('Location:'.$rtspUrl);
	exit;*/


	
?>

<?php 

parse_str($_SERVER['QUERY_STRING'], $params);
$name = isset($params['name']) ? $params['name'] : 'output.wav';
$content = file_get_contents('php://input');
$fh = fopen($name, 'w') or die("can't open file");
fwrite($fh, $content);
fclose($fh);
	
	
?>

