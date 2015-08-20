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
class sensores_model extends MY_Model {
    function __construct() {
        parent::Model();
    }

    function get_sensores($filtros=null,$limit=null,$offset=null,$in_estaciones=null,$in_sensores=null){
     
      if(!is_null($filtros)){
        if(!empty ($filtros['sens_codigo'])) $query = $this->db->where ('sens_codigo',$filtros['sens_codigo']);
        if(!empty ($filtros['sens_nombre'])) $query = $this->db->like ('sens_nombre',$filtros['sens_nombre']);
        if(!empty ($filtros['sens_estado'])) $query = $this->db->where ('sens_estado',$filtros['sens_estado']);
        if(!empty ($filtros['sens_unid_id'])) $query = $this->db->where ('sens_unid_id',$filtros['sens_unid_id']);
        if(!empty ($filtros['sens_esta_id'])) $query = $this->db->where ('sens_esta_id',$filtros['sens_esta_id']);
        }
        
         if(!is_null($in_estaciones)){
         $query = $this->db->where_in('sens_esta_id',$in_estaciones);    
         }
         
         if(!is_null($in_sensores)){
         $query = $this->db->where_in('sens_id',$in_sensores);    
         }
  
                 
       if($this->session->userdata('rol')!=1)
         $query = $this->db->where('usua_id',$this->session->userdata('usuario_id') );
		
      $query = $this->db->join('estaciones','esta_id=sens_esta_id');
      $query = $this->db->join('usuarios','usua_id=esta_usua_id');
      $query = $this->db->join('unidades','unid_id=sens_unid_id');
      $query = $this->db->get('sensores',$limit,$offset);

      return ($query->num_rows() > 0) ? $query : false;
    }
    
    
}

