<?php
	$params = explode('/', $_SERVER['PATH_INFO']);
	$domain = $params[1];
	$reference = $params[2];
	$format = explode('.', $params[3])[1];

	require_once('BaconQrCode/autoload.php');
	if($format == 'png')
		$renderer = new \BaconQrCode\Renderer\Image\Png();
	else
	{
		header('HTTP/1.0 400 Bad Request');
		die();
	}

	require_once('../sql.php');

	$key = base64_encode(random_bytes(10));

	query('DELETE FROM keys WHERE reference=?', [$reference]);
	query('INSERT INTO keys (key,reference) VALUES (?,?)', [$key, $reference]);

	$url = sprintf('https://%s/vote.php#!/%s', $domain, urlencode($key));
	$renderer->setHeight(256);
	$renderer->setWidth(256);
	$writer = new \BaconQrCode\Writer($renderer);
	header('Content-Type: image/'.$format);
	echo $writer->writeString($url);