<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of unidades_model
 *
 * @author erick
 */
class unidades_model extends MY_Model
{
    function __construct() {
        parent::Model();
    }

     function get_unidades($filtros=null, $limit=null, $offset=null)
     {
         if(!is_null($filtros)){
            if(!empty ($filtros['unid_codigo'])) $query = $this->db->where ('unid_codigo',$filtros['unid_codigo']);
            if(!empty ($filtros['unid_nombre'])) $query = $this->db->like ('unid_nombre',$filtros['unid_nombre']);
            if(!empty ($filtros['unid_estado'])) $query = $this->db->like ('unid_estado',$filtros['unid_estado']);
 
         }
         
         if($this->session->userdata('rol')!=1)
         $query = $this->db->where('usua_id',$this->session->userdata('usuario_id') );
			

         $query= $this->db->join('usuarios', 'usua_id=unid_usua_id');
         $query= $this->db->get('unidades',$limit,$offset);

         return ($query->num_rows() >0) ? $query : false;
     }

       
}