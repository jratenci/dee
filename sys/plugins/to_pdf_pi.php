<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Try increasing memory available, mostly for PDF generation
 */
ini_set("memory_limit","512M");
set_time_limit (60*60);
function pdf_create($html, $filename, $stream=TRUE) 
{
	require_once(BASEPATH."plugins/dompdf/dompdf_config.inc.php"); 
//  require_once("dompdf/dompdf_config.inc.php");
	
	$dompdf = new DOMPDF();
	$dompdf->set_paper("letter", "portrait"); 
	$dompdf->load_html($html);
	$dompdf->render();
	if ($stream) {
		$dompdf->stream($filename.".pdf");
	}
	write_file("./invoices_temp/$filename.pdf", $dompdf->output());
}
?>
