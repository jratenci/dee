<?
class cconsulta extends Controller
{
public function cconsulta()
	{
		parent::Controller();
		$this->load->model('ord_model');
        $this->load->model('cuot_model');
        $this->load->model('ordd_model');
        
        if(!$this->session->userdata('logged_user'))
			redirect('auth/inicio');

		$this->ACTUAL_MODULE = $this->uri->segment(1);
        $this->COMP_NIT = $this->session->userdata('com_nit');
        $this->COMP_NAME = $this->session->userdata('com_nom');

		$this->default_menu = array (
				 array('val' => '<img src="'.base_url().'assets/images/add-files.png" />','title' => 'Agregar una Registro'),
				 array('val' => '<img src="'.base_url().'assets/images/search.png" />','title' => 'Buscar un registro'),
				 array('val' => '<img src="'.base_url().'assets/images/pdf.png" />','title' => 'Exportar a PDF'),
				 array('val' => '<img src="'.base_url().'assets/images/xls.png" />','title' => 'Exportar a Excel')
		);

		$this->output->enable_profiler( $this->config->item('enable_profiler') );
        
	}
	
	
          public function consultar1($nced){
          
          $this->load->model('mconsulta');
             $result=$this->mconsulta->consultar($nced);
             if($result!=NULL){
                //echo "funciona";
                foreach ($result->result() as $row)
                {
   //echo $row->cli_nom;
     $arreglo=array('usuario'=>$row->cli_nom,
                    'cedula'=>$row->ord_cli,
                    'cuota'=>$row->ord_total_ord);
                     $this->load->view('vista1',$arreglo);
}

                     }else{
  $arreglo=array('success'=>false,'errors'=>array('reason'=>'clave incorrecta'));
      echo json_encode($arreglo);
      }
          }


     public function proyeccion($ord_num)
     
    {
    
    $sql="SELECT * FROM nerp_ventas WHERE ord_num=? AND ord_cli=?";
     $query = $this->db->query($sql,array($ord_num,$this->session->userdata('user')));

		if($query->num_rows>0 &&$this->session->userdata('logged_user')==TRUE ){
    
        $this->load->model('cli_model');
        // Informacion de la proyeccion.
        $content['tbl_data'] = $this->cuot_model->get( array('ord_num' => $ord_num ));

        // Informacion del cliente
        $content['cliente'] = $this->ord_model->get(array('ord_num' => $ord_num));
        $content['cliente'] = (is_null($content['cliente'])) ? NULL : $content['cliente']->row();
		$content['ord_num'] = $ord_num;
	$content['id_num'] = $this->db->get_where('ord',array('ord_num'=>$ord_num))->row()->ord_id;
	   $content['id_num'] = (is_null($content['id_num'])) ? NULL : $content['id_num'];
       $content['descuentos'] = $this->db->get_where('descuentos',array('des_id_num' => $content['id_num']) );



            $this->load->view('proy_view',$content);
            }
           }




      public function logout()
	{
	$this->session->sess_destroy();
 //$url="http://localhost/sontennis1/";
 //echo "<SCRIPT>window.location='$url';</SCRIPT>";
 header ("Location: http://www.sontenis.com/");
	}


        }


?>
