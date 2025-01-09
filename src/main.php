<?php

function main()
{
    $command = parseCommand();

    if(function_exists($command)) {
        $result = $command();
    } else {
        $result = handleError("Нет такой функции");
    }

    return $result;
}

function parseCommand(): string
{
    //TODO улучшить код
    $functionName = 'handleHelp';

    if(isset($_SERVER['argv'][1]))
    {
        
        $functionName = match($_SERVER['argv'][1])
        {
            'help' => 'handleHelp',
            'add-post' => 'addPost',
            'read-all'=> 'readAllPosts',
            'read' => 'readPost',
            'delete-all' => 'clearPosts',
            'delete-post' => 'deletePost',
            default => 'handleHelp'
        };
    }
    return $functionName;
}