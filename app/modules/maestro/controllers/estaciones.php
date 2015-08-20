<?php

class estaciones extends MY_Controller
{
	public function __construct(){
		parent::__construct(); 
                $this->load->model('estaciones_model');
	}

	public function index(){           
            $this->load->model('paginador_model');
            $this->load->library('pagination');

            $filtro = $this->input->post('estaciones');

            $filtros_estaciones = $this->paginador_model->filtro($filtro,'estaciones_filtro');
            /**
             * configuracion de paginacion
             */
            $data['estaciones'] = $this->estaciones_model->get_estaciones($filtros_estaciones);

            $total_rows= (($data['estaciones']==false))? 0 : $data['estaciones']->num_rows();
            $base_url =  site_url('maestro/estaciones/index');
            $config = $this->paginador_model->paginar( $total_rows,$base_url);
            $perpage = $this->paginador_model->get_perpage();
            $this->pagination->initialize($config);
            /**
            * fin paginacion.
            */

            $data['per_page'] = $perpage;

            $data['estaciones']   = $this->estaciones_model->get_estaciones($filtros_estaciones,$perpage,$this->uri->segment(4));

            $data['vista_nueva_estacion'] = $this->load->view('nueva_estacion_view',null,true);
            $data['vista_editar_estacion'] = $this->load->view('editar_estacion_view',null,true);
            $data['vista_buscar_estacion'] = $this->load->view('buscar_estacion_view',null,true);
            
            $menu = array ( array('callback' =>'nueva_estacion();return false;','val' => '<img class="qtip" alt="Nueva estacion"  src="'.base_url().'assets/images/add-files.png" />'),
                            array('callback' =>'buscar_estacion();return false;','val' => '<img class="qtip" alt="Buscar estacion" src="'.base_url().'assets/images/search.png" />'),
                            array('val' => '<img class="qtip" alt="Mostrar todas" src="'.base_url().'assets/images/all.png" />','href' => site_url('maestro/estaciones/todos')),
                           );
             
            $this->run('estaciones_view',$data,'Listado de estaciones', $menu, null,null,'estaciones.js');

      }

        function guardar(){                         
             $estaciones = $this->input->post('estaciones');
             $estaciones['esta_usua_id'] = $this->session->userdata('usuario_id');

              /**
               * se verifica que no exista el codido de la marca
               */
             $result = $this->estaciones_model->buscar('estaciones', Array('esta_codigo'=>$estaciones['esta_codigo'],'esta_usua_id'=>$estaciones['esta_usua_id']));

              if(!$result){
                  $id_esta=$this->estaciones_model->insertar_tablas('estaciones', $estaciones);
                  $estaciones['esta_id'] =  $id_esta;
                  $this->ajax_result(true,"Estaci&oacute;n agregada correctamente, si es su primera estaci&oacute;n actualice la p&aacute;gina" ,$estaciones);
              }else{
                $this->ajax_result(false,"El codigo de la estacion ya existe!");
               }
         }

        function editar(){                            
               $id_estaciones = $this->input->post('id_editar_estacion');
               $estaciones = $this->input->post('estaciones');
               $estaciones['esta_usua_id'] = $this->session->userdata('usuario_id');
               
               $codigo_recibido=$estaciones['esta_codigo'];

               $codigo_actual=  $this->estaciones_model->buscar('estaciones', array('esta_id'=>$id_estaciones));
               $codigo_actual= $codigo_actual->row();
               $codigo_actual= $codigo_actual->esta_codigo;

              if($codigo_recibido==$codigo_actual){

                  $id_estacion = $this->estaciones_model->modificar_tablas('estaciones', 'esta_id',$estaciones, $id_estaciones);

                  if($id_estacion){
                     $estaciones['esta_id']= $id_estacion;
                     $this->ajax_result(true, "Estacion modificada correctamente",$estaciones);
                  }else{$this->ajax_result(false, "No hubo cambios");}

              }else if($codigo_recibido != $codigo_actual ){
                   $result=  $this->estaciones_model->buscar('estaciones', array('esta_codigo'=>$codigo_recibido,'esta_usua_id'=>$estaciones['esta_usua_id']));

                   if($result){
                           $this->ajax_result(false, "El codigo de la estacion ya existe!");
                   }else{
                       $result = $this->estaciones_model->modificar_tablas('estaciones', 'esta_id',$estaciones, $id_estaciones);

                       if($result){
                           $estaciones['esta_id']= $result;
                           $this->ajax_result(true, "Estacion modificada correctamente",$estaciones);
                       }else{$this->ajax_result(false, "No hubo cambios");}
                   }
              }
        }

        function eliminar(){        
        $id = $this->input->post('id');       
        $result = $this->estaciones_model->eliminar('estaciones','esta_id', $id);
        
        if($result){
            $this->ajax_result(true,"Se ha borrado la estacion!") ;
            return true;
        }else{
         $this->ajax_result(false,"No se pudo eliminar") ;
          return true;    
        }
    }
    
        function todos(){
         $this->session->unset_userdata('estaciones_filtro');
	 redirect('maestro/estaciones/index');
        }
              
     function acciones(){
      $esta_id = $this->input->post('esta_id'); 
      $data['vista_nueva_accion'] = $this->load->view('nueva_accion_view',null,true);
      $data['acciones'] = $this->estaciones_model->buscar('acciones',Array('acci_esta_id'=>$esta_id) );
      $this->load->view('acciones_view',$data) ;
     }
     
     function controles(){
      $esta_id = $this->input->post('esta_id'); 
      $this->load->model('sensores_model');
      $data0['sensores'] = $this->sensores_model->get_sensores(Array('sens_esta_id'=>$esta_id) ) ;
      $data0['acciones'] = $this->estaciones_model->buscar('acciones',Array('acci_esta_id'=>$esta_id,'acci_estado'=>'A') );
     
      $data['vista_nuevo_control'] = $this->load->view('nuevo_control_view',$data0,true);
      $data['controles'] = $this->estaciones_model->get_controles(Array('esta_id'=>$esta_id) );
      $this->load->view('controles_view',$data) ;
     }
        
     function eliminar_accion(){
      $acci_id = $this->input->post('acci_id');       
      $result = $this->estaciones_model->eliminar('acciones','acci_id', $acci_id);
        
        if($result){
            $this->ajax_result(true,"Se ha eliminado la accion!") ;
            return true;
        }else{
         $this->ajax_result(false,"No se pudo eliminar") ;
          return true;    
        }    
     }
     
     function eliminar_control(){
      $cont_id = $this->input->post('cont_id');       
      $result = $this->estaciones_model->eliminar('controles','cont_id', $cont_id);
        
        if($result){
            $this->ajax_result(true,"Se ha eliminado el control!") ;
            return true;
        }else{
         $this->ajax_result(false,"No se pudo eliminar") ;
          return true;    
        }    
     }
     
    function guardar_accion(){
     $acciones = $this->input->post('acciones');            
     $acci_id=$this->estaciones_model->insertar_tablas('acciones', $acciones);
     $acciones['acci_id'] =  $acci_id;
     $this->ajax_result(true,"Acci&oacute;n agregada correctamente" ,$acciones);            
    }
    
    function guardar_control(){
     $controles = $this->input->post('control');
            
     $control_id=$this->estaciones_model->insertar_tablas('controles', $controles);
     $controles['cont_id'] =  $control_id;
     $this->ajax_result(true,"Control agregado correctamente" ,$controles);
             
    }
    
    function editar_accion(){
     $acciones = $this->input->post('acciones'); 
     $acci_id  = $this->input->post('acci_id'); 
     $acci_id  = $this->estaciones_model->modificar_tablas('acciones','acci_id',$acciones,$acci_id);
     $this->ajax_result(true,"Acci&oacute;n modificada correctamente" ,$acciones);
    }
}