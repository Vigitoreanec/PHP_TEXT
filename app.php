<?php


// require_once 'src/blog.php';
// require_once 'src/helpers.php';
// require_once 'src/main.php';
// require_once 'src/db.php';

print_r(PDO::getAvailableDrivers());

require __DIR__  . "/vendor/autoload.php";



try{
    $rezult = main();
    echo $rezult;
} catch(Exception $e){
    echo handleError("Error(!) :" . $e -> getMessage());    
}
