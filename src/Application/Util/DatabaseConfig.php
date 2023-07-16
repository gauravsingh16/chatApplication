<?php

namespace App\Application\Util;

class DatabaseConfig {

private $pdo;
//Connection for DB 

public function connectUserDB() {
    $db_url = 'sqlite:'.dirname(dirname(dirname(__FILE__))).'/db.sqlite';
    try{
    $this->pdo = new \PDO($db_url, "", "", [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);

    $sql = 
    'CREATE TABLE IF NOT EXISTS user_group(
     group_id INTEGER PRIMARY KEY AUTOINCREMENT,
     group_name TEXT,
     message_text TEXT,
     created_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 )';

 $sql1= 'CREATE TABLE IF NOT EXISTS chat_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    creation_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    group_name TEXT
    FOREIGN KEY (group_name)
        REFERENCES user_group(group_name)
        ON DELETE CASCADE
     )';
    #$this->pdo_execute($group_sql);
    $this->pdo->query('PRAGMA foreign_keys')->fetchColumn(0);
    $this->pdo_execute($sql);


    return $this->pdo;
 }catch(\PDOException $e){
}}

public function connectGroupDB(){
   
    
    
    return $this->pdo;
}

//Execute all query and called in routes for direct query passing.
public function pdo_execute($sql, $params = []) {
    
    print "this is sql $sql";
	$stat = $this->pdo->prepare($sql);
	assert($stat);
	$res = $stat->execute($params);
	assert($res);
	return $stat;
}
}