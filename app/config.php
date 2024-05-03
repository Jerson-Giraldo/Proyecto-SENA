<?php

$folderPath = dirname($_SERVER['SCRIPT_NAME']);
$urlPath = $_SERVER['REQUEST_URI'];
$url = substr($urlPath, strlen($folderPath));
/** La función substr extrae una cadena de texto dentro de una cadena de texto */

define('URL', $url); //constante global URL para almacenar la variable $url
define('URL_PATH', $folderPath);
