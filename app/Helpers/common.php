<?php
class Result {
    public $success;
    public $message;
    public $structure; // Declaración explícita de la propiedad

    public function __construct() {
        $this->success = false;
        $this->message = '';
        $this->structure = []; // Inicialización opcional según tu lógica
    }
}
/*Aqui en Helpers almacenamos las funciones que nos van a servir en toda la aplicación*/