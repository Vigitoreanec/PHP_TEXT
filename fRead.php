<?php
//1) 
//echo file_get_contents("dataBD.txt");

//2)
$file = fopen("data.txt","r");

$text = '';
//$text = [];
while(!feof($file)){
    //$text[] = fgets($file);
    $text .= fgets($file);
    //echo fgets($file);
}
 echo "\n+++++++++++++++++++++++++++++++\n";
//echo implode($text);
echo $text;

fclose($file);