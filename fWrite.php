<?php

$file = fopen("dataBD.txt","a");

fputs($file,"Hello,World!!!\n");
fputs($file,"Mister ViP\n");

fclose($file);