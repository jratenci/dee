<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of paginador_model
 *
 * @author armando
 */
class paginador_model extends MY_Model{

    public $_por_pagina = 10;
    function __construct() {
        parent::Model();


    }

    function paginar($total_rows=null,$base_url=null){

      /**
       * configuracion de paginacion
       */
        $perpage= $this->input->post('per_page');
        $pagina= $this->input->post('pagina');
        $filtros= null;
        if( $perpage == FALSE){
          $f=$this->session->userdata('por_pagina');
          if(($f) ){
              $perpage = $this->session->userdata('por_pagina');
          }else{
              $perpage=10;
            }
        }else{
            $this->session->set_userdata('por_pagina',$perpage);
        }

        $this->_por_pagina = $perpage;
        
        $config['base_url'] = $base_url;
        $config['total_rows'] = (is_null($total_rows)? 0 : $total_rows);
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 4;
        $config['next_link'] = '<img src='.base_url().'assets/images/btn_next.jpg>';
        $config['prev_link'] = '<img src='.base_url().'assets/images/btn_ant.jpg>';
        $config['pagina'] = $pagina;

        return $config;
    }

    function get_perpage(){
        return $this->_por_pagina;
    }

    function filtro($filtro,$nombre_filtro ){
           
        if( $filtro == FALSE){
          $f=$this->session->userdata($nombre_filtro);
          if(($f) ){
              $filtro = $this->session->userdata($nombre_filtro);
          }else{
              $filtro = null;
            }
        }else{
            $this->session->set_userdata($nombre_filtro,$filtro);
        }

      return $filtro;
    }



}