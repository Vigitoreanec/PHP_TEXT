<?php

function main()
{
    $command = parseCommand();

    if (function_exists($command)) {
        $result = $command();
    } else {
        $result = handleError("Нет такой функции");
    }

    return $result;
}

function parseCommand(): string
{
    $command = $_SERVER['argv'][1] ?? 'help';

    return match ($command) {
        'add-post' => 'addPost',
        'read-all' => 'readAllPosts',
        'read' => 'readPost',
        'delete-all' => 'clearAllPosts',
        'delete-post' => 'deletePost',
        'init-DB' => 'initDB',
        'seed-DB' => 'seedDB',
        'seedPost-DB' => 'seedDBPost',
        'delete-DB' => 'deleteDB',
        'readCategory-DB' => 'readDBCategory',
        'rand'=> 'randomWord',
        'readAllPost-DB' => 'readAllPostDB',
        'readAllPosts-DB' => 'readAllPostsDB',
        'readPost-DB'=> 'readPostDB',
        default => 'handleHelp'
    };

}