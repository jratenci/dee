<?php

class sensores extends MY_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('sensores_model');       
    }

    function index(){
      $this->load->model('paginador_model');
      $this->load->library('pagination');  
      $filtro_sensores = $this->input->post('sensores');

      $filtros_sensores = $this->paginador_model->filtro($filtro_sensores,'sensores_filtro');
        /**
         * configuracion de paginacion
         */
      $data['sensores'] = $this->sensores_model->get_sensores($filtros_sensores);
      $total_rows= (($data['sensores']==false))? 0 : $data['sensores']->num_rows();
      $base_url =  site_url('maestro/sensores/index');
      $config = $this->paginador_model->paginar( $total_rows,$base_url);
      $perpage = $this->paginador_model->get_perpage();
      $this->pagination->initialize($config);
        /**
        * fin paginacion.
        */

      $data['per_page'] = $perpage;

      $data['sensores'] = $this->sensores_model->get_sensores($filtros_sensores,$perpage,$this->uri->segment(4));
      $data0['unidades'] = $this->sensores_model->buscar('unidades',Array('unid_usua_id'=>$this->session->userdata('usuario_id'),'unid_estado'=>'A') );
     
      $data0['estaciones']=$this->sensores_model->buscar('estaciones',Array('esta_usua_id'=>$this->session->userdata('usuario_id'),'esta_estado'=>'A'));
      
      $data['vista_nuevo_sensor'] = $this->load->view('nuevo_sensor_view',$data0,true);
      $data['vista_editar_sensor'] = $this->load->view('editar_sensor_view',$data0,true);
      $data['vista_buscar_sensor'] = $this->load->view('buscar_sensor_view',$data0,true);
   
      
      $menu = array ( array('callback' =>'nuevo_sensor();return false;','val' => '<img class="qtip" alt="Nuevo sensor"  src="'.base_url().'assets/images/add-files.png" />'),
              array('callback' =>'buscar_sensor();return false;','val' => '<img class="qtip" alt="Buscar sensor" src="'.base_url().'assets/images/search.png" />'),
              array('val' => '<img class="qtip" alt="Mostrar todos" src="'.base_url().'assets/images/all.png" />','href'=>site_url('maestro/sensores/todos')),
             );      
      

      $this->run('sensores_view',$data,'Listado de sensores', $menu, null,null,'sensores.js');
    }
    
   
    function guardar(){
      $sensores  = $this->input->post('sensores');  
      $sensores['sens_estado'] = "A";
      $id_sensor =  $this->sensores_model->insertar_tablas('sensores', $sensores);
      $sensores['sens_id'] =  $id_sensor;
      $this->ajax_result(true,"Sensor agregado correctamente, si es su primer sensor actualice la página" ,$sensores);
       
    }
   
    function editar(){
     $edit_sensor_id  = $this->input->post('edit_sensor_id');    
     $sensores        = $this->input->post('sensores'); 
     $codigo_recibido = $sensores['sens_codigo'];
     
     $codigo_actual = $this->sensores_model->buscar('sensores', array('sens_id'=>$edit_sensor_id));
     $codigo_actual = $codigo_actual->row();
     $codigo_actual = $codigo_actual->sens_codigo;
     
     if($codigo_recibido==$codigo_actual){
         $result = $this->sensores_model->modificar_tablas('sensores', 'sens_id',$sensores, $edit_sensor_id);
           if($result){
              $sensores['sens_id']=$edit_sensor_id;
              $this->ajax_result(true, "Sensor modificado correctamente",$sensores);
            }else{$this->ajax_result(false, "No hubo cambios!");}
     
            
     }else if($codigo_recibido != $codigo_actual ){
           $result=  $this->sensores_model->get_sensores(array('sens_codigo'=>$codigo_recibido));
           if($result){
              $this->ajax_result(false, "El codigo del sensor ya existe!");
           }else{
            $result = $this->sensores_model->modificar_tablas('sensores', 'sens_id',$sensores, $edit_sensor_id);
            if($result){
               $sensores['sens_id']=$result;
               $this->ajax_result(true, "Sensor modificado correctamente",$sensores);
            }else{$this->ajax_result(false, "No hubo cambios!");}
       }
          }

     
    }
   
    function eliminar(){        
       $id = $this->input->post('id');       
       $result = $this->sensores_model->eliminar('sensores','sens_id', $id);        
        if($result){
            $this->ajax_result(true,"Se ha borrado el sensor!") ;
            return true;
        }else{
         $this->ajax_result(false,"No se pudo eliminar") ;
          return true;    
        }
    }
      
    function todos(){
        $this->session->unset_userdata('sensores_filtro');
        redirect('maestro/sensores/index');
    }
    
    function load_grafica($sens_id=null){
     $data['sens_id'] = $sens_id ;   
     $this->load->view('live_grafica_view', $data);   
    }
}
