<?php
$post = [
    'title' => "",
    'body' => ""
];

function addPost()
{
    $fileName = "dataBD.txt";
    if (is_readable($fileName))
    {
        echo 'Файл доступен для чтения' . PHP_EOL;
    } else {
        return handleError('Файл недоступен для чтения');
    }

    echo PHP_EOL . "Введите заголовок поста: ";
    $title = trim(readline()," \t.");

    echo PHP_EOL . "Введите текст поста: ";
    $body = trim(readline()," \t.");
    echo PHP_EOL;
    if (empty($title) || empty($body)) {
        return handleError( "Заголовок и текст поста не могут быть пустыми.");
    }

    $file = fopen($fileName,"a");
    if (!$file) {
        return handleError( "Не удалось открыть файл для записи.");
    }

    $post['title'] = $title;
    $post['body'] = $body;
    
    if (is_writable($fileName)) {
        //echo PHP_EOL .'Файл доступен для записи' . PHP_EOL;
        fwrite($file,$post['title'] . ":");
        fwrite($file,$post['body'] . ";" . PHP_EOL);
    } else {
        return handleError( 'Файл недоступен для записи');
    }
    fclose($file);
    return "Пост Добавлен" . PHP_EOL;     
}

function readAllPosts()
{
    $fileName = 'dataBD.txt';
    if (!file_exists($fileName)) 
    {
        return handleError( "Файл DataBase не найден");
    }

    $file = fopen($fileName, 'r');
    if (!$file) {
        return handleError( "Не удалось открыть файл DataBase");
    }
    
    $text = [];

    while (($text = fgets($file, 4096)) !== false) {
        //if(!$text)
        //{
        //    $text = $post['title'];
        //}
        //$text[] = ['title' => $title, 'body' => $body];
        print_r($text);
    }
    
    
    fclose($file);
    return "END posts";
}

function readPost()
{

}

function clearPosts()
{
    $fileName = 'dataBD.txt';
    if (file_exists($fileName)) 
    {
        unlink($fileName);
    } else {
        return "Файл DataBase не найден";
    }

    $file = fopen($fileName, 'w');
    if (!$file) {
        return "Не удалось открыть файл DataBase";
    }
    fclose($file);
    return "Файл стерт";
}

function deletePost()
{
    $fileName = 'dataBD.txt';
    if (!file_exists($fileName)) 
    {
        return handleError( "Файл DataBase не найден");
    }

    $file = fopen($fileName, 'r');
    if (!$file) {
        return handleError( "Не удалось открыть файл DataBase");
    }
    do
    {
        $id = (int)readline("Введите id поста");
    }while(empty($id));

    $post = file($fileName);
    print_r($post);

    if(!$post)
    {
        return handleError( "Нечего удалять");
    }
    fwrite($file, $post);

    return "Пост удален";
}