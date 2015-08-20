<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('map_cssitem'))
{
	function map_cssitem( $filename )
	{
		return "\t<link type=\"text/css\" rel=\"stylesheet\" href=\"".base_url()."/assets/css/".$filename.".css\" />\n";
	}	
}

if( !function_exists('date_to_mysql'))
{
    function date_to_mysql($date)
    {
        $date = explode('/', $date);
        return $date[2] . '-' . $date[1] . '-'.$date[0];
    }
}
if( !function_exists('summed_date_to_mysql'))
{
    function summed_date_to_mysql( $date )
    {
        $date = explode('-', $date);
        return $date[2] . '-' . $date[1] . '-'.$date[0];
    }
}

if( !function_exists('mysql_to_date'))
{
    function mysql_to_date( $date )
    {
        $date = explode('-', $date);
        return $date[2] . '/' . $date[1] . '/'.$date[0];
    }
}

if ( ! function_exists('map_jsitem'))
{
	function map_jsitem( $filename )
	{
		return "\t<script src=\"".base_url()."assets/js/".$filename.".js\" type=\"text/javascript\"></script>\n";
	}	
}

if( ! function_exists('redondeo'))
{
    function redondeo ($numero, $decimales)
    {
        $factor = pow(10, $decimales);
        return ( round( $numero * $factor ) / $factor );
    }
   
}

if ( ! function_exists('sum_days_to_date'))
{

    function sum_days_to_date( $fecha,$ndias )
    {
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
                list($dia,$mes,$año)=split("/", $fecha);
        if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
                list($dia,$mes,$año)=split("-",$fecha);

        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);

        return ($nuevafecha);
    }
}

if( ! function_exists('map_date'))
{
    function map_date ($fecha)
    {
        $date = explode("/",$fecha);
        return $date[0] . "-".$date[1]."-".$date[2];
    }
   
}

if( ! function_exists('map_date_inverse'))
{
    function map_date_inverse ($fecha)
    {
        $date = explode("-",$fecha);
        return $date[0] . "/".$date[1]."/".$date[2];
    }
   
}
