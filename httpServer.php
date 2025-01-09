<?php

$file = fopen(__DIR__ . '/data1.txt','a');

echo $_SERVER['HTTP_X_FORWARDED_FOR'];
var_dump(fputs($file,$_SERVER['HTTP_X_FORWARDED_FOR'] . "\n"));
fclose($file);