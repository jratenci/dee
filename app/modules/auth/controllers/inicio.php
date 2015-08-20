<?php
class Inicio extends Controller
{
	public function __construct()
	{
		parent::__construct();
                $this->load->model('auth_model');
	}
	
	public function index($msg=null)
        {
         $data['msg']=$msg;
         $data['vista_registro'] = $this->load->view('registro_view',null,true);
         $data['vista_recordar'] = $this->load->view('recordar_clave_view',null,true);
         $this->load->view('auth_view',$data);
        }
	      
        function valid_user()
        {
        $msg = "Error";
        $usuario = $this->input->post('usuario');

        $result =  $this->_validar($usuario);
        if($result){
          redirect('control/inicio');
        }else{
         redirect('auth/inicio/index/'.$msg);
        }
        }

        //validation function
        
        function _validar($usuario){
            $result = $this->auth_model->auth_usuario($usuario);
            if($result){
                 $credenciales = Array(
                     'logged_in'=>true,
                     'rol'=>$result->rol_id,
                     'rol_nombre'=>$result->rol_nombre,
                     'usuario_nombre'=>$result->usua_nombre,
                     'usuario_id'=>$result->usua_id,
                     'usuario_clave'=>$result->usua_clave, 
                     'usuario_usuario'=>$result->usua_usuario,
                     'usuario_correo'=>$result->usua_correo, 
                 
                 );
             $this->session->set_userdata($credenciales);
             return true;
            }else{
             return false;
            }
            
        }

        public function logout(){
	$this->session->sess_destroy();
	redirect('auth/inicio');
	}
        
        function tacometro(){
            $this->load->view('tacometro_view',null);
        }
        
        function tacometrom(){
            $this->load->view('tacometrom_view',null);
        }

        function dato_tacometro(){
           $query = $this->db->get('tacometro',1);
           ($query->num_rows() > 0) ? $result['dato']=$query->row()->taco_valor : $result['dato']=0;   
           
         
           echo json_encode($result);     
            
        }
         function guardar_tacometro($valor=0){
             $dato = Array('taco_valor'=>$valor,'taco_fecha'=>Date('Y-m-d H:i:s'));
             $this->db->update('tacometro', $dato);            
         }
}
