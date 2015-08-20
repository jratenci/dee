<?php

class cpromotores extends Controller
{
	protected $_main_table='cli';
	protected $_key = 'cli_ced';


	public function cpromotores()
	{
		parent::Controller();
		$this->load->model('proy_model');
	}
	
	//ensayo
	

    /**
	 * index
	 *
	 * @param String vid id del cliente en la bd
	 */
	public function index( $cli = null )
	{
		$fi = $this->input->post('fi');
        $ff = $this->input->post('ff');

        if($fi == FALSE) $fi = date('d/m/Y');
        if($ff == FALSE) $ff = date('d/m/Y');

		$content['fi'] = $fi;
        $content['ff'] = $ff;

        $fi = date_to_mysql($fi) . ' 00:00';
        $ff = date_to_mysql($ff) . ' 23:00';

        if(is_null($cli))
        {
			$cli = $this->input->post('cli');
			if($cli == FALSE)
				$cli = NULL;
		}
        $fechas_seleccionadas_comision = array( 'fi' => $fi, 'ff' => $ff );

        $content['cli'] = $cli;
		// Informacion del cliente
        $content['cliente'] = $this->proy_model->get($cli);
		// Recuperar la informacion de los referente 1

        $content['referentes_uno'] = $this->proy_model->get_referrings($cli,1, array('fi'=>$fi,'ff' => $ff) );
         // echo json_encode($content);
        // Recuperar la informacion de los referente 2
        $content['referentes_dos'] = $this->proy_model->get_referrings($cli,2,array('fi'=>$fi,'ff' => $ff));
          //adicion de estado pago

          $content['payed'] = $this->proy_model->checLiqProm(
			date_to_mysql($content['fi']),
			date_to_mysql($content['ff']),
            //$this->session->userdata('bod_cod'),
			$cli
		);
        $this->session->set_userdata($fechas_seleccionadas_comision);

        // que tengan ventas.



		// Set comisions dates to Session

		$this->load->view('comisiones_format_view',$content);

		//$this->run('comisiones_format_view',$content,' Liquidación de Comisiones ', $menu, array('date', 'jquery.datePicker'), array('datePicker'));
	}


	}
