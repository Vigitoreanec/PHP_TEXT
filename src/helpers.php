<?php

function handleError(string $error):string
{
    return "\033[31m " . $error . " \r\n \033[97m";
}

function handleHelp():string
{
    $help = <<<HELP
Доступные команды
help - вывод данной подсказки
add-post - создать новый пост
read-all - показать все посты
read - показать пост по id
delete-all - стереть все посты
delete-post - стереть 1 пост

HELP;


    return $help;
}