<?php
class PageController extends Controller {
  
  public function home(){

    $this->render('home', [], 'site');
    
  }
}