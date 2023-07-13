<?php

function pdo() {
    $db_url = 'sqlite:'.dirname(dirname(dirname(__FILE__))).'/db.sqlite';
    $pdo = new PDO($db_url, "", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    return $pdo;
}

$pdo = pdo();
function setup_db_sql(){
    $sql = 'CREATE TABLE IF NOT EXISTS chat_messages (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          username TEXT NOT NULL,
          message_text TEXT NOT NULL,
          creation_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL )';
    
    return  $sql;
    }
function pdo_execute($sql, $params = []) {
	global $pdo;
    
    print "this is sql $sql";
	$stat = $pdo->prepare($sql);
	assert($stat);
	$res = $stat->execute($params);
	assert($res);
	return $stat;
}