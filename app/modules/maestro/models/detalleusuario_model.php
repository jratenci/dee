<?php

class detalleusuario_model extends MY_Model
{
    function __construct()
    {
      parent::Model();
    }
    function get_usuario($filtros=null)
    {
        if(!is_null($filtros)){
        if(!empty ($filtros['usua_id'])) $query=$this->db->where('usua_id',$filtros['usua_id']);
        }
        $query= $this->db->join('roles','usua_rol_id=rol_id');       
        $query= $this->db->get('usuarios');

        return ($query->num_rows()>0) ? $query : false;
        
    }

}