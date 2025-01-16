<?php

/*
require_once 'src/blog.php';
require_once 'src/helpers.php';
require_once 'src/main.php';
require_once 'src/db.php';
*/

require __DIR__  . "/ver";

try{
    $rezult = main();
    echo $rezult;
} catch(Exception $e){
    echo handleError("Error(!) :" . $e -> getMessage());    
}
