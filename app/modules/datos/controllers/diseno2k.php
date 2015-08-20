<?php

class diseno2k extends MY_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('diseno2k_model');       
    }

    function prueba(){
     $this->load->model('EvalMath'); 
     $this->EvalMath->evaluate('f(t1,t2,t3)=0.01525-0.00975*t1-0.00325*t2-0.00425*t3+0.00475*t1*t3');
     
     $pasot1 = 1;
     $pasot2 = 1;
     $pasot3 = 1;
     
     $mint1  = -3;
     $mint2  = 60;
     $mint3  = 20;
     
     $maxt1  = -1;
     $maxt2  = 98;
     $maxt3  = 70;
     
     $t1 = Array();
     $t2 = Array();
     $t3 = Array();
     
     $respuesta     = Array();
     $combinaciones = Array();
     
     for($i=$mint1; $i<=$maxt1;$i+=$pasot1){
     $t1[] = $i;    
     }
     
     for($i=$mint2; $i<=$maxt2;$i+=$pasot2){
     $t2[] = $i;    
     }
     
     for($i=$mint3; $i<=$maxt3;$i+=$pasot3){
     $t3[] = $i;    
     }
     
     foreach ($t1 as $valort1){
       foreach ($t2 as $valort2){
         foreach ($t3 as $valort3){
         $respuesta[] = round($this->EvalMath->evaluate('f('.$this->codificado($valort1,$maxt1,$mint1).','.$this->codificado($valort2,$maxt2,$mint2).','.$this->codificado($valort3,$maxt3,$mint3).')') , 5); 
         $combinaciones[] = '('.$valort1.','.$valort2.','.$valort3.')';
         }
       }   
     }
     // asort($respuesta);
   // echo '<pre>';
    // print_r($respuesta);
   // print_r($combinaciones );
   //  echo '<pre>';     
     $data['respuesta']     = $respuesta;
     $data['combinaciones'] = $combinaciones;
     $data['diseno'] = null;
     $this->run('grafica',$data,'Diseño 2<sup>k</sup>',null, null,null,'diseno2k.js');
         
    }
    
    function index(){     
      $this->load->model('paginador_model');
      $this->load->library('pagination');  
      $filtro_diseno2k = $this->input->post('diseno2k');

      $filtros_diseno2k = $this->paginador_model->filtro($filtro_diseno2k,'diseno2k_filtro');
        /**
         * configuracion de paginacion
         */
      $data['diseno2k'] = $this->diseno2k_model->get_diseno2k($filtros_diseno2k);
      $total_rows= (($data['diseno2k']==false))? 0 : $data['diseno2k']->num_rows();
      $base_url =  site_url('maestro/diseno2k/index');
      $config = $this->paginador_model->paginar( $total_rows,$base_url);
      $perpage = $this->paginador_model->get_perpage();
      $this->pagination->initialize($config);
        /**
        * fin paginacion.
        */

      $data['per_page'] = $perpage;

      $data['diseno2k'] = $this->diseno2k_model->get_diseno2k($filtros_diseno2k,$perpage,$this->uri->segment(4));
       
      $data['vista_nuevo_diseno2k'] = $this->load->view('nuevo_diseno2k_view',null,true);
     // $data['vista_editar_diseno2k'] = $this->load->view('editar_diseno2k_view',$data0,true);
     // $data['vista_buscar_diseno2k'] = $this->load->view('buscar_diseno2k_view',$data0,true);
   
      
      $menu = array ( array('callback' =>'nuevo_diseno2k();return false;','val' => '<img class="qtip" alt="Nuevo diseño 2<sup>k</sup>"  src="'.base_url().'assets/images/add-files.png" />'),
              array('callback' =>'buscar_diseno2k();return false;','val' => '<img class="qtip" alt="Buscar diseño 2k" src="'.base_url().'assets/images/search.png" />'),
              array('val' => '<img class="qtip" alt="Mostrar todos" src="'.base_url().'assets/images/all.png" />','href'=>site_url('datos/diseno2k/todos')),
             );      
      

      $this->run('diseno2k_view',$data,'Listado de diseños 2<sup>k</sup>', $menu, null,null,'diseno2k.js');
    }
    
    function detalle($id){          
    $data['diseno2k']     = $this->diseno2k_model->get_diseno2k(Array('d2k_id'=>$id));
    if($data['diseno2k'] ){ $data['diseno2k']  = $data['diseno2k']->row();}
    $data['detalle']      = $this->diseno2k_model->get_detalle(Array('d2k_id'=>$id));
    $data['tratamientos'] = $this->diseno2k_model->get_tratamientos(Array('d2k_id'=>$id));
    $data['existenTodosTratamientos'] = $this->diseno2k_model->existenTodosTratamientos($data['tratamientos']);
    $data['hayanalisis'] = false;
    $numeroFactores = $data['diseno2k']->factores;    
   
    $data['tablasignos']  = $this->diseno2k_model->tablaSignos($numeroFactores); 
   
     if($data['existenTodosTratamientos']){
     $data['hayanalisis'] = true;    
     $this->load->model('dee2k_model');
    
     $this->dee2k_model->set_Replicas($data['diseno2k']->d2k_replicas); 
     $this->dee2k_model->set_Datos($this->diseno2k_model->get_datos(Array('d2k_id'=>$id)) );
     $data['interaccionesafectan'] = $this->dee2k_model->NombresqueAfectan($this->diseno2k_model->NombresFactores);
     $nombresAfectarPrimerOrden = Array();
         
     foreach($data['interaccionesafectan'] as $orden =>$arrayinteracion ){
       foreach($arrayinteracion as $nombre){
           if($orden==0){
            $nombresAfectarPrimerOrden[$nombre] = $nombre;    
             }else{
              $explode = explode('*', $nombre);            
               foreach ($explode as $nombre2){
                $nombresAfectarPrimerOrden[$nombre2] = $nombre2;      
              }
           }
       }        
     }
          
     $data0['efectos']=($this->dee2k_model->NombresYEfectosxInteracionesAfectan($this->diseno2k_model->NombresFactores));
     $modelo='';
     $modelo_guardar = '';
     $variables_guardar = '';
     if($data0['efectos']){
      $promedioDatos = number_format($this->dee2k_model->getPromedioDatos(),6);
      if( $promedioDatos>1)  $promedioDatos = round( $promedioDatos,2);
      $modelo ='Y='.'<label style="color:blue">'. $promedioDatos.'</label>';
      $modelo_guardar ='f(';
      
      foreach($nombresAfectarPrimerOrden as $nombre){
      $modelo_guardar.=$nombre.',';  
      $variables_guardar.=$nombre.'*';
      }
      
      $modelo_guardar = substr($modelo_guardar,0, strlen($modelo_guardar)-1);
      $variables_guardar = substr($variables_guardar,0, strlen($variables_guardar)-1);
      
      $modelo_guardar.=')=';
      $modelo_guardar.=  ( $promedioDatos>1)?  round( $promedioDatos,2):$promedioDatos;
     // echo $modelo_guardar;
      
      foreach ($data0['efectos'] as $nombre=>$valor){
      $modelo.=($valor<0)?'<label style="color:blue">'.( (abs($valor/2)>1)? round($valor/2,2):$valor/2  ).'</label>'.$nombre:'<label style="color:blue">'.'+'.( ($valor>1)? round($valor/2,2):$valor/2 ).'</label>'.$nombre; 
      $modelo_guardar.=($valor<0)? ( (abs($valor/2)>1)? round($valor/2,2):$valor/2  ).'*'.$nombre:'+'.( ($valor>1)? round($valor/2,2):$valor/2 ).'*'.$nombre; 
     
      $data0['efectos'][$nombre]=round(abs($valor),2);
      }
      $modelo_guardar = strtolower($modelo_guardar);
     // echo $modelo_guardar;
      $this->diseno2k_model->modificar_tablas('diseno2k','d2k_id',Array('d2k_modelo'=>$modelo_guardar,'d2k_variables'=>$variables_guardar), $id);
       
      
      arsort($data0['efectos']);
      
      //efectos estandarizados
       $data0['efectosestandarizados'] = $this->dee2k_model->NombresYEfectosEstandarizadosxInteraciones($this->diseno2k_model->NombresFactores);
       foreach ($data0['efectosestandarizados'] as $nombre=>$valor){
       $data0['efectosestandarizados'][$nombre]  = abs($valor); 
        $data0['estandarizados_signos'][$nombre] = ($valor>0)?'+':'-';
       }
       
        arsort($data0['efectosestandarizados']);
      
       $data0['StudentParaEfectoEstandarizado'] = $this->dee2k_model->StudentParaEfectoEstandarizado();
     }
     
     $data['Grafica_efectos_estandarizados'] = $this->load->view('Grafica_efectos_estandarizados',$data0,true);
    
     
     $data['modelo']= $modelo.' ; R<sup>2</sup><sub>adj</sub>='.round($this->dee2k_model->getR2ajmasNoafectan(),1);
     $data['vistagrafica_view'] = $this->load->view('Grafica_efectos_significativos',$data0,true);
     $ordenesInteracciones = $this->dee2k_model->getOrdenesInteraccion();
     $nombreefectos = Array();
     foreach( $ordenesInteracciones as $orden){
     $RepresentacionInteracciones = $this->dee2k_model->RepresentacionInteracciones($orden,$this->diseno2k_model->NombresFactores);   
     foreach($RepresentacionInteracciones as $repInteracion){
       $nombreefectos[] = $repInteracion;   
     }     
     }
     
     $sumaCuadrados = Array();
     foreach( $ordenesInteracciones as $orden){
     $SumasCuadradosxInteraccion = $this->dee2k_model->SumasCuadradosxInteraccion($orden);   
     foreach($SumasCuadradosxInteraccion as $sc){
       $sumaCuadrados[] = $sc;   
     }     
     }
     
     $F0 = Array();
     foreach( $ordenesInteracciones as $orden){
     $F0xInteraccion = $this->dee2k_model->getF0xInteraccion($orden);   
     foreach($F0xInteraccion as $f0){
       $F0[] = $f0;   
     }     
     }
     $Valorp = Array();
     foreach ($F0 as $f0){
      $Valorp[] = $this->dee2k_model->calcPF($f0,1,  $this->dee2k_model->getGradosLibertadError());   
     }
     
     $F = Array();
     foreach( $ordenesInteracciones as $orden){
     $FxInteraccion = $this->dee2k_model->getFxInteraccion($orden);   
     foreach($FxInteraccion as $f){
       $F[] = $f;   
     }     
     }
     
     $data['SCError'] = $this->dee2k_model->SumaCuadradosError();  
     $data['GLError'] = $this->dee2k_model->getGradosLibertadError();
     $data['CMError'] = $this->dee2k_model->CuadradoMedioError();
     $data['SCTotal'] = $this->dee2k_model->SumaTotalCuadrados();
     $data['GLTotal'] = $this->dee2k_model->getGradosLibertadTotal();
     $data['F0'] = $F0;
     $data['F']  = $F;
     $data['Valorp']  = $Valorp;
     $data['sc'] =  $sumaCuadrados;
     $data['nombreefectos'] = $nombreefectos;
     
     }   
     
      $menu = array ( array('val' => '<img class="qtip" alt="Volver" src="'.base_url().'assets/images/left.png" />','href'=>site_url('datos/diseno2k/index'))
             );     
      $this->run('detalle_d2k_view', $data,'Diseño 2<sup>k</sup>',$menu, null,null,'diseno2k.js');
         
    }
    
    function analisisrespuesta($id){
     $diseno2k    = $this->diseno2k_model->get_diseno2k(Array('d2k_id'=>$id));
     if($diseno2k){ 
        $diseno2k  = $diseno2k->row();
        $detalle   = $this->diseno2k_model->get_detalle(Array('d2k_id'=>$id));
        $DATOS_DE_VARIABLES = Array(); 
        if(!is_null($diseno2k->d2k_modelo) && !is_null($diseno2k->d2k_variables)){           
            $explode_variables = explode('*',$diseno2k->d2k_variables);
            foreach ($explode_variables as $nombre){
                $array_variables[$nombre]    = $nombre;
              }     
            $p=0;
            $array_maximos = Array();
            $array_minimos = Array();
            $array_maximos_reales = Array();
            $array_minimos_reales = Array();
            $array_dosniveles     = Array();
            
            foreach ($detalle->result() as $det){
                if(isset($array_variables[$det->dd2k_factor]  )){
                  $array_maximos[$p]= ($det->dd2k_dosnivel=='SI')? 1 : $det->dd2k_nivelalto ;
                  $array_minimos[$p]= ($det->dd2k_dosnivel=='SI')? -1: $det->dd2k_nivelbajo ;
                  
                  $array_maximos_reales[$p]=  $det->dd2k_nivelalto ;
                  $array_minimos_reales[$p]=  $det->dd2k_nivelbajo ;
                    
                  if($det->dd2k_dosnivel=='SI'){
                   $DATOS_DE_VARIABLES[$p][]=-1;
                   $DATOS_DE_VARIABLES[$p][]=1;
                   $array_dosniveles[$p] = 'SI';
                  }                  
                  if($det->dd2k_dosnivel=='NO' && $det->dd2k_paso>0){
                  $array_dosniveles[$p] = 'NO';    
                  for($i=$det->dd2k_nivelbajo;$i<=$det->dd2k_nivelalto; $i+=$det->dd2k_paso){
                  $DATOS_DE_VARIABLES[$p][]=round($i,5);                     
                  }                       
                  }
                  if($det->dd2k_dosnivel=='NO' && $det->dd2k_paso<=0){
                   $array_dosniveles[$p] = 'SI';   
                   $DATOS_DE_VARIABLES[$p][]=-1;
                   $DATOS_DE_VARIABLES[$p][]=1;                      
                  }
                  $p++;
                }
            } 
            $numeroVariables = count( $DATOS_DE_VARIABLES);     
           
            $data = $this->respuesta($numeroVariables,$diseno2k->d2k_modelo,$DATOS_DE_VARIABLES,$array_maximos,$array_minimos,$array_maximos_reales,$array_minimos_reales,$array_dosniveles);  
            $data['diseno'] = $diseno2k;
           $menu = array ( array('val' => '<img class="qtip" alt="Volver" src="'.base_url().'assets/images/left.png" />','href'=>site_url('datos/diseno2k/detalle/'.$id) )
             );    
            $this->run('grafica',$data,'Diseño 2<sup>k</sup>',$menu, null,null,'diseno2k.js');                
                      
        }//si existe modelo y variables
        
     }
    }
    
    function guardar(){
      $nombrediseno      = $this->input->post('nombrediseno');
      $nombrerespuesta   = $this->input->post('nombrerespuesta');
      $unidadrespuesta   = $this->input->post('unidadrespuesta');
      $replicas       = $this->input->post('replicas');
      $nombres        =  $this->input->post('nombres');
      $nivelesb       =  $this->input->post('nivelesb');
      $nivelesa       =  $this->input->post('nivelesa');
      $unidades       =  $this->input->post('unidades');
      
      if($nombrerespuesta==''){
        $this->ajax_result(false,"El nombre de la variable de respuesta es requerido");   
        return;
      }
      
      if($unidadrespuesta==''){
        $this->ajax_result(false,"La unidad de la variable de respuesta es requerida");   
        return;
      }
      
       if($nombrediseno==''){
        $this->ajax_result(false,"El nombre del diseño es requerido");   
        return;
      }
      
      $numeroFactores = 0;
      foreach ($nombres as $id=>$nombre){
      if($nombre!=''){
       if($nivelesb[$id]!='' && $nivelesa[$id]!='' && $unidades[$id]!=''){
          
           $numeroFactores++;                 
           
       }else{
        $this->ajax_result(false,"Debe definir los niveles y las unidades.");   
        exit(0);    
       }         
      }      
      }
      
      if($numeroFactores<2){
      $this->ajax_result(false,"Por lo menos necesita dos variables.");  
        return;    
      }
      $datos =  Array('d2k_nombre'=>$nombrediseno,'d2k_usua_id'=>  $this->session->userdata('usuario_id'));
      $datos['d2k_fechacreacion'] = Date('Y-m-d H:i:s');
      $datos['d2k_replicas'] = $replicas;
      $datos['d2k_nombre_respuesta'] = $nombrerespuesta;
      $datos['d2k_unidad_respuesta'] = $unidadrespuesta;
      $d2k_id = $this->diseno2k_model->insertar_tablas('diseno2k',$datos );
      
       foreach ($nombres as $id=>$nombre){
           if($nivelesb[$id]!='' && $nivelesa[$id]!='' && $unidades[$id]!=''){
           $detalle['dd2k_d2k_id']    = $d2k_id;
           $detalle['dd2k_factor']    = $nombre;
           $detalle['dd2k_nivelbajo'] = $nivelesb[$id];
           $detalle['dd2k_nivelalto'] = $nivelesa[$id];           
           $detalle['dd2k_unidad']    = $unidades[$id];             
           $this->diseno2k_model->insertar_tablas('detalle_diseno2k',$detalle ); 
           }
       }
      
       $numerotratamientos = pow(2,$numeroFactores);
       $tratamientos = Array();
       for($i=0;$i<$numerotratamientos;$i++){
           $tratamientos[] = $i;
       }       
           
      for($i=1;$i<=$replicas;$i++){
        $claves_aleatorias = array_rand($tratamientos, $numerotratamientos);
        
        foreach ($claves_aleatorias as $clave){
         $trat['trat_d2k_id']     = $d2k_id;
         $trat['trat_replica']= $i;
         $trat['trat_numerotratamiento']= $clave;   
         $this->diseno2k_model->insertar_tablas('tratamientos',$trat ); 
        }
      }
      $result['detalle'] = site_url().'datos/diseno2k/detalle/'.$d2k_id;
      $this->ajax_result(true,'Diseño creado correctamente' ,$result);
       
    }   
      
    function eliminar(){        
       $id = $this->input->post('id');       
       $result = $this->diseno2k_model->eliminar('diseno2k','d2k_id', $id);        
        if($result){
            $this->ajax_result(true,"Se ha borrado el diseno2<sup>k</sup>!") ;
            return true;
        }else{
         $this->ajax_result(false,"No se pudo eliminar") ;
          return true;    
        }
    }
      
    function todos(){
        $this->session->unset_userdata('diseno2k_filtro');
        redirect('maestro/diseno2k/index');
    }
    
   function guardar_tratamientos(){
     $tratamientos   = $this->input->post('tratamientos'); 
     
     
     foreach ($tratamientos as $resp){
       if( $resp !='' ){
           if( !is_numeric($resp) ){
           $this->ajax_result(false,'Las respuestas deben ser numéricas.') ;
           return false;   
           }
       }
     }
     
     foreach ($tratamientos as $id=>$resp){
       if( $resp !='' ){
           if( is_numeric($resp) ){
           $this->diseno2k_model->modificar_tablas('tratamientos','trat_id',Array('trat_respuesta'=>$resp), $id);
           }
       }
     }
     
     $this->ajax_result(true,'Actualizado.') ;
     return true;       
   }
   
 function guardar_variables(){
      $dosnivel  = $this->input->post('dosnivel');  
      $pasos     = $this->input->post('pasos');     
      foreach ($pasos as $id=>$valor){
      $datos = array();
      
      $datos['dd2k_dosnivel']= (isset($dosnivel[$id]) )? 'SI':'NO';
      if(isset($dosnivel[$id])){
       $datos['dd2k_paso']=0;     
      }else{    
      $datos['dd2k_paso']= (is_numeric($valor)) ? $valor:0;
      }
      if(count($datos)>0){
      $this->diseno2k_model->modificar_tablas('detalle_diseno2k','dd2k_id',$datos,$id);    
      }
     }     
     
     $this->ajax_result(true,'Actualizado.') ;
     
     return true;      
 }
 
 function codificado($valorreal,$alto,$bajo){
        return ( (2/($alto-$bajo))*($valorreal-$alto) + 1) ;
    }
    
    function respuesta($numeroVariables,$modelo,$datos,$maximos,$minimos,$maximos_reales,$minimos_reales,$dosniveles){
    ini_set('memory_limit', '-1');
     $this->load->model('EvalMath'); 
     $this->EvalMath->evaluate($modelo);
        
     $respuesta     = Array();
     $combinaciones = Array();  
     $data          = Array();
     //4 variables--------------------------------------------------------   
     if($numeroVariables==4){          
      foreach ($datos[0] as $valort1){        
       foreach ($datos[1] as  $valort2){
         foreach ($datos[2] as  $valort3){
           foreach ($datos[3] as  $valort4){
         $respuesta[] = round($this->EvalMath->evaluate('f('.$this->codificado($valort1,$maximos[0],$minimos[0]).','.$this->codificado($valort2,$maximos[1],$minimos[1]).','.$this->codificado($valort3,$maximos[2],$minimos[2]).','.$this->codificado($valort4,$maximos[3],$minimos[3]).')') , 5); 
         $valort1p = ($dosniveles[0]=='SI' && $valort1==-1)? $minimos_reales[0]:( ($dosniveles[0]=='SI' && $valort1==1)? $maximos_reales[0] : $valort1 );
         $valort2p = ($dosniveles[1]=='SI' && $valort2==-1)? $minimos_reales[1]:( ($dosniveles[1]=='SI' && $valort2==1)? $maximos_reales[1] : $valort2 );
         $valort3p = ($dosniveles[2]=='SI' && $valort3==-1)? $minimos_reales[2]:( ($dosniveles[2]=='SI' && $valort3==1)? $maximos_reales[2] : $valort3 );
         $valort4p = ($dosniveles[3]=='SI' && $valort4==-1)? $minimos_reales[3]:( ($dosniveles[3]=='SI' && $valort4==1)? $maximos_reales[3] : $valort4 );
       
         $combinaciones[] = '('.$valort1p.','.$valort2p.','.$valort3p.','.$valort4p.')';
         }
       }   
     } 
    }
     $data['respuesta']     = $respuesta;
     $data['combinaciones'] = $combinaciones;
     }//fin 4---------------------------------------------------------------
     
     
     //3 variables----------------------------------------------------------   
     if($numeroVariables==3){          
      foreach ($datos[0] as $valort1){        
       foreach ($datos[1] as  $valort2){
         foreach ($datos[2] as  $valort3){
         $respuesta[] = round($this->EvalMath->evaluate('f('.$this->codificado($valort1,$maximos[0],$minimos[0]).','.$this->codificado($valort2,$maximos[1],$minimos[1]).','.$this->codificado($valort3,$maximos[2],$minimos[2]).')') , 5); 
         $valort1p = ($dosniveles[0]=='SI' && $valort1==-1)? $minimos_reales[0]:( ($dosniveles[0]=='SI' && $valort1==1)? $maximos_reales[0] : $valort1 );
         $valort2p = ($dosniveles[1]=='SI' && $valort2==-1)? $minimos_reales[1]:( ($dosniveles[1]=='SI' && $valort2==1)? $maximos_reales[1] : $valort2 );
         $valort3p = ($dosniveles[2]=='SI' && $valort3==-1)? $minimos_reales[2]:( ($dosniveles[2]=='SI' && $valort3==1)? $maximos_reales[2] : $valort3 );
       
         $combinaciones[] = '('.$valort1p.','.$valort2p.','.$valort3p.')';
         }
       }   
     } 
     $data['respuesta']     = $respuesta;
     $data['combinaciones'] = $combinaciones;
     }//fin 3---------------------------------------------------------------
     
      //2 variables---------------------------------------------------------
     if($numeroVariables==2){          
      foreach ($datos[0] as $valort1){
       foreach ($datos[1] as $valort2){        
         $respuesta[] = round($this->EvalMath->evaluate('f('.$this->codificado($valort1,$maximos[0],$minimos[0]).','.$this->codificado($valort2,$maximos[1],$minimos[1]).')') , 5); 
         $valort1p = ($dosniveles[0]=='SI' && $valort1==-1)? $minimos_reales[0]:( ($dosniveles[0]=='SI' && $valort1==1)? $maximos_reales[0] : $valort1 );
         $valort2p = ($dosniveles[1]=='SI' && $valort2==-1)? $minimos_reales[1]:( ($dosniveles[1]=='SI' && $valort2==1)? $maximos_reales[1] : $valort2 );
       
         $combinaciones[] = '('.$valort1p.','.$valort2p.')';         
       }   
     } 
     $data['respuesta']     = $respuesta;
     $data['combinaciones'] = $combinaciones;
     }//fin 2---------------------------------------------------------------
     
      //1 variables---------------------------------------------------------
     if($numeroVariables==1){          
      foreach ($datos[0] as $valort1){        
         $respuesta[] = round($this->EvalMath->evaluate('f('.$this->codificado($valort1,$maximos[0],$minimos[0]).')') , 5); 
         $valort1p = ($dosniveles[0]=='SI' && $valort1==-1)? $minimos_reales[0]:( ($dosniveles[0]=='SI' && $valort1==1)? $maximos_reales[0] : $valort1 );
        
         $combinaciones[] = '('.$valort1p.')';          
     }
     $data['respuesta']     = $respuesta;
     $data['combinaciones'] = $combinaciones;
     }//fin 1---------------------------------------------------------------
     
     
     
     return $data;
    }//fin de la funcion
 
}