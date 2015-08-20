<?php

class Trans extends MY_Controller
{
	private $date;
	private $origen = '004';
	private $destino = '001';
	private $general_sum = 0;
	function __construct(){
		parent::__construct();
		$this->load->module_model('inventario','stock_model');
		$this->date=date('Y-m-d h:i:s');
	}

	function map($file,$destino,$comment = ""){
		$this->destino = $destino;
		if(!file_exists($file))
		{
			echo 'EL archivo ' . $file . ' no existe.';
			exit -1;
		}
		
		$l = fopen($file,'r');
		$lines = 0;
		
		
		$header = array (
			'tran_src' => $this->origen,
			'tran_dst' => $this->destino,
			'tran_us'  => 1,
			'tran_date' => $this->date,
			'tran_notes' => $comment
		);

		$id = $this->db->insert('trans',$header);
		$id = $this->db->insert_id();
		echo 'DOCUMENTO REALIZADO.<br/>';
		
		while($line = fgets($l))
		{
			$fields = explode( '|',$line );
			$this->insert_tran_det(
				$id,
				str_replace('-','',$fields[1]),
				array
				(
				  $fields[2],
				  $fields[3],
				  $fields[4],
				  $fields[5],
				  $fields[6],
				  $fields[7],
				  $fields[8],
				  $fields[9],
				  $fields[10],
				  $fields[11],
				  $fields[12],
				  $fields[13],
				  $fields[14],
				  $fields[15],
				  $fields[16],
				  $fields[17],
				  $fields[18],
				  $fields[19],
				  $fields[20],
				  $fields[21],
				  $fields[22],
				  $fields[23],
				  $fields[24],
				  $fields[25],
				  $fields[26],
				  $fields[27],
				  $fields[28],
				  $fields[29],
				  $fields[30],
				  $fields[31],
				  $fields[32],
				  $fields[33],
				  $fields[34],
				  $fields[35],
				  $fields[36],
				  $fields[37],
				  $fields[38],
				  $fields[39],
				  $fields[40],
				  $fields[41],
				  $fields[42],
				  $fields[43],
				  $fields[44],
				  $fields[45],
				  $fields[46],
				  $fields[47],
				  $fields[48],
				  $fields[49],
				  $fields[50],
				  $fields[51],
				  $fields[52],
				  $fields[53],
				  $fields[54],
				  $fields[55],
				  $fields[56],
				  $fields[57]
				),
				$fields[58]
			);
		}

		echo 'TOTAL TRANSLADADOS = ' . $this->general_sum . '<br/>';
	}

	function insert_tran_det($tran, $ref, $cantidades, $price )
	{
		$index = 1;
		$sum_inserted=0;
		foreach($cantidades as $cant){
			$cant = trim($cant);
			if(!empty($cant))
			{
				$record =
				array
				(
						'trand_tran' => $tran,
						'trand_ref' => $ref,
						'trand_unm' => $index,
						'trand_unit' => $cant,
						'trand_date' => $this->date,
						'trand_bod' => $this->origen,
						'trand_price' => $price,
				);
				
				// Insertamos el detalle
				$this->db->insert( 'trans_det', $record );
				// Actualizamos origen
				$result = $this->stock_model->update_stock( $ref, $this->origen,$index,$cant,FALSE,$price );
				
				// Actualizamos destino
				$result = $this->stock_model->update_stock( $ref, $this->destino,$index,$cant,TRUE,$price );
				//echo "Referencia transladada<br/>";
				//echo var_export( $record,true );
			}
			$index++;
			$sum_inserted += $cant;
		}
		echo "Ref = $ref  Cantidad = $sum_inserted<br/>";
		$this->general_sum += $sum_inserted;
	}
}
