<?php
	$params = explode('/', $_SERVER['PATH_INFO']);
	$domain = $params[1];
	$reference = $params[2];
	$output = explode('.', $params[3]);
	$size = is_numeric($output[0]) ? (int)$output[0] : 256;
	$format = $output[1];

	require_once('BaconQrCode/autoload.php');
	if($format == 'png')
		$renderer = new \BaconQrCode\Renderer\Image\Png();
	else
	{
		header('HTTP/1.0 400 Bad Request');
		die();
	}

	require_once('../sql.php');

	$exists = query('SELECT * FROM keys WHERE reference = ?', [$reference])->fetchObject();
	if($exists)
		$key = $exists->key;
	else
	{
		$key = base64_encode(random_bytes(10));
		query('INSERT INTO keys (key,reference) VALUES (?,?)', [$key, $reference]);
	}

	$url = sprintf('https://%s/#!/%s', $domain, urlencode($key));
	$renderer->setHeight($size);
	$renderer->setWidth($size);
	$writer = new \BaconQrCode\Writer($renderer);
	header('Content-Type: image/'.$format);
	echo $writer->writeString($url);
