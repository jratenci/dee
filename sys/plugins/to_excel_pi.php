<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



/*

* Excel library for Code Igniter applications

* Author: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006

* Edit by: kmil0 for work with nerp

*

* @params $query CIDBObject

* @params $sfields Array Campos para mostrar de la tabla

* @params $header Array Encabezado

* @params $filename String nombre de archivo

* 

*/

function to_excel($query, $sfields, $header, $filename='exceloutput')

{

	ini_set("memory_limit","256M");

	

	$headers = ''; // just creating the var for field headers to append to below

	$data = ''; // just creating the var for field data to append to below

	$obj =& get_instance();

	

	$fields = $query->field_data();

	$num_fields  = count( $sfields );

	

	if (is_null($query))

	{

		echo '<p>No se encontraron datos.</p>';

	}

	else if ($query->num_rows() == 0) {

		echo '<p>No se encontraron datos.</p>';

	} else {

		foreach ($header as $field) {

		   $headers .= $field . "\t";

		}

	

		foreach ($query->result() as $row)

		{

			$line = '';

			foreach($sfields as $field)

			{

				if( isset($row->$field) )

				{

					$value = '';

					if (  empty($row->$field) OR is_null($row->$field) )

					{

						$value = "\t";

					}

					else {

						$value = str_replace('"', '""', $row->$field);

						$value = '"' . $value . '"' . "\t";

					}

					$line .= $value;

					

				}

			}

			$data .= trim($line)."\r\n";

		}

		

		$data = str_replace("\r","",$data); 

					

		header("Content-type: application/x-msdownload");

		header("Content-Disposition: attachment; filename=$filename.xls");

		echo "$headers\n$data";  

	}

}





?>
