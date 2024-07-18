<?php
class Controller
{
    protected function render($path, $parameters = [], $layout = '')
    {
        // Extraer los parámetros para que estén disponibles en la vista
        extract($parameters);

        // Capturar el contenido de la vista en el buffer de salida
        ob_start();
        require_once(__DIR__ . '/../Views/' . $path . '.view.php');
        $content = ob_get_clean();

        // Requerir el layout, que puede usar la variable $content
        require_once(__DIR__ . '/../Views/layouts/' . $layout . '.layout.php');
    }
}

