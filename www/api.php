<?php
	if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
		die();

	$params = explode('/', $_SERVER['PATH_INFO']);
	if(count($params) < 2)
	{
		header('HTTP/1.0 400 Bad Request');
		die();
	}

	require_once('../sql.php');

	$response = false;
	switch($params[1])
	{
		case 'contests':
			$response = query('SELECT name FROM contests',[])->fetchAll(PDO::FETCH_OBJ);
			break;

		case 'entries':
			if(isset($params[2]))
				$response = query(
					'SELECT name, contestant FROM entries WHERE contest = ?',
					[$params[2]]
				)->fetchAll(PDO::FETCH_OBJ);
			break;

		case 'vote':
			$ip = $_SERVER['REMOTE_ADDR'];
			error_log($ip);
			error_log(count($params));
			if(count($params) == 4)
			{
				$check = query(
					'SELECT contest, name FROM entries WHERE contest=? AND name=?',
					[$params[2],$params[3]]
				)->fetchAll(PDO::FETCH_OBJ);
				if(!$check || count($check) != 1)
				{
					header('HTTP/1.0 400 Bad Request');
					die();
				}
				$entry = $check[0];
				error_log(serialize($entry));
				query('DELETE FROM votes WHERE contest=? AND client=?',[$entry->contest, $ip]);
				query('INSERT INTO votes (contest,client,entry) VALUES (?,?,?)',[$entry->contest, $ip, $entry->name]);
				error_log('done..');
			}
			$response = query(
				'SELECT contest,entry FROM votes WHERE contest=? AND client=?',
				[$params[2], $ip]
			)->fetchObject();
			error_log(serialize($response));
			break;

		default:
			header('HTTP/1.0 501 Not Implemented');
			die();
	}

	if($response)
	{
		header('Content-Type: application/json');
		echo json_encode($response);
	}
