<?php

class Stock extends MY_Controller
{
	private $stock_insertados 	= 0;
	private $pro_insertados 	= 0;
	private $mar_not_finded 	= 0;
	private $existented_products= 0;
	private $updateds_stock 	= 0;
	private $bod_cod			= '004';
	private $general_sum		= 0;
	function __construct(){
		parent::__construct();
	}

	function map($file){
		if(!file_exists($file))
		{
			echo 'EL archivo ' . $file . ' no existe.';
			exit -1;
		}
		
		$l = fopen($file,'r');
		$line = 0;
		while($line = fgets($l))
		{
			
			$fields = explode( '|',$line );
			//echo '<pre>'.var_export($fields,true).'</pre>';
			$fields[1] = str_replace( '-','',$fields[1] );
			
			$mar_cod = $this->get_mar_id( trim($fields[0] ) );

			/// Revisamos si existe o no un producto con esta referencia
			$exits = $this->chek_product( $fields[1] );
			if($exits)
			{
				$this->existented_products++;
			}
			else
			{
				if(is_null($mar_cod))
				{
					echo "No se encontro el cod de la mar " . $fields[0] . " Registro = " . $line;
					$this->mar_not_finded++;
				}
				else {
					// Ingresamos el producto unitario.
					$pro = array 
						(
							'pro_ref' 	=> trim($fields[1]),
							'pro_prov' 	=> '1128269982-9',
							'pro_nom'   => '',
							'pro_lin'   => trim($fields[59]),
							'pro_cat'   => trim($fields[60]),
							'pro_mar'   => trim($mar_cod),
							'pro_des'	=> trim($fields[58]),
							'fecha_sys' => date('Y-m-d h:i:s')
							
						);
					$this->db->insert( 'pro', $pro );
					$this->pro_insertados++;
				}
			}
			// Insertamos las existencias,
			// posamos la referencia y las tallas
			$this->insert_stock
						(
						$fields[1],
						array(
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
							 )
						);
			$line++;
		}

		$this->imp();
	}
	
	function insert_stock( $ref, $cantidades )
	{
		$index = 1;
		$sum_inserted=0;
		foreach($cantidades as $cant){
			$cant = trim($cant);
			if(!empty($cant))
			{
				$stock_data = array(
						'st_ref' => str_replace('-','',$ref),
						'st_bod' => $this->bod_cod,
						'st_unit' => $cant,
						'st_unm' => $index,
						'st_min' => 3,
						'st_max' => 24,
						'st_acced' => date('Y-m-d h:i:s'),
				 );
				  
				// Comprobamos is existe ono un stock para esta referencia en esta bodega de esta talla
				$id = $this->chek_stock($ref,$this->bod_cod,$index);
				if($id)
				{
					$this->update_stock( $id,$stock_data );
					$this->updateds_stock++;
				}
				else
				{
					$this->db->insert( 'stock',$stock_data );
					$this->stock_insertados++;
				}
			}
			$index++;
			$sum_inserted += $cant;
		}
		$this->general_sum += $sum_inserted;
	}

	function update_stock($id,$data)
	{
		$actual_units = $this->db->get_where('stock',array('st_id' => $id), 1);
		$actual_units = $actual_units->row()->st_unit;

		// sumamos las cantidades actuales a las nuevas.
		$data['st_unit'] =$data['st_unit'] + $actual_units;
		//echo '<pre>'.var_export($data,true) . '</pre>';
		// actualizamos
		$this->db->where('st_id',$id);
		$this->db->update('stock',$data);

		
		return($this->db->affected_rows() > 0 ) ?  $this->db->affected_rows() : NULL;
	}
	
	function get_mar_id($mar){
		$mar = strtolower( trim($mar) );
		
		$data = $this->db->get('mar');
		
		foreach($data->result() as $d){
			$omar = strtolower(trim($d->mar_nom));
			if($omar === $mar){
				return $d->mar_cod;
			}
		}
		return NULL;
	}
	
	function chek_product($ref){
		$ref = strtolower(str_replace('-','',$ref));

		$data = $this->db->get('pro');
		
		foreach( $data->result() as $d )
		{
			$oref = $d->pro_ref;
			if($oref === $ref){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	function chek_stock( $ref, $bod,$tal  ){
		$ref = strtolower(str_replace('-','',$ref));
		$bod = trim($bod);
		$tal = trim($tal);
		
		$data = $this->db->get_where( 'stock', array('st_ref' => $ref, 'st_bod' => $bod, 'st_unm' => $tal), 1 );
		

		return($data->num_rows() > 0 ) ? $data->row()->st_id : FALSE;
	}

	function imp(){
		echo "PRODUCTOS YA EXISTENTES = " . $this->existented_products . "<br/>";
		echo "PRODUCTOS INSERTADOS = " . $this->pro_insertados . "<br/>";
		echo "STOCK INSERTADOS = " . $this->stock_insertados . "<br/>";
		echo "STOCK ACTUALIZADO = " . $this->updateds_stock . "<br/>";
		echo "MARCAS NO ENCONTRADAS = " . $this->mar_not_finded . "<br/>";
		echo "TOTAL PARES INGRESADOS = " . $this->general_sum . "<br/>";
	}
}
