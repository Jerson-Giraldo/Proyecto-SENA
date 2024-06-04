<?php

class Controller
{
  protected function render($path, $parameters = [], $layout = '')
  {
    ob_start();
    require_once(__DIR__ . '/../Views/' . $path . '.view.php');
    $content = ob_get_clean();
    require_once(__DIR__ . '/../Views/layouts/' . $layout . '.layout.php');
  }
}
/*Todos los archivos de esta carpeta son archivos principales que van a ser utilizados en controller, models y views */