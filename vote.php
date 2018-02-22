<?php
	die();
	$db = new PDO('sqlite:../vote.sq3');
	if(!isset($_SERVER['PATH_INFO']))
		die();

	function query($sql, $param)
	{
		global $db;
		$prepared = $db->prepare($sql);
		$prepared->execute($param);
		return $prepared;
	}

	$ip = $_SERVER['REMOTE_ADDR'];

	switch($_SERVER['PATH_INFO'])
	{
		case '/contests':
			echo json_encode(query('SELECT * FROM contests',[])->fetchAll(PDO::FETCH_OBJ));
			break;
		case '/entries':
			if(isset($_GET['contest']))
				echo json_encode(query('SELECT * FROM entries WHERE contest LIKE ?', [$_GET['contest']])->fetchAll(PDO::FETCH_OBJ));
			break;
		case '/vote':
			if(isset($_POST) && isset($_POST['contest']))
			{
				$check = query('SELECT contest,name FROM entries WHERE contest=? AND name=?', [$_POST['contest'],$_POST['entry']])->fetchAll(PDO::FETCH_OBJ);
				if(!$check || count($check) != 1)
					die('?');
				$entry = $check[0];
				query('DELETE FROM votes WHERE contest=? AND client=?',[$entry->contest,$ip]);
				query('INSERT INTO votes (contest,client,entry) VALUES (?,?,?)',[$entry->contest,$ip,$entry->name]);
				echo query('SELECT entry FROM votes WHERE contest=? AND client=?', [$entry->contest,$ip])->fetchColumn();
				break;
			}
			if(isset($_GET['contest']))
				echo query('SELECT entry FROM votes WHERE contest=? AND client=?', [$_GET['contest'],$ip])->fetchColumn();
			break;
	}
