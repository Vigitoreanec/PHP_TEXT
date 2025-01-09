<?php
echo "1.php" . PHP_EOL;
var_dump(__DIR__ ."2/2.php");

include  "./2/2.php";
echo dirname(__DIR__) . PHP_EOL;
include dirname(__DIR__ ) ."/2/2.php";
