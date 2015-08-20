<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth_model
 *
 * @author jhon
 */
class auth_model extends MY_Model {

    function __construct() {
        parent::__construct(null);
    }


    function auth_usuario($filtro=null){

      $query = $this->db->where($filtro);
      $query = $this->db->where('usua_estado','A');
      $query = $this->db->join('roles','rol_id=usua_rol_id');     
     
      $query = $this->db->get('usuarios');
 
      return ($query->num_rows() > 0) ? $query->row() : false;
    }
    
    function verificar_usuarios($filtro){
      $query = $this->db->where($filtro);
      $query = $this->db->get('usuarios');
 
      return ($query->num_rows() > 0) ? $query->row() : false;   
    }
    
    function verificar_registro($filtro){
      $query = $this->db->where($filtro);
      $query = $this->db->get('registros');
 
      return ($query->num_rows() > 0) ? $query->row() : false;   
    }
    
    function guardar_registro($registro){
     $this->db->insert('registros', $registro);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();//ultimo insertado
        }else{
            return false;
        }   
    }
    
    function guardar_usuario($usuario){
     $this->db->insert('usuarios', $usuario);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();//ultimo insertado
        }else{
            return false;
        }   
    }
}