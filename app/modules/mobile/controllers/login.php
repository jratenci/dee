<?php

class login extends Controller {
    function __construct(){
      parent::__construct();
      $this->load->model('login_model');           
    }
    
    function index(){
        $this->load->view("login_view");
    }
}