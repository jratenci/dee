<?php

class usuario extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
                $this->load->model('usuario_model');
                $this->load->model('paginador_model');
                $this->load->library('pagination');
                
	}

	public function index()
        {

        $filtro_usuario = $this->input->post('usuario');

        $filtros_usuario = $this->paginador_model->filtro($filtro_usuario,'usuario_filtro');
        /**
         * configuracion de paginacion
         */
        $data['usuarios'] = $this->usuario_model->get_usuarios($filtros_usuario);
      
        $total_rows= (($data['usuarios']==false))? 0 : $data['usuarios']->num_rows();
        $base_url =  site_url('maestro/usuario/index');
        $config = $this->paginador_model->paginar( $total_rows,$base_url);
        $perpage = $this->paginador_model->get_perpage();
        $this->pagination->initialize($config);
        /**
        * fin paginacion.
        */
    
        $data['per_page'] = $perpage;

        $data['usuarios'] = $this->usuario_model->get_usuarios($filtros_usuario,$perpage,$this->uri->segment(4));
        $data0['roles'] = $this->usuario_model->buscar('roles');
        $data0['bodegas'] = $this->usuario_model->buscar('bodegas',Array('bode_estado'=>'A'));
     
        $data['vista_nuevo_usuario'] = $this->load->view('nuevo_usuario_view',$data0,true);
        $data['vista_editar_usuario'] = $this->load->view('editar_usuario_view',$data0,true);
        $data['vista_buscar_usuario'] = $this->load->view('buscar_usuario_view',$data0,true);

        $menu = array ( array('callback' =>'nuevo_usuario();return false;','val' => '<img class="qtip" alt="Nuevo Usuario"  src="'.base_url().'assets/images/add-files.png" />'),
                        array('callback' =>'buscar_usuario();return false;','val' => '<img class="qtip" alt="Buscar Usuario" src="'.base_url().'assets/images/search.png" />'),
                        array('val' => '<img class="qtip" alt="Mostrar Todos" src="'.base_url().'assets/images/all.png" />','href' => site_url('maestro/usuario/todos')),
                       );

        $this->run('usuarios_view',$data,'Listado de usuarios', $menu, null,null,'usuario.js');

      }

        function guardar()
        {
         $result=0;
         $usuario = $this->input->post('usuarios');
         $usuario['usua_fecha'] = date("Y-m-d");

          /**
           * se verifica si la cedula del usuario existe
           */
         $result = $this->usuario_model->buscar('usuarios', Array('usua_cedula'=>$usuario['usua_cedula']));

          if(!$result){
                  $result=$this->usuario_model->insertar_tablas('usuarios', $usuario);
                  if($result){
                       $usuario['usua_id']=$result;
                        $this->ajax_result(true,"Usuario agregado correctamente",$usuario);
                  }else{ $this->ajax_result(true,"No se pudo agregar el usuario");}
           }else{
            $this->ajax_result(false,"La cedula ya existe!");
           }
         }

         function editar()
         {
           $id_usuario = $this->input->post('id_editar_usuario');
           $usuario = $this->input->post('usuarios');

           $codigo_recibido=$usuario['usua_cedula'];

           $codigo_actual=  $this->usuario_model->buscar('usuarios', array('usua_id'=>$id_usuario));
           $codigo_actual= $codigo_actual->row();
           $codigo_actual= $codigo_actual->usua_cedula;

          if($codigo_recibido==$codigo_actual){

              $result = $this->usuario_model->modificar_tablas('usuarios', 'usua_id',$usuario, $id_usuario);

              if($result){
                  $usuario['usua_id']=$result;
                  $this->ajax_result(true, "Usuario modificado correctamente",$usuario);
              }else{$this->ajax_result(false, "El usuario no fue editado");}

          }else if($codigo_recibido != $codigo_actual ){
               $result=  $this->usuario_model->buscar('usuarios', array('usua_cedula'=>$codigo_recibido));

               if($result){
                       $this->ajax_result(false, "La cedula del cliente ya existe!");
               }else{
                   $result = $this->usuario_model->modificar_tablas('usuarios', 'usua_id',$usuario, $id_usuario);

                   if($result){
                       $usuario['usua_id']=$result;
                       $this->ajax_result(true, "Usuario modificado correctamente",$usuario);
                   }else{$this->ajax_result(false, "El usuario no fue editado");}
               }
          }
        }

        function todos()
        {
         $this->session->unset_userdata('usuario_filtro');
	 redirect('maestro/usuario/index');
        }
              
     
}