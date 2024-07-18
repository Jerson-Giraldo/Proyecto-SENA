<?php
class Result {
    public $result;
    public $success;
    public $message;
    public $structure; 

    public function __construct() {
        $this->result;
        $this->success = false;
        $this->message = '';
        $this->structure = []; 
    }
}
/*Aqui en Helpers almacenamos las funciones que nos van a servir en toda la aplicación*/