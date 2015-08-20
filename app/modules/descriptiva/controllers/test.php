<?php
class Test extends Controller {
    
   public function __construct(){
      	parent::__construct();
        $this->load->model('descriptiva_model');
        $this->load->library('unit_test');
   }
	
   public function index(){
   $this->unit->run( $this->descriptiva_model->media( Array( Array(1,2,3), Array(4,5,1,2) )  ), Array(2,3), "test de la media"  );   
   $this->unit->run( $this->descriptiva_model->media( Array( Array(1,2), Array(1,4) )  ), Array(1.5,2.5), "test de la media"  );   
      
   echo $this->unit->report();
   }
	      
      
}
