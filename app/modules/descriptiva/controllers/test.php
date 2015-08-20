<?php
class Test extends Controller {
    
   public function __construct(){
      	parent::__construct();
        $this->load->model('descriptiva_model');
        $this->load->library('unit_test');
   }
	
   public function index(){
   $this->unit->run( $this->descriptiva_model->media( Array( Array(1,2,3), Array(4,4,4) )  ), Array(2,4), "test de la media"  );   
   echo $this->unit->report();
   }
	      
      
}
