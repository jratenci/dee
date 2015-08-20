<?php

class detalleusuario extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('detalleusuario_model');
    }
    function index()
    {
        $menu= Array( Array('callback'=>'editar_usuario(); return false;','val'=>'<img class="qtip" alt="Actualizar Clave" src="'.base_url().'assets/images/save.png" />'));

        $data['usuario']= $this->detalleusuario_model->get_usuario(array('usua_id'=>$this->session->userdata('usuario_id')));
        $data['usuario']=$data['usuario']->row();       
        $this->run('detalleusuario_view', $data, 'Detalle del usuario', $menu, null,null,'detalleusuario.js');
     }
    function editar(){
      $usuario=$this->input->post('usuarios');
      $id_usuario= $this->session->userdata('usuario_id');
               

      $result = $this->detalleusuario_model->modificar_tablas('usuarios', 'usua_id',$usuario, $id_usuario);

      if($result){$this->ajax_result(true, "Usuario modificado");
      
      }else{$this->ajax_result(true, "No hubo cambios");}
          
     
    }


}