<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth_model
 *
 * @author jhon
 */
class descriptiva_model extends MY_Model {

    function __construct() {
        parent::__construct(null);
    }

    /**
     * Calcula la media de los datos. 
     * Ej: Array( Array(1,1,1), Array(2,2,2)) devuelve Array(1,2)
     * @param Array $datos
     * @return Array $arreglo_media
     */  
    
    function media($datos=null){        
       $arreglo_media = Array();             
       foreach( $datos as $clave=>$arr){           
             $arreglo_media[$clave] = array_sum($arr ) / count($arr ) ;           
       }       
       return $arreglo_media;
    }
    
    /**
     * mediana cálcula la mediana de un arreglo de datos.
     * Ej: Array( Array(1,2,3), Array(1,2,3,4)) devuelve Array(2,2.5)
     * @param Array $datos
     * @return Array $arreglo_mediana
     */
    
    function mediana($datos=null){
        
        $arreglo_mediana=Array();
        foreach( $datos as $clave=>$arr){ 
            asort($arr);
            $longitud=count($arr);
            if($longitud%2==0){ 
                
                $arreglo_mediana[$clave]=($arr[$longitud/2]+$arr[($longitud/2)-1])/2;
            }else{
                
                $arreglo_mediana[$clave]=($arr[($longitud/2+0.5)-1]);
            }           
       } 
        
        return $arreglo_mediana;
    }
    
    
    
    function moda($datos=null){
        $arreglo_moda1=Array();
        $repetidos=0;
        foreach ($datos as $key=>$value) {
            foreach ($datos as $value1){
                if($value==$value1){
                    $repetidos++;
                }   
            }
            $arreglo_moda1[$key][0]=$value;
            $arreglo_moda1[$key][1]=$repetidos; 
            $repetidos=0;
        }
        asort($arreglo_moda1);
        $arreglo_moda=array_map("unserialize", array_unique(array_map("serialize", $arreglo_moda1)));
        
        return $arreglo_moda;  
    }
    
    function quartil1($datos=null){
        $arreglo_quartil1=Array();
        foreach($datos as $clave=>$arr){
            sort($arr);
            $longitud=count($arr);
            $q1=round($longitud/4);
            if($longitud%2==0){ //par
                 $arreglo_quartil1[$clave]=($arr[$q1-1]+$arr[$q1])/2;
            }else{ //impar
                $arreglo_quartil1[$clave]=$arr[$q1-1];
            }           
        }
        return $arreglo_quartil1;
    }
    
    function quartil2($datos=null){
        $arreglo_quartil2=Array();
        foreach($datos as $clave=>$arr){
            sort($arr);
            $longitud=count($arr);
            $q2=round($longitud/2);
            if($longitud%2==0){ //par
                 $arreglo_quartil2[$clave]=($arr[$q2-1]+$arr[$q2])/2;
            }else{ //impar
                $arreglo_quartil2[$clave]=$arr[$q2-1];
            }           
        }
        return $arreglo_quartil2;
    }
    
    function quartil3($datos=null){
        $arreglo_quartil3=Array();
        foreach($datos as $clave=>$arr){
            sort($arr);
            $longitud=count($arr);
            $q3=round(3*$longitud/4);
            if($longitud%2==0){ //par
                 $arreglo_quartil3[$clave]=($arr[$q3-1]+$arr[$q3])/2;
                 //mejorar algoritmo busacar interpolacion de datos
            }else{ //impar
                $arreglo_quartil3[$clave]=$arr[$q3-1];
            }           
        }
        return $arreglo_quartil3;
    }
    
    /**
     * Rango: cálcula el Rango de un arreglo de datos.
     * Ej: Array( Array(1,2,3), Array(1,2,3,4)) devuelve Array(2,3)
     * @param Array $datos
     * @return Array $arreglo_rango
     */
    
    function rango($datos=null){
        $arreglo_rango=Array();
        foreach ($datos as $clave => $arr) {
            sort($arr);
            $longitud=count($arr);
            $arreglo_rango[$clave]=($arr[$longitud-1]-$arr[0]);
        }
        return$arreglo_rango;
        
    }
    
    /**
     * Varianza cálcula la Varianza de un arreglo de datos.
     * Ej: Array( Array(Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3),Array(1,2,3,4,5))) devuelve Array(0.6922917,2.5)
     * @param Array $datos
     * @return Array $arreglo_varianza
     */
     
    function varianza($datos=null){
         $arreglo_varianza=Array();
        $arreglo_media=Array();
        
        foreach($datos as $clave=>$arr){
            $arreglo_media[$clave] = array_sum($arr ) / count($arr ) ; //cálculo la media x barra;
            $arreglo_aux=Array();
            foreach ($arr as $key=>$valor){
                $arreglo_aux[$key]=pow($valor-$arreglo_media[$clave],2); //cálculo la desviacion media
            }
            $arreglo_varianza[$clave]=round(((array_sum($arreglo_aux))/(count($arr)-1)),7);
        }
        return $arreglo_varianza;
 
        
    }
    
     /**
     * Desviacion Estándar cálcula la Desviacion Estándar de un arreglo de datos.
     * Ej: Array( Array(9, 3, 8, 8, 9, 8, 9, 18), Array(1,2,3,4,5,6,7,8)) devuelve Array(17.14,2.44)
     * @param Array $datos
     * @return Array $arreglo_desviacionestandar
     */
    
    function desviacionestandar($datos=null){
        
        $arreglo_desviacionestandar=Array();
        $arreglo_media=Array();
        
        foreach($datos as $clave=>$arr){
            $arreglo_media[$clave] = array_sum($arr ) / count($arr ) ; //cálculo la media x barra;
            $arreglo_aux=Array();
            foreach ($arr as $key=>$valor){
                $arreglo_aux[$key]=pow($valor-$arreglo_media[$clave],2); //cálculo la desviacion media
            }
            $arreglo_desviacionestandar[$clave]=round(sqrt((array_sum($arreglo_aux))/(count($arr)-1)),7);
            
            
            
        }
//        print_r($arreglo_desviacionestandar);
        return $arreglo_desviacionestandar;
    }
    
    function cv($datos=null){
        
         $arreglo_cv=Array();
        $arreglo_media=Array();
        
        foreach($datos as $clave=>$arr){
            $arreglo_media[$clave] = array_sum($arr ) / count($arr ) ; //cálculo la media x barra;
            $arreglo_aux=Array();
            foreach ($arr as $key=>$valor){
                $arreglo_aux[$key]=pow($valor-$arreglo_media[$clave],2); //cálculo la desviacion media
            }
            $arreglo_cv[$clave]=round((100*(sqrt((array_sum($arreglo_aux))/(count($arr)-1))))/abs($arreglo_media[$clave]),5);
        }
       
        return $arreglo_cv;
        
    }
    
    
    

    
}