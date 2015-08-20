<?php

class dee2k_model extends MY_Model{
    public  $TablaSignos    = Array();
    public  $Yates          = Array();
    public  $NumeroFactores = 5;
    public  $Replicas       = 1;
    public  $Datos          = 1;
    public  $F              = Array();
    public  $T              = Array();
    public  $Alpha          = 0.05;
    
  public function __construct(){              
   parent::Model();
  $this->F[1][4][0.05] =7.71;  $this->F[1][8][0.05] =5.32;  $this->F[1][12][0.05]=4.75; $this->F[1][16][0.05]=4.49; 
  $this->F[1][24][0.05]=4.46;  $this->F[1][32][0.05]=4.17;  $this->F[1][48][0.05]=4.08; $this->F[1][64][0.05]=4;
  $this->F[1][96][0.05]=3.94;  
  
  $this->T[0.025][4]  =2.7765;  $this->T[0.025][8] =2.3060;  $this->T[0.025][12] =2.1788; $this->T[0.025][16] =2.1199; 
  $this->T[0.025][24] =2.0639;  $this->T[0.025][32]=2.0369;  $this->T[0.025][48] =2.0106; $this->T[0.025][64] =1.9977; 
  $this->T[0.025][96] =1.9850;
  
 }
    
 function InitTablaSignos(){
/** las filas son los tratamientos, osea Arreglo[0], Arreglo[1]...
 *  |A__B__C__D__E...K|
 * 0|
 * 1|
 * 2| 
 * 3|
 * .
 * .
 * . 
 *(2^k)-1  
 */          
 $filas    = $this->get_NumeroTratamientos();    
 for($fac=0;$fac<$this->NumeroFactores;$fac++){
     $signo        = -1;
     $contador     =  0;
     $limite_signo =  pow(2,$fac);
     $columna      =  $fac;    
     for($i=0;$i<$filas;$i++){
         $this->TablaSignos[$i][$columna]=$signo;
         $contador = $contador+1;
         
         if($contador==$limite_signo){
           $contador=0;
           $signo = $signo*-1;
         }     
     }      
  }
           	
 }
 /**
  * 
  * @param type $_yates
  */
 public function set_Yates($_yates=null){
      $this->Yates = $_yates;  
      $this->NumeroFactores = log(count($_yates))/log(2);      
      $this->InitTablaSignos();      
  }
  
  public function set_Datos($_datos=null){
      $this->Datos = $_datos;
      $yates = Array();
      foreach ($_datos as $dato){
        $yates[] = array_sum($dato);  
      }
      $this->set_Yates($yates);
  }

  function set_Replicas($replicas){
      $this->Replicas = $replicas; 
  }
       
  public function get_K(){
      return $this->NumeroFactores;
  }
  
  public function get_NumeroTratamientos(){
      return pow(2, $this->NumeroFactores);
  }
           
  public function get_NumeroInteracciones($interaccion=null){
      //sin interacion 0, interaccion doble 1, triple 2 y asi sucesivamente 
      // k!/int!(k-int)!      
      return ($this->Factorial($this->get_K())/( $this->Factorial($interaccion+1)*($this->Factorial($this->get_K()- ($interaccion+1) ) ) )  );
  }
  
  function ContrastexFactor($factor=null){
      $contraste=null;
      for($i=0; $i<$this->get_NumeroTratamientos(); $i++){
      $contraste +=$this->TablaSignos[$i][$factor]* $this->Yates[$i];   
      }
      return $contraste;
  }
  
  //0=A,B,C..., 1=AB AC BC... 2=ABC...
  function ContrastesxInteraccion($orden=null){
  $orden+=1;    
  $filas  = $this->get_NumeroTratamientos();    
  $combinaciones = $this->Combinaciones($this->get_K(),$orden);    
 
  $ArregloSignos = Array();
  $ArregloContrastes = Array();
  //se halla la tabla se signos para los contrastes
  foreach ($combinaciones as $posicion=>$comb){
      for($i=0; $i<$filas;$i++){  
      $signoInteraccion = 1;    
      foreach ($comb as $columna){
        $signoInteraccion*=$this->TablaSignos[$i][$columna];    
      }
      $ArregloSignos[$posicion][]=$signoInteraccion;
     }//fin for
  }
  
  //se multiplica la tabla se signos por yates
  foreach ( $ArregloSignos as $posi=>$signos){
     $contraste = null;
     for($i=0; $i<$filas;$i++){  
       $contraste+=$signos[$i]*$this->Yates[$i];
     }
     $ArregloContrastes[$posi] = $contraste;
  }
  
  return $ArregloContrastes;
  }
  
  function EfectoxFactor($factor=null){
      //Contraste/n*2^(k-1)
      return ($this->ContrastexFactor($factor)/($this->Replicas*  pow(2, $this->get_K()-1 ) ) );
  }
  
  function SumaCuadradosxFactor($factor=null){
      //Contraste/n*2^(k-1)
      return ( pow($this->ContrastexFactor($factor),2) /($this->Replicas*  pow(2, $this->get_K() ) ) );
  }
    
  function EfectosxInteraccion($orden=null){
      $contrastes = $this->ContrastesxInteraccion($orden);
      $efectos = Array();
      foreach ($contrastes as $posicion=>$contraste){
       $efectos[$posicion] = $contraste/($this->Replicas*  pow(2, $this->get_K()-1 ) );  
      }
      return $efectos;
  }
  
  function EfectosEstandarizadosxInteraccion($orden=null){
      $Efectos    = $this->EfectosxInteraccion($orden);
      $efectosest = Array();
      foreach ( $Efectos as $posicion=>$efect){
       $raiz = sqrt( $this->CuadradoMedioError()/( $this->Replicas *  pow(2, $this->get_K()-2 ) ) )  ; 
      if($raiz==0) $raiz=0.000001;
       //echo $raiz;
        $efectosest[$posicion] = $efect/$raiz; 
      }
      /*
      echo '<pre>';
      print_r($efectosest);
       echo '<pre>';
       * 
       */
       
      return $efectosest;
  }
  
  function CoeficientesxInteraccion($orden=null){
      $efectos = $this->EfectosxInteraccion($orden);
      $coeficientes = Array();
      foreach ($efectos as $posicion=>$efecto){
       $coeficientes[$posicion] = $efecto/(2);  
      }
      return $coeficientes;
  }
  
  function CuadradoMedioxFactor($factor=NULL){
      return $this->SumaCuadradosxFactor($factor);
  }
  
  function SumasCuadradosxInteraccion($orden=null){
      $contrastes = $this->ContrastesxInteraccion($orden);
      $cuadrados = Array();
      foreach ($contrastes as $posicion=>$contraste){
       $cuadrados[$posicion] = pow($contraste,2)/($this->Replicas*  pow(2, $this->get_K() ) );  
      }
      return $cuadrados;
  }
  
  function CuadradosMediosxInteraccion($orden=null){
      return $this->SumasCuadradosxInteraccion($orden);
  }
  
  function SumaTotalCuadrados(){
      $sumatoria = null;
      $totalYateCuadrado = null;
      $resultado = null;
      foreach ($this->Datos as $datos){
          foreach ($datos as $dato){
           $sumatoria+=pow($dato,2);   
          } 
      } 
      $totalYateCuadrado = pow(array_sum($this->Yates),2);
      $resultado = $sumatoria-$totalYateCuadrado/($this->Replicas*(pow(2,$this->get_K())));
      return $resultado;
  }
  
  function SumaCuadradosError(){
   $interacciones = $this->getOrdenesInteraccion();
   
   $sumaCuadrados = null;
   
   foreach ($interacciones as $orden){
    $arregloSumas = $this->SumasCuadradosxInteraccion($orden);
    foreach($arregloSumas as $valor){
      $sumaCuadrados+=$valor;  
    }    
   }
   
   $sumaTotal = $this->SumaTotalCuadrados();
   
   return $sumaTotal-$sumaCuadrados;
   
  }
  
  function SumaCuadradosErrorMasNoafectan(){
  $SumaCuadradosError = $this->SumaCuadradosError(); 
  $errorTotal =   $SumaCuadradosError;
  $ordenesInteraccion = $this->getOrdenesInteraccion();
  $sumaCuadradosInteraccion = Array(); 
  $FactoresAfectanxInteraccion = Array();
    
     foreach ($ordenesInteraccion as $orden){
      $FactoresAfectanxInteraccion[] = ($this->getFactoresAfectanxInteraccion($orden)); 
      $sumaCuadradosInteraccion[] = $this->SumasCuadradosxInteraccion($orden); 
     }         
     foreach ($FactoresAfectanxInteraccion as $orden=>$arrayFactores){
        foreach($arrayFactores as $id=>$si_o_no){
            if(!$si_o_no){
             $errorTotal+= $sumaCuadradosInteraccion[$orden][$id];  
               
            }
        } 
     }   
  
  return $errorTotal;
  
  }
    
  function CuadradoMedioError(){
      return $this->SumaCuadradosError()/$this->getGradosLibertadError();
  }
  
  function CuadradoMedioErrormasNoafectan(){
      $numeroFactoresNoAfectan=0;
      $ordenesInteraccion = $this->getOrdenesInteraccion();
      $FactoresAfectanxInteraccion = Array();    
     foreach ($ordenesInteraccion as $orden){
      $FactoresAfectanxInteraccion[] = ($this->getFactoresAfectanxInteraccion($orden));    
     }
      foreach ($FactoresAfectanxInteraccion as $orden=>$arrayFactores){
        foreach($arrayFactores as $id=>$si_o_no){
            if(!$si_o_no){
            $numeroFactoresNoAfectan+=1;               
            }
        } 
     }   
     
     
      return $this->SumaCuadradosErrorMasNoafectan()/($this->getGradosLibertadError()+$numeroFactoresNoAfectan);
  }
  
  function CuadradoMedioTotal(){
      return $this->SumaTotalCuadrados()/$this->getGradosLibertadTotal();
  }
  
  function getGradosLibertadError(){
      return (pow(2,$this->get_K()))*($this->Replicas-1);
  }
  
  function getGradosLibertadTotal(){
      return $this->Replicas*pow(2,$this->get_K())-1 ;     
  }
  
  function getGradosLibertadxInteraccion($orden){
      
  }
  
  function getF0xInteraccion($orden){
      $cuadradosMedios = $this->CuadradosMediosxInteraccion($orden);
      $f0 = Array();
      foreach ($cuadradosMedios as $cucadradoMedio){
       $f0[] = ($this->CuadradoMedioError()==0)? $cucadradoMedio/0.000000001 : $cucadradoMedio/$this->CuadradoMedioError();  
      }
      return $f0;
  }  
  
  function getFxinteraccion($orden){
      $arrayf0 = $this->getF0xInteraccion($orden);
      $arrayF = Array();
      foreach ($arrayf0 as $f0){
       $arrayF[] = $this->CuartilF0(1,  $this->getGradosLibertadError(), $this->getAlpha() );   
      }
      return $arrayF;
  }
  
  function getOrdenesInteraccion(){
    $interacciones = Array();   
   for($i=0;$i<20;$i++){
    $numeroInteraccion = $this->get_NumeroInteracciones($i);
    if($numeroInteraccion>=1){
      $interacciones[]=$i;  
    }
   }     
   return $interacciones;
  }
  
  function getPromedioDatos(){
      $sumatoria = null;     
      foreach ($this->Datos as $datos){
          foreach ($datos as $dato){
           $sumatoria+=$dato;   
          } 
      } 
      return $sumatoria/($this->Replicas*($this->get_NumeroTratamientos()));
  }
  
  function getR2(){
      return (($this->SumaTotalCuadrados()-$this->SumaCuadradosError() )*100/$this->SumaTotalCuadrados());
  }
  
  function getR2masNoafectan(){
      return (($this->SumaTotalCuadrados()-$this->SumaCuadradosErrorMasNoafectan() )*100/$this->SumaTotalCuadrados());
  }
  
  function getR2aj(){
      return (($this->CuadradoMedioTotal()-$this->CuadradoMedioError() )*100/$this->CuadradoMedioTotal());
  }
  
  function getR2ajmasNoafectan(){
      return (($this->CuadradoMedioTotal()-$this->CuadradoMedioErrormasNoafectan() )*100/$this->CuadradoMedioTotal());
  }
  
  function getFactoresAfectanxInteraccion($orden){
    $interacciones = Array(); 
    $F0 = $this->dee2k_model->getF0xInteraccion($orden);
    $F  = $this->dee2k_model->getFxInteraccion($orden); 
    $numeroInteraccion = $this->get_NumeroInteracciones($orden);
   
    for($i=0;$i<$numeroInteraccion;$i++){
      $interacciones[$i] = ( $F0[$i]>$F[$i])? 1:0;   
    }
    return $interacciones;
  }
  
  function NombresYEfectosxInteracionesAfectan($nombresFactores){
     $ordenesInteraccion = $this->getOrdenesInteraccion();
     $FactoresAfectanxInteraccion = Array();
     $RepresentacionInteracciones = Array();
     $interacciones = Array();    
     foreach ($ordenesInteraccion as $orden){
      $FactoresAfectanxInteraccion[] = ($this->getFactoresAfectanxInteraccion($orden)); 
      $RepresentacionInteracciones[] = ($this->RepresentacionInteracciones($orden,$nombresFactores) );
     }
     foreach ($FactoresAfectanxInteraccion as $orden=>$arrayFactores){
         $efectorxInteracion = $this->EfectosxInteraccion($orden);
        foreach($arrayFactores as $id=>$si_o_no){
            if($si_o_no){
             $interacciones[$RepresentacionInteracciones[$orden][$id]] = $efectorxInteracion[$id];
            }
        } 
     } 
     
   //arsort($interacciones);
     return $interacciones;  
  } 
  
  function NombresYEfectosEstandarizadosxInteraciones($nombresFactores){
     $ordenesInteraccion = $this->getOrdenesInteraccion();
     $EfectosEstandarizadosxInteraccion = Array();
     $RepresentacionInteracciones = Array();
     $interacciones = Array();    
     foreach ($ordenesInteraccion as $orden){
      $EfectosEstandarizadosxInteraccion[] = $this->EfectosEstandarizadosxInteraccion($orden); 
      $RepresentacionInteracciones[] = ($this->RepresentacionInteracciones($orden,$nombresFactores) );
     }
     foreach ($EfectosEstandarizadosxInteraccion as $orden=>$arrayFactores){
        
        foreach($arrayFactores as $id=>$valor){         
             $interacciones[$RepresentacionInteracciones[$orden][$id]] = $valor;
            
        } 
     } 
     
   //arsort($interacciones);
     return $interacciones;  
  } 
  
  
  
  function RepresentacionInteracciones($orden,$nombresFactores){
      $interaciones = array();
      $combinaciones = $this->Combinaciones($this->get_K(),$orden+1);
           
      if($combinaciones){          
          foreach($combinaciones as $arraycombinacion){
              $nombreInteraccion='';
              foreach ($arraycombinacion as $idcombi){
               if(count($arraycombinacion)>1 ){
                   $nombreInteraccion.=$nombresFactores[$idcombi].'*';
               }else{   
               $nombreInteraccion.=$nombresFactores[$idcombi];                
               }  
               
              }
              if(count($arraycombinacion)>1 ){
               $interaciones[] =substr($nombreInteraccion,0,  strlen($nombreInteraccion)-1 );    
              }else{
              $interaciones[] = $nombreInteraccion;}
          
          }
      }
      return  $interaciones;
  }

  function NombresqueAfectan($nombresFactores){
    $ordenesInteraccion = $this->getOrdenesInteraccion();
     $FactoresAfectanxInteraccion = Array();
     $RepresentacionInteracciones = Array();
     foreach ($ordenesInteraccion as $orden){
      $FactoresAfectanxInteraccion[] = ($this->getFactoresAfectanxInteraccion($orden)); 
      $RepresentacionInteracciones[] = ($this->RepresentacionInteracciones($orden,$nombresFactores) );
     }     
     $interacciones = Array();
     foreach ($FactoresAfectanxInteraccion as $orden=>$arrayFactores){
        foreach($arrayFactores as $id=>$si_o_no){
            if($si_o_no){
                $interacciones[$orden][$id] = $RepresentacionInteracciones[$orden][$id];
            }
        } 
     }   
     return $interacciones;
  }
  
  function NombresqueAfectanPrimerOrden($nombresFactores){
     $orden = 0;
     $FactoresAfectanxInteraccion = Array();
     $RepresentacionInteracciones = Array();
    
     $FactoresAfectanxInteraccion[] = ($this->getFactoresAfectanxInteraccion($orden)); 
     $RepresentacionInteracciones[] = ($this->RepresentacionInteracciones($orden,$nombresFactores) );
       
     $interacciones = Array();
     foreach ($FactoresAfectanxInteraccion as $orden=>$arrayFactores){
        foreach($arrayFactores as $id=>$si_o_no){
            if($si_o_no){
                $interacciones[$id] = $RepresentacionInteracciones[$orden][$id];
            }
        } 
     }   
     return $interacciones;
  }

  function setAlpha($alfa){
      $this->Alpha = $alfa;
  }
  
  function getAlpha(){
      return $this->Alpha;
  }
      
  function Factorial($numero=null){
  $factorial = 1;   
  for($i=$numero; $i>=1; $i--){
  $factorial*=$i;   
   }   
   return $factorial;
  }
  
  function Combinaciones($n=null,$r=null){
    $i = $j = $ci = 0;   
    $p1 = $this->Factorial($n)/($this->Factorial($r)*$this->Factorial($n-$r));
    $v = Array();
    $combinaciones = array();
    
    for($i= 0; $i < $n; $i++){
    $v[$i]=$i;
    } //Inicia v[]    
    $arreglo = Array();
    for($i = 0; $i < $r; $i++){
        $arreglo[]=$v[$i];
      } 
     $combinaciones[]=$arreglo;   
     $ci++;    
   while($ci < $p1){       
                $i = $r - 1;
                while ($v[$i] == $n - $r + $i)
                {
                    $i--;
                }
                    
                $v[$i] = $v[$i] +1;
                for ($j = $i + 1; $j < $r; $j++)
                {
                    $v[$j] = $v[$i] + $j - $i;
                }
               $arreglo = Array();
               for($i = 0; $i < $r; $i++){
               $arreglo[]=$v[$i];
               } 
               $combinaciones[]=$arreglo; 
               $ci++;
            }
    return $combinaciones;
  }
    
  function CuartilF0($n1,$n2,$alpha){
   
  if(isset($this->F[$n1][$n2][$alpha])){
    return $this->F[$n1][$n2][$alpha];
  }else{
      return 'Necesita valor';
  }   
     
 }
  
  function StudentParaEfectoEstandarizado(){
     return $this->T[$this->getAlpha()/2][$this->getGradosLibertadError()];
  }
  
  
  //calcular p-valor distribucion F
  
  function StatCom($q,$i,$j,$b) {
    $zz=1; 
    $z=$zz; 
    $k=$i; 
    while($k<=$j) { 
        $zz=$zz*$q*$k/($k-$b); 
        $z=$z+$zz; 
        $k=$k+2;
      }
    return $z;
    }
  
 function FishF($f,$n1,$n2) {
    $Pi = pi(); 
    $PiD2=$Pi/2; 
    $x=$n2/($n1*$f+$n2);
    if(($n1%2)==0) { return $this->StatCom(1-$x,$n2,$n1+$n2-4,$n2-2)*pow($x,$n2/2); }
    if(($n2%2)==0){ return 1-$this->StatCom($x,$n1,$n1+$n2-4,$n1-2)*pow(1-$x,$n1/2); }
    $th=atan(sqrt($n1*$f/$n2));
    $a=$th/$PiD2;
    $sth=sin($th);
    $cth=cos($th);
    if($n2>1) { $a=$a+$sth*$cth*$this->StatCom($cth*$cth,2,$n2-3,-1)/$PiD2; }
    if($n1==1) { return 1-$a; }
    $c=4*$this->StatCom($sth*$sth,$n2+1,$n1+$n2-4,$n2-2)*$sth*pow($cth,$n2)/$Pi;
    if($n2==1) { return 1-$a+$c/2 ;}
    $k=2;
    while($k<=($n2-1)/2) {$c=$c*$k/($k-.5);
    $k=$k+1; }
    return 1-$a+$c;
    }
   
 function Fmt($x) { 
 if($x>=0) {
     $v=''.($x+0.0005);
  }else {
     $v=''.($x-0.0005); 
     }
return substr($v,0,strpos($v,'.')+4);
}
 
function calcPF($f,$n1,$n2){
return $this->Fmt($this->FishF($f, $n1, $n2)) ;   
}
    
}//fin modelo