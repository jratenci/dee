<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario_model
 *
 * @author jhon
 */
class usuario_model extends MY_Model {
    function __construct() {
        parent::Model();
    }

    function get_usuarios($filtros=null,$limit=null,$offset=null){
     
      if(!is_null($filtros))
      {
       if(!empty ($filtros['usua_cedula'])) $query = $this->db->where ('usua_cedula',$filtros['usua_cedula']);
       if(!empty ($filtros['usua_nombre'])) $query = $this->db->like ('usua_nombre',$filtros['usua_nombre']);
       if(!empty ($filtros['rol_id'])) $query = $this->db->where('rol_id',$filtros['rol_id']);
    
      }
   
      $query = $this->db->join('roles','rol_id=usua_rol_id');
      $query = $this->db->join('bodegas','bode_id=usua_bode_id');
      $query = $this->db->get('usuarios',$limit,$offset);

      return ($query->num_rows() > 0) ? $query : false;
    }
}

