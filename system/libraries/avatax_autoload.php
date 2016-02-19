<?php


function __autoload($class_name) 
{
    $class_name = str_replace("\\","/", $class_name);
    // echo __DIR__ ;
   	$file = __DIR__.'/'.$class_name.'.php';
    if ( ! file_exists($file))
    {
        return FALSE;
    }
    include $file;
}

$configuration = Array();
$configuration['accountNumber'] = "1100152941";
$configuration['licenseKey'] = "F0D3AC768AE0A755";
$configuration['serviceURL'] = "https://development.avalara.net";    