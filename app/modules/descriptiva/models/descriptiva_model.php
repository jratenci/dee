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
    
     /**
     * Máximo: devuelve el numero maxiomo de un arreglo.
     * Ej: Array(2,2,2,3,3,1)devuelve Array(Array(3))
     * @param Array $datos
     * @return Array $arreglo_maximo
     */
    function maximo($datos=null){
        $arreglo_maximos=Array();
        foreach($datos as $clave=>$arr){
            $arreglo_maximos[$clave]=max($arr);
        }
        return $arreglo_maximos;
    }
    
     /**
     * Mínimo: devuelve el numero mínimo de un arreglo.
     * Ej: Array(2,2,2,3,3,1)devuelve Array(Array(1))
     * @param Array $datos
     * @return Array $arreglo_minimo
     */
    
    function minimo($datos=null){
        $arreglo_minimos=Array();
        foreach($datos as $clave=>$arr){
            
            $arreglo_minimos[$clave]=max($arr);
      
        }
        return $arreglo_minimos;
        
    }
    /**
     * ndatos: devuelve el numero de elementos  de un arreglo .
     * Ej: Array(2,2,2,3,3,1)devuelve Array(Array(6))
     * @param Array $datos
     * @return Array $arreglo_minimo
     */
    
    function ndatos($datos=null){
        $arreglo_ndatos=Array();
        foreach($datos as $clave=>$arr){
            
            $arreglo_ndatos[$clave]=count($arr);
      
        }
        return $arreglo_ndatos;
        
    }
     /**
     * moda: devuelve la moda de un arreglo de datos .
     * Ej: Array(2,2,2,3,3,1)devuelve Array(Array(Array(2,3),Array(3,2),Array(1,1)))
     * @param Array $datos
     * @return Array $arreglo_minimo
     */
    
    function moda($datos=null){
        $arreglo_moda=Array();
        
        foreach($datos as $clave=>$arr){
            $d1=  array_unique($arr);
            $d2=Array();
            $d3=Array();
            foreach($d1 as $key =>$valor){
                $d2= array_keys($arr,$valor);
                $n=count($d2);
                $d3[$key]=Array($valor,$n) ;
            }
            $arreglo_moda[$clave]=$d3;
        }
        print_r($arreglo_moda);
        return $arreglo_moda;
    }
    
    /**
     * Quartil 1: cálcula el primer Quartil de un arreglo de datos.
     * Ej: Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9)), Array(1,2,3,4)) devuelve Array(3,2.5)
     * @param Array $datos
     * @return Array $arreglo_quartil1
     */
    function quartil1($datos=null){
        $arreglo_quartil1=Array();
        foreach($datos as $clave=>$arr){
            sort($arr);
            $longitud=count($arr);
            $num1 = 0.25*($longitud-1);
            if(is_int($num1)){
                $arreglo_quartil1[$clave] = $arr[$num1];
            }else{               
                $modulo =  $num1 - floor($num1);              
                $num1 = floor($num1);
                $resta = $arr[$num1+1]-$arr[$num1];
                $valor = $resta*$modulo;
                
                $arreglo_quartil1[$clave] = $arr[$num1]+$valor;
            }
          print_r($arreglo_quartil1);
        return $arreglo_quartil1;
    }
    }
    
    /**
     * Quartil 2: cálcula el segundo Quartil de un arreglo de datos.
     * Ej: Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9)), Array(1,2,3,4)) devuelve Array(5,4.5)
     * @param Array $datos
     * @return Array $arreglo_quartil1
     */
    
    function quartil2($datos=null){
       $arreglo_quartil2=Array();
        foreach($datos as $clave=>$arr){
            sort($arr);
            $longitud=count($arr);
            $q2=($longitud)/2; 
           
            if($q2%2==0){
                $arreglo_quartil2[$clave]=($arr[$q2]+$arr[$q2-1])/2;
            }else{
                
                $arreglo_quartil2[$clave]=$arr[round($q2)];
            }      
        }
       print_r($arreglo_quartil2);
        return $arreglo_quartil2;
    }
    
    /**
     * Quartil 3: cálcula el tercer Quartil de un arreglo de datos.
     * Ej: Array(Array(2,5,3,6,7,4,9),Array(2,5,3,4,6,7,1,9)), Array(1,2,3,4)) devuelve Array(6,6.5)
     * @param Array $datos
     * @return Array $arreglo_quartil1
     */
    
    function quartil3($datos=null){
     $arreglo_quartil3=Array();
          foreach($datos as $clave=>$arr){
            sort($arr);
            $longitud=count($arr);
             $num1 = 0.75*($longitud-1);
            if(is_int($num1)){
                $arreglo_quartil3[$clave] = $arr[$num1];
            }else{               
                $modulo =  $num1 - floor($num1);              
                $num1 = floor($num1);
                $resta = $arr[$num1+1]-$arr[$num1];
                $valor = $resta*$modulo;
                
                $arreglo_quartil3[$clave] = $arr[$num1]+$valor;
            }
             
        }
         print_r($arreglo_quartil3);
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
    
    /**
     * Coeficiente de variación cálcula el coeficiente de variación de un arreglo de datos.
     * Ej: Array( Array(Array(3.0,5.8,5.6,4.8,5.1,3.6,5.5,4.7,5.7,5.0,5.9,5.7,4.4,5.4,4.2,5.3),Array(1,2,3,4,5))) devuelve Array(16.70345,52.70463)
     * Dado en porcentaje (está multiplicado por 100)
     * @param Array $datos
     * @return Array $arreglo_cv
     */
    
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
    /**
     * Rango intercuartil cálcula el rango intercuartil de un arreglo de datos, cuartil1-cuartil2.
     * Ej: Array(1,2,3,4,5,6) 
     * @param Array $datos
     * @return Array $arreglo_cv
     */
    function rangointercuartil($datos=null){
        $arreglo_Rintercuartil=Array();
        $arreglo_q1=$this->quartil1($datos);
        $arreglo_q3=$this->quartil3($datos);
        foreach ($datos as $key=>$value){
        $arreglo_Rintercuartil[$key]=$arreglo_q3[$key]-$arreglo_q1[$key];
        }
        return $arreglo_Rintercuartil;  
    }
    
    function coasimetria($datos=null){
        $arreglo_casimetria=Array();
        $arreglo_desviaestandar=$this->desviacionestandar($datos);
        print_r($arreglo_desviaestandar);
        $arreglo_media=$this->media($datos);
        $arreglo_aux=Array();
       foreach($datos as $clave=>$arr){
           $n=count($arr);
           $arreglo_frecuencia=  array_count_values($arr);
           foreach($arr as $key=>$valor){
               $arreglo_aux[$clave]=$arreglo_frecuencia[$valor]*pow($valor-$arreglo_media[$clave],3);
           }
           $arreglo_casimetria[$clave]=(array_sum($arreglo_aux))/($n*pow($arreglo_desviaestandar[$clave],3));
       }
       print_r($arreglo_casimetria);
        return $arreglo_casimetria;

    }
    function cocurtois($datos=null){
        $arreglo_casimetria=Array();
        $arreglo_desviaestandar=$this->desviacionestandar($datos);
        print_r($arreglo_desviaestandar);
        $arreglo_media=$this->media($datos);
        $arreglo_aux=Array();
       foreach($datos as $clave=>$arr){
           $n=count($arr);
           $arreglo_frecuencia=  array_count_values($arr);
           foreach($arr as $key=>$valor){
               $arreglo_aux[$clave]=$arreglo_frecuencia[$valor]*pow($valor-$arreglo_media[$clave],3);
           }
           $arreglo_casimetria[$clave]=(array_sum($arreglo_aux))/($n*pow($arreglo_desviaestandar[$clave],3));
       }
       print_r($arreglo_casimetria);
        return $arreglo_casimetria;

    }
    
    function frecuencias($datos=null){
        $arreglo_frecuencias=Array();
        $arreglo_frecuenciasre=Array();
        
        foreach ($datos as $clave=>$arr){
            $arreglo_frecuencias[$clave]=array_count_values($arr);
            foreach($arreglo_frecuencias as $key=>$value){
                $arreglo_frecuenciasre=$this->frecuenciarela($value);
               
            }
        }
//        print_r($arreglo_frecuenciasre);
        return $arreglo_frecuenciasre;
        
        
    }
    function frecuenciarela($datos=null){
        $dat=Array();
        $total=array_sum($datos);
        foreach($datos as $key=>$valor){
            $dat[$key]=$valor/$total;
        }
        return $dat;
    }
    
        
    function pruebaoperaciones($datos=null){
        //(1,1,1,2,2,2)
        $dat2=Array();
        $dat3=Array();
        $dat=  array_unique($datos);
        foreach($dat as $key=>$valor){
            $dat2=  array_keys($datos, $valor);
            $n=count($dat2);
            $dat3[$key]=Array($valor,$n);
        }
        print_r($dat3);

        return $dat;
    }
    
    
    

    
}