<?php

function getDB() {
 	if(!isset($db)) {
		$db = new PDO("sqlite:database.db");
	}
}

function initDB(): string
{
    $db = new PDO("sqlite:database.db");
    $db->query("PRAGMA foreign_keys = ON;");
    $db->query("CREATE TABLE `categories` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`category` TEXT NOT NULL
);");
    $db->query("CREATE TABLE IF NOT EXISTS `posts` (
	`id` INTEGER  PRIMARY KEY AUTOINCREMENT UNIQUE,
	`title` TEXT NOT NULL,
	`text` TEXT NOT NULL,
	`id_category` INTEGER,
FOREIGN KEY(`id_category`) REFERENCES `categories`(`id`) ON DELETE RESTRICT
);");

    return "Структура БД построена";
}
function seedDB(): string
{
	$db = new PDO("sqlite:database.db");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 1', 'Text text lorem', 1);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 2', 'Text text lorem', 1);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 3', 'Text text lorem', 2);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 4', 'Text text lorem', 2);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 5', 'Text text lorem', 2);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 6', 'Text text lorem', 3);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 7', 'Text text lorem', 3);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 8', 'Text text lorem', 3);");
	$db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 9', 'Text text lorem', 3);");
	
	$db->query("INSERT INTO categories ( category) VALUES ('Category 1');");
	$db->query("INSERT INTO categories ( category) VALUES ('Category 2');");
	$db->query("INSERT INTO categories ( category) VALUES ('Category 3');");
	
	
	return "Добавление прошло Category and Posts";
}