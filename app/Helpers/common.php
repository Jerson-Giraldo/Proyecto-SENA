<?php
class Result {
    public $result;
    public $success;
    public $message;
    public $structure;
    public $page;     // Añadido
    public $limit;    // Añadido
    public $pages;    // Añadido
    public $rows;     // Añadido

    public function __construct() {
        $this->result = null;
        $this->success = false;
        $this->message = '';
        $this->structure = [];
        $this->page = 0;   // Inicializado
        $this->limit = 0;  // Inicializado
        $this->pages = 0;  // Inicializado
        $this->rows = 0;   // Inicializado
    }
}

/*Aqui en Helpers almacenamos las funciones que nos van a servir en toda la aplicación*/