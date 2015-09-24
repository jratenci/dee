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
   $this->unit->run( $this->descriptiva_model->mediana( Array( Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3), Array(1,2,3,4) )  ), Array(5.2,2.5), "test de la mediana"  );
   print_r($this->descriptiva_model->mediana( Array( Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3), Array(1,2,3,4) )  ));
   echo $this->unit->report();
   }
   public function moda(){ //test moda
   $this->unit->run( $this->descriptiva_model->moda( Array(Array(4,2,2,4,2,6,2,2,3,3,6,6,6,6 ))), Array(3), "test de la moda"  );
   echo $this->unit->report();
   }
   public function quartil1(){ //test cuartil 1
   $this->unit->run( $this->descriptiva_model->quartil1( Array(Array(0,1,2,3,4,5))), Array(1.25), "test quartil 1"  );   
   echo $this->unit->report();
   }
   public function quartil2(){ //test cuartil 2
   $this->unit->run( $this->descriptiva_model->quartil2( Array(Array(0,1,2,3,4,5))), Array(2.5), "test quartil 2"  );
        echo $this->unit->report();
   }
   
   public function quartil3(){ //test cuartil 3
   $this->unit->run( $this->descriptiva_model->quartil3( Array(Array(0,1,2,3,4,5))), Array(4.75), "test quartil 3"  );
        echo $this->unit->report();
   }
   public function rango(){ //test rango
   $this->unit->run( $this->descriptiva_model->rango( Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9))), Array(7,8), "test rango"  );
        echo $this->unit->report();
   }
   
   public function varianza(){ //test varianza
   $this->unit->run( $this->descriptiva_model->varianza( Array(Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3),Array(1,2,3,4,5))), Array(0.6922917,2.5), "test variancia"  ); 
   echo $this->unit->report();
   }
   public function desviacionestandar(){ //test desviacion estandar
   $this->unit->run( $this->descriptiva_model->desviacionestandar( Array(Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3),Array(1,2,3,4,5))), Array(0.8320407,1.5811388), "test desviacion estandar"  );
   echo $this->unit->report();
   }
   
   public function cv(){ //test varianza
   $this->unit->run( $this->descriptiva_model->cv( Array(Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3),Array(1,2,3,4,5))), Array(16.70345,52.70463), "test coeficiente de variación"  );
//   print_r($this->descriptiva_model->cv( Array(Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3),Array(1,2,3,4,5))));
   echo $this->unit->report();
   }
   public function coasimetria(){ //test varianza
   $this->unit->run( $this->descriptiva_model->coasimetria( Array(Array(1.25,1.28,1.27,1.21,1.22,1.29,1.3,1.24,1.27,1.29,1.23,1.26,1.3,1.21,1.28,1.3,1.22,1.25,1.2,1.28,1.21,1.29,1.26,1.22,1.28,1.27,1.26,1.23,1.22,1.21
))), Array(16.70345,52.70463), "test coeficiente de asimetria"  );
//   print_r($this->descriptiva_model->cv( Array(Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3),Array(1,2,3,4,5))));
   echo $this->unit->report();
   }
	      
      
}
