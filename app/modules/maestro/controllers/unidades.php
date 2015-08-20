<?php

class unidades extends MY_Controller
{

    function __construct() {

      parent::__construct();
      $this->load->model('unidades_model');
            
    }

    function index(){
      $this->load->library('pagination');
      $this->load->model('paginador_model');  
      $filtro_unidad = $this->input->post('unidades');
      $filtros_unidad = $this->paginador_model->filtro($filtro_unidad,'unidad_filtro');
        /**
         * configuracion de paginacion
         */
      $data['unidades']=  $this->unidades_model->get_unidades($filtros_unidad) ;
      $total_rows= (($data['unidades'])==false)? 0 : $data['unidades']->num_rows();
      $base_url =  site_url('maestro/unidades/index');
      $config = $this->paginador_model->paginar( $total_rows,$base_url);
      $perpage = $this->paginador_model->get_perpage();
      $this->pagination->initialize($config);
       /**
        * fin paginacion.
        */
      $data['per_page'] = $perpage;



      $data['unidades']=  $this->unidades_model->get_unidades($filtros_unidad,$perpage,$this->uri->segment(4)) ;
      $data['nueva_unidad_view']=  $this->load->view('nueva_unidad_view',null,true);
      $data['editar_unidad_view']=  $this->load->view('editar_unidad_view',null,true);
      $data['buscar_unidad_view']=  $this->load->view('buscar_unidad_view',null,true);

      
      $menu = array ( array('callback' =>'agregar_unidad();return false;','val' => '<img class="qtip" alt="Nueva unidad" src="'.base_url().'assets/images/add-files.png" />'),
                      array('callback' =>'buscar_unidades();return false;','val' => '<img class="qtip" alt="Buscar unidad" src="'.base_url().'assets/images/search.png" />'),
                      array('val' => '<img class="qtip" alt="Mostrar todas" src="'.base_url().'assets/images/all.png" />','href'=>site_url('maestro/unidades/todos'))
                      );
       
      
      $this->run('unidades_view',$data,'Listado de unidades',$menu,null,null,'unidades.js');
    }

    function guardar(){
        $unidades = $this->input->post('unidades');
        $unidades['unid_usua_id'] = $this->session->userdata('usuario_id');
      
       /**
        * se verifica si el codigo de la unidad existe
        */
       $result=$this->unidades_model->buscar('unidades', array('unid_codigo'=>$unidades['unid_codigo'],'unid_usua_id'=>$unidades['unid_usua_id']));

       if(!$result){           
               $result= $this->unidades_model->insertar_tablas('unidades',$unidades);
               if($result){
                   $unidades['unid_id']=$result;
                   $this->ajax_result(true,"Unidad agregada correctamente, si es su primera unidad actualice la página",$unidades);
               }else{$this->ajax_result(false,"La unidad no fue guardada");}
       }else{$this->ajax_result(false,"El codigo de la unidad ya existe!");}
    }

    function editar_unidad(){
        $id =  $this->input->post('id_editar_unidad');
        $unidades = $this->input->post('unidades');
        $unidades['unid_usua_id'] = $this->session->userdata('usuario_id');
        $codigo_recibido=$unidades['unid_codigo'];

        $codigo_actual=  $this->unidades_model->buscar('unidades', array('unid_id'=>$id));
        $codigo_actual= $codigo_actual->row();
        $codigo_actual= $codigo_actual->unid_codigo;

          if($codigo_recibido==$codigo_actual){

              $result = $this->unidades_model->modificar_tablas('unidades', 'unid_id',$unidades, $id);

              if($result){
                  $unidades['unid_id']=$result;
                  $this->ajax_result(true, "Unidad modificada correctamente",$unidades);
              }else{$this->ajax_result(false, "No hubo cambios!");}

          }else if($codigo_recibido != $codigo_actual ){
               $result=  $this->unidades_model->buscar('unidades', array('unid_codigo'=>$codigo_recibido,'unid_usua_id'=>$unidades['unid_usua_id']));

               if($result){
                       $this->ajax_result(false, "El codigo de la unidad ya existe!");
               }else{
                   $result = $this->unidades_model->modificar_tablas('unidades', 'unid_id',$unidades, $id);

                   if($result){
                       $unidades['unid_id']=$result;
                       $this->ajax_result(true, "Unidad modificada correctamente",$unidades);
                   }else{$this->ajax_result(false, "No hubo cambios!");}
               }
          }
    }

    function eliminar(){
        $id = $this->input->post('id');       
        $result = $this->unidades_model->eliminar('unidades','unid_id', $id);
        
        if($result){
            $this->ajax_result(true,"Se ha borrado la unidad!") ;
            return true;
        }else{
         $this->ajax_result(false,"No se pudo eliminar") ;
          return true;    
        }
    }

     function todos(){
        $this->session->unset_userdata('unidad_filtro');
	redirect('maestro/unidades/index');
     }

}