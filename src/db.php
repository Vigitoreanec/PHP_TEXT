<?php

function getDB()
{

	static $db = null;
	if (is_null($db)) {
		$db = new PDO("sqlite:database.db");
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	}

	return $db;
}

function initDB(): string
{
	$db = getDB();

	$db->query("PRAGMA foreign_keys = ON;");
	$db->query("CREATE TABLE IF NOT EXISTS `categories` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE default 1,
	`title` TEXT NOT NULL);");

	$db->query("CREATE TABLE IF NOT EXISTS `posts` (
	`id` INTEGER  PRIMARY KEY AUTOINCREMENT UNIQUE,
	`title` TEXT NOT NULL,
	`text` TEXT NOT NULL,
	`id_category` INTEGER,
	FOREIGN KEY(`id_category`) REFERENCES `categories`(`id`) ON DELETE RESTRICT);
	");

	return "Структура БД построена";
}

function deleteDB()
{
	$db = getDB();
	try {
		$db->query("DROP TABLE categories");
		$db->query("DROP TABLE posts");
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	return "Delete Tables" . PHP_EOL;
}

function seedDB(): string
{
	$db = getDB();

	$db->query("DElete from posts;");
	$db->query("DElete from categories;");

	$db->query("INSERT INTO categories VALUES (1,'Техника'),(2,'Новые Технологии'),(3,'Образование'),(4,'Искусство'),(5,'Спорт');");

	$query = $db->query("SELECT * FROM categories");
	$categories_count = count($query->fetchAll());


	if ($categories_count > 0) {
		for ($i = 0; $i < $categories_count; $i++) {
			//$query = $db->query("INSERT INTO posts (title, text, id_category) VALUES (:title, :text, :id_category)");
			$stmt = $db->prepare("INSERT INTO posts (title, text, id_category) VALUES (:title, :text, :id_category)");

			for ($i = 0; $i < $categories_count; $i++) {
				$title = 'Title ' . ($i + 1);
				$text = 'Text text lorem ' . ($i + 1);
				$id_category = rand(1, $categories_count);

				$stmt->bindParam(':title', $title);
				$stmt->bindParam(':text', $text);
				$stmt->bindParam(
					':id_category',
					$id_category,
					PDO::PARAM_INT
				); // Явное указание типа INT

				$stmt->execute();
			}

		}
	}

	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 1', 'Text text lorem', 1);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 2', 'Text text lorem', 1);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 3', 'Text text lorem', 2);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 4', 'Text text lorem', 2);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 5', 'Text text lorem', 2);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 6', 'Text text lorem', 3);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 7', 'Text text lorem', 3);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 8', 'Text text lorem', 3);");
	// $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 9', 'Text text lorem', 3);");

	return "Добавление прошло Category and Posts";
}

function readDBCategory(): string
{
	$db = getDB();

	$categories = $db->query("SELECT * FROM categories");
	if (!isset($categories)) {
		return "Категорий НЕТ";
	}
	foreach ($categories as $value) {
		echo $value['title'] . PHP_EOL;
	}
	return "------------------ Все Категорий(и)-------------------";
}

function seedDBPost()
{
	$db = getDB();
	$postAll = $db->query("SELECT cat.id, cat.title FROM categories cat");
	$query = $db->query("SELECT * FROM categories");
	$categories_count = count($query->fetchAll());
	echo $categories_count . PHP_EOL;
	if (!isset($postAll)) {
		return "Категорий НЕТ";
	} else {
		foreach ($postAll as $value) {
			echo '[' . $value['id'] . ']' . " | " . $value['title'] . PHP_EOL;
		}
	}
	$number = readline(PHP_EOL . "Введите номер категории: [ в скобках ] ");

	if ($number != 0 && $categories_count >= $number) {
		$stmt = $db->query("SELECT c.id, c.title FROM categories c WHERE c.id = $number; ");
		$rezult = $stmt->fetch();
		$num = (int) $rezult["id"];
		echo "Категория: " . $rezult["title"] . PHP_EOL;
		$db = null;

		try {
			$db = getDB();
			$stmt = $db->prepare("INSERT INTO posts (title, text, id_category) VALUES (:title, :text, :id_category)");
			$queryPost = $db->query("SELECT * FROM posts");
			$post_count = count($queryPost->fetchAll());
			$title = 'Title ' . ($post_count + 1);
			$text = 'Text ' . randomWord();
			$id_category = $num;

			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':text', $text);
			$stmt->bindParam(
				':id_category',
				$id_category,
				PDO::PARAM_INT
			); // Явное указание типа INT

			$stmt->execute();
		} catch (PDOException $e) {
			echo 'Error' . $e->getMessage() . PHP_EOL;
		}
	} else {
		return handleError("Введите правильный номер категории");
	}

}

function readAllPostsDB()
{
	$db = getDB();
	$stmt = $db->query("SELECT p.id post_id, c.id category_id, c.title, p.title, p.text FROM posts p JOIN categories c ON p.id_categories = p.id; ");
	if (!isset($stmt)) {
		return "Постов НЕТ";
	} else {
		//$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$posts = $stmt->fetchAll();
		print_r($posts);
	}

	return "---------------- Все Посты ---------------------";
}

function readPostDB()
{
	$db = getDB();
	$posts = $db->query("SELECT * FROM posts ");

	if (!isset($posts)) {
		return handleError(" Нет постов");
	}
	foreach ($posts as $value) {
		//print_r($value);
		print_r($value['id'] . "  |  " . $value['title'] . "  |  " . $value['text'] . PHP_EOL);
	}
	echo "------------------ Все Посты -------------------";

	$number = readline(PHP_EOL . "Введите номер поста: [ в скобках ] ");
	if (!$number) {
		return handleError("Введите номер поста");
	}
	$stmt = $db->query("SELECT p.id, p.title, p.text FROM posts p WHERE p.id = $number; ");

	$rezult = $stmt->fetch();
	return PHP_EOL . $rezult['title'] . " | " . $rezult['text'] . PHP_EOL;
}

function readAllPostDB()
{
	$db = getDB();
	$posts = $db->query("SELECT p.title, p.text, c.title AS id_category FROM posts p JOIN categories c ON p.id_category = c.id; ");
	//$category = $db->query("SELECT * FROM posts ");
	if (!isset($posts)) {
		return "Постов НЕТ";
	}
	foreach ($posts as $value) {
		//print_r($value);
		print_r($value['title'] . " | " . $value['text'] . $value['title'] . PHP_EOL);//. PHP_EOL;
	}
	return "------------------ Все Посты -------------------";
}

function randomWord(): string
{
	$words = [];
	$wordsCount = rand(1, 10); 		// колличество
	for ($i = 0; $i < $wordsCount; $i++) {
		$wordLength = rand(3, 10); 	// длина

		for ($i = 0; $i < $wordLength; $i++) {
			$word .= chr((int) rand(97, 122));
		}
		$words[] = $word;
	}
	$rezult = implode("", $words);
	//print_r($words);

	return $rezult;
}

// $titles = [
//     "Новый гаджет",
//     "Захватывающее путешествие",
//     "Современное искусство",
//     "Спортивные новости",
//     "История технологии",
//     "Пейзажи",
// 	   "Абстрактная картина",
//     "Результаты футбольного матча",
//     "Инновации в мире ИИ",
//     "Приключения в джунглях",
//     "Скульптура",
//     "Новый рекорд",
//     "Прорыв в медицине",
//     "Пляжный отдых",
//     "Модернизм",
//     "Упражнения для тела"
// ];