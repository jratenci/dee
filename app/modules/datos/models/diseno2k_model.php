<?php

class diseno2k_model extends MY_Model {
    public $NombresFactores = Array();
    function __construct() {
        parent::Model();       
    }

   function get_diseno2k($filtros=null,$limit=null,$offset=null){
     if(!is_null($filtros)){
            if(!empty ($filtros['d2k_id'])) $query = $this->db->where ('d2k_id',$filtros['d2k_id']);
            if(!empty ($filtros['d2k_nombre'])) $query = $this->db->like ('d2k_nombre',$filtros['d2k_nombre']);
           }
         
         if($this->session->userdata('rol')!=1)
         $query = $this->db->where('usua_id',$this->session->userdata('usuario_id') );			

         $query= $this->db->select('*');
         $query= $this->db->select('count(*) factores');
         $query= $this->db->join('usuarios', 'usua_id=d2k_usua_id');
         $query= $this->db->join('detalle_diseno2k', 'd2k_id=dd2k_d2k_id');
         $query= $this->db->group_by('d2k_id');
         $query= $this->db->get('diseno2k',$limit,$offset);   
        
         return ($query->num_rows() >0) ? $query : false;   
   }    
   
   function get_detalle($filtros=null){
     if(!is_null($filtros)){
            if(!empty ($filtros['d2k_id'])) $query = $this->db->where ('d2k_id',$filtros['d2k_id']);
          }
         
         if($this->session->userdata('rol')!=1)
         $query = $this->db->where('usua_id',$this->session->userdata('usuario_id') );		

         $query= $this->db->join('usuarios', 'usua_id=d2k_usua_id');
         $query= $this->db->join('detalle_diseno2k', 'd2k_id=dd2k_d2k_id');
         $query= $this->db->get('diseno2k');
         if($query->num_rows() >0){
             foreach ($query->result() as $q ){
                 $this->NombresFactores[]=$q->dd2k_factor;
             }
         }
         
         return ($query->num_rows() >0) ? $query : false;   
   }
   
   function get_tratamientos($filtros=null){
     if(!is_null($filtros)){
            if(!empty ($filtros['d2k_id'])) $query = $this->db->where ('d2k_id',$filtros['d2k_id']);
          }
         
         if($this->session->userdata('rol')!=1)
         $query = $this->db->where('usua_id',$this->session->userdata('usuario_id') );			

         $query= $this->db->join('usuarios', 'usua_id=d2k_usua_id');
         $query= $this->db->join('tratamientos', 'd2k_id=trat_d2k_id');
         $query= $this->db->get('diseno2k');
         return ($query->num_rows() >0) ? $query : false;   
   }
   
   function tablaSignos($numerofactores){
     $numerotratamientos = pow(2,$numerofactores);  
     $filas    = $numerotratamientos; 
     $tablasignos = Array();
     for($fac=0;$fac<$numerofactores;$fac++){
     $signo        = -1;
     $contador     =  0;
     $limite_signo =  pow(2,$fac);
     $columna      =  $fac;    
     for($i=0;$i<$filas;$i++){
         $tablasignos[$i][$columna]=$signo;
         $contador = $contador+1;
         
         if($contador==$limite_signo){
           $contador=0;
           $signo = $signo*-1;
         }     
     }      
  }
     return $tablasignos;
   }
   
  function get_datos($filtros=null){
    $datos = Array();  
  if(!is_null($filtros)){
            if(!empty ($filtros['d2k_id'])) $query = $this->db->where ('d2k_id',$filtros['d2k_id']);
      }
   if($this->session->userdata('rol')!=1)
         $query = $this->db->where('usua_id',$this->session->userdata('usuario_id') );			

         $query= $this->db->join('usuarios', 'usua_id=d2k_usua_id');
         $query= $this->db->join('tratamientos', 'd2k_id=trat_d2k_id');
         $query= $this->db->get('diseno2k');
        
       if($query->num_rows() >0){
          foreach ($query->result() as $tra){
              $datos[$tra->trat_replica][$tra->trat_numerotratamiento] = $tra->trat_respuesta;
          }  
        }
        
        $replicas             = count($datos);
        $tratamientosxreplica = count($datos[1]);
        $datosOrdenados = Array();
        foreach ($datos as $datosxreplica){
           foreach($datosxreplica as $tratamiento=>$valor){
               $datosOrdenados[$tratamiento][] = $valor;
           }
        }
        
        ksort($datosOrdenados);
        /**
        echo '<pre>';
        print_r($datosOrdenados);
        echo '<pre>';
         * 
         */
        
        
    return $datosOrdenados;     
  } 
  
  function existenTodosTratamientos($objetoTratamientos){
      
      if($objetoTratamientos){
       foreach ($objetoTratamientos->result() as $trat){
           if(!is_numeric( $trat->trat_respuesta) ){
             return false;  
           }
       }    
      }else{
          return false;
      }
      return true;
  }
  
  function getNombreFactores(){
      return $this->NombresFactores;
  }
}