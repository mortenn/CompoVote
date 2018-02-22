<?php
	$params = explode('/', $_SERVER['PATH_INFO']);
	$key = base64_encode(hash('sha256', $params[2], true));
	$url = sprintf('https://%s/vote.php/%s', $params[1], $key);
	$format = explode('.', $params[3])[0];

	require_once('BaconQrCode/autoload.php');
	if($format == 'png')
		$renderer = new \BaconQrCode\Renderer\Image\Png();
	else
	{
		header('HTTP/1.0 400 Bad Request');
		die();
	}
	$renderer->setHeight(256);
	$renderer->setWidth(256);
	$writer = new \BaconQrCode\Writer($renderer);
	header('Content-Type: image/'.$format);
	echo $writer->writeString($url);