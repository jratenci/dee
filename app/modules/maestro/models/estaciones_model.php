<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of marcas_model
 *
 * @author erick
 */
class estaciones_model extends MY_Model {
    function __construct() {
        parent::Model();
    }

    function get_estaciones($filtros=null,$limit=null,$offset=null){
     
      if(!is_null($filtros))
      {
        if(!empty ($filtros['esta_codigo'])) $query = $this->db->where ('esta_codigo',$filtros['esta_codigo']);
        if(!empty ($filtros['esta_nombre'])) $query = $this->db->like ('esta_nombre',$filtros['esta_nombre']);
        if(!empty ($filtros['esta_estado'])) $query = $this->db->where ('esta_estado',$filtros['esta_estado']);
      }
  
       if($this->session->userdata('rol')!=1)
         $query = $this->db->where('usua_id',$this->session->userdata('usuario_id') );
		
      $query = $this->db->join('usuarios','esta_usua_id=usua_id');
      $query = $this->db->get('estaciones',$limit,$offset);

      return ($query->num_rows() > 0) ? $query : false;
    }
    
    function get_controles($filtros=null,$ids_sensores=null){
     
      if(!is_null($filtros)){
        if(!empty ($filtros['esta_id'])) $query = $this->db->where ('esta_id',$filtros['esta_id']);
        if(!empty ($filtros['sen_id'])) $query = $this->db->where ('esta_id',$filtros['esta_id']);
       
        }
        
       if(!is_null($ids_sensores)){
        $query = $this->db->where_in('sens_id', $ids_sensores);    
       } 
               
     	
      $query = $this->db->join('sensores','sens_id=cont_sens_id');
      $query = $this->db->join('estaciones','esta_id=sens_esta_id');
      $query = $this->db->join('acciones','acci_id=cont_acci_id');
      $query = $this->db->join('usuarios','esta_usua_id=usua_id');
      $query = $this->db->get('controles');
      
      return ($query->num_rows() > 0) ? $query : false;
    }
}

