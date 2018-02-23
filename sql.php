<?php
	$db = new PDO('sqlite:../vote.sq3');
	function query($sql, $param)
	{
		global $db;
		$prepared = $db->prepare($sql);
		$prepared->execute($param);
		return $prepared;
	}

	function execute($sql, $param)
	{
		global $db;
		$prepared = $db->prepare($sql);
		$prepared->execute($param);
		$prepared->closeCursor();
		$db->commit();
	}