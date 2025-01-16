<?php

require __DIR__  . "/vendor/autoload.php";

try{
    $rezult = main();
    echo $rezult;
} catch(Exception $e){
    echo handleError("Error(!) :" . $e -> getMessage());    
}
