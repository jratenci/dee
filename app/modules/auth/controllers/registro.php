<?php
class registro extends Controller
{
	public function __construct()
	{
		parent::__construct();
                $this->load->model('auth_model');
	}
	
	function guardar(){
        $registro = $this->input->post('registro');
        
        //se verifica que no exista el nombre de usuario EN LA LISTA DE USUARIOS
        $existe = $this->auth_model->verificar_usuarios(Array('usua_usuario'=>$registro['regi_usuario']));
        
        if($existe){
          $result['ret'] = false;
          $result['msg'] = 'Lo sentimos el nombre de usuario ya existe';   
          echo json_encode($result);
          return false;
        }
        // si no existe entonces se almacena y se elvia un correo con el id
        $registro['regi_fechasistema'] = Date('Y-m-d H:i:s');
        $id = $this->auth_model->guardar_registro($registro);
        
        if($id){
        //se envia el correo con la direccion de activacion.
        $envia =  $this->correo($registro['regi_correo'],$id);
        
        $result['ret'] = true;
        $result['msg'] = 'Se ha enviado un correo para confirmacion<br/> por favor revisa que no sea Spam.';
        echo json_encode($result);     
            
        }else{
        $result['ret'] = false;
        $result['msg'] = 'Error al guardar el registro.';
        echo json_encode($result);   
        }
                
        }
        
  function correo($correo=null,$id=null){     
   $this->load->library('email');
   $config['mailtype'] = 'html';

   $this->email->initialize($config);
   $this->email->from('jhon.atencio@gmail.com', 'CrisolDEE');
   $this->email->to($correo);

   $this->email->subject('Activacion CrisolDEE');
   $msg ='Gracias por registrarse en CrisolDEE<br/> para confirmar su cuenta siga el link <a href="'.site_url().'auth/registro/confirmacion/'.$id.'">Confirmacion</a>';
   $this->email->message($msg);

   $v = $this->email->send();
 
   return true;
 
}

  function confirmacion($id_registro){
    //se verifica que si este en estado pendiente
    $p =  $this->auth_model->verificar_registro(Array('regi_id'=>$id_registro));
       
    if($p->regi_estado=='P'){
    // se procede con el almacenamiento en la tabla usuarios
    $usuario = Array('usua_nombre'=>$p->regi_nombre,'usua_usuario'=>$p->regi_usuario,'usua_clave'=>$p->regi_clave,
                     'usua_correo'=>$p->regi_correo,'usua_fechacreado'=>Date('Y-m-d H:i:s'),'usua_regi_id'=>$id_registro,
                     'usua_rol_id'=>2);
    
    $id = $this->auth_model->guardar_usuario($usuario); 
    $credenciales = Array(
                     'logged_in'=>true,
                     'rol'=>2,
                     'rol_nombre'=>'USUARIO',
                     'usuario_nombre'=>$p->regi_nombre,
                     'usuario_id'=>$id,
                     'usuario_clave'=>$p->regi_clave, 
                     'usuario_usuario'=>$p->regi_usuario, 
                     'usuario_correo'=>$p->regi_correo, 
                 );
     $this->session->set_userdata($credenciales);
     
     //actualizamos el registro a estado Activado
     $this->auth_model->modificar_tablas('registros','regi_id',Array('regi_estado'=>'A'),$id_registro);
     redirect('control/inicio');
    }else{
     redirect('auth/inicio/index/registrado');
    }
    
  }
  
  function recordar(){
  $recordar = $this->input->post('recordar'); 
  
   if(empty($recordar['usua_correo'])){
   $result['ret'] = false;
   $result['msg'] = 'el correo es necesario.';
   echo json_encode($result);  
   return false;
  }
  
  
  $usuario = $this->auth_model->buscar('usuarios',$recordar);   
 
  if($usuario){
   $usuario = $usuario->row();   
   
   $this->load->library('email');
   $config['mailtype'] = 'html';

   $this->email->initialize($config);
   $this->email->from('jhon.atencio@gmail.com', 'CrisolDEE');
   $this->email->to($usuario->usua_correo);

   $this->email->subject('Recordatorio de clave CrisolDEE');
   $msg ='Usuario : '.$usuario->usua_usuario.'<br/> Clave :'.$usuario->usua_clave;
   $this->email->message($msg);

   $v = $this->email->send();
   
   $result['ret'] = true;
   $result['msg'] = 'Se te ha enviado un correo, por favor revisa que no sea SPAM';
   echo json_encode($result);   
  }else{
   $result['ret'] = false;
   $result['msg'] = 'El correo no existe!';
   echo json_encode($result);      
  }
  }
  
}
