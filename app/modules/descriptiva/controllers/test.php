<?php
class Test extends Controller {
    
   public function __construct(){
      	parent::__construct();
        $this->load->model('descriptiva_model');
        $this->load->library('unit_test');
   }
	
   public function index(){ //test media
   $this->unit->run( $this->descriptiva_model->media( Array( Array(1,2,3), Array(4,5,1,2) )  ), Array(2,3), "test de la media"  );   
   $this->unit->run( $this->descriptiva_model->media( Array( Array(1,2), Array(1,4) )  ), Array(1.5,2.5), "test de la media"  );   
      
   echo $this->unit->report();
   }
   public function mediana(){ //test mediana
   $this->unit->run( $this->descriptiva_model->mediana( Array( Array(2,4,7,7,3,1,4), Array(1,2,3,4) )  ), Array(7,2.5), "test de la mediana"  );
   echo $this->unit->report();
   }
   public function moda(){ //test moda
   $this->unit->run( $this->descriptiva_model->moda( Array(2,2,2,3,3)), Array(Array(2,4),Array(2,4),Array(2,4),Array(3,1)), "test de la moda"  );
   echo $this->unit->report();
   }
   public function quartil1(){ //test cuartil 1
   $this->unit->run( $this->descriptiva_model->quartil1( Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9))), Array(3,2.5), "test quartil 1"  );
        echo $this->unit->report();
   }
   public function quartil2(){ //test cuartil 2
   $this->unit->run( $this->descriptiva_model->quartil2( Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9))), Array(5,4.5), "test quartil 2"  );
        echo $this->unit->report();
   }
   
   public function quartil3(){ //test cuartil 3
   $this->unit->run( $this->descriptiva_model->quartil3( Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9))), Array(6,6.5), "test quartil 3"  );
        echo $this->unit->report();
   }
   public function rango(){ //test rango
   $this->unit->run( $this->descriptiva_model->rango( Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9))), Array(7,8), "test rango"  );
        echo $this->unit->report();
   }
   
   public function desviacionmedia(){ //test desvicion media
   $this->unit->run( $this->descriptiva_model->desviacionmedia( Array(Array(9,3,8,8,9,8,9,18),Array(2,3,2,3,4))), Array(2.25,1.65), "test desviacion media"  );
        echo $this->unit->report();
   }
   
   public function variancia(){ //test varianza
   $this->unit->run( $this->descriptiva_model->variancia( Array(Array(9,3,8,8,9,8,9,18),Array(2,3,2,3,4))), Array(15,10.6), "test variancia"  );
        echo $this->unit->report();
   }
   
	      
      
}
