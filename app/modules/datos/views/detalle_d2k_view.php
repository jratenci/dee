    <div id="div_detalle_diseno2k">
        <div style="text-align: center">      
        <label style="font-size:20px;color: #46912f;"><strong>Nombre:</strong></label>
        <label style="font-size:20px;" ><?=$diseno2k->d2k_nombre?></label>
        <label style="font-size:20px;color: #46912f; padding-left: 30px"><strong>Réplicas:</strong></label>                    
        <label style="font-size:20px;"><?=$diseno2k->d2k_replicas?></label>              
        </div>     
                
     <div style="text-align: center">   
      <form  action="<?=site_url('datos/diseno2k/guardar_variables/')?>" id="form_variables">    
      <h1 style="font-size:20px;padding-top: 20px;color: black ">Variables de Proceso
        <a style="" href="#" onclick="guardar_variables();return false;">
            <img src="<?php echo base_url()?>assets/images/save_16.png" title="guardar" />
        </a> 
      </h1>    
     <table style="width: 50%;" align="center" border="0" width="100%" class="n_grid detail_table" id="n_grid" cellpadding="0" cellspacing="1">
         <thead>
            <tr>                                            
                <th align="center">Nombre</th>
                <th align="center">Nivel Bajo</th>
                <th align="center">Nivel Alto</th>
                <th align="center">Unidad</th>
                <th align="center">Dos Niveles</th>
                <th align="center">Paso</th>
            </tr>
        </thead>
        <tbody>
            <?if($detalle):?>
            <?foreach ($detalle->result() as $d):?>
             <tr>                                     
                <td align="center"><?=$d->dd2k_factor?></td>
                <td align="center"><?=$d->dd2k_nivelbajo?></td>
                <td align="center"><?=$d->dd2k_nivelalto?></td>
                <td align="center"><?=$d->dd2k_unidad?></td>
                <td align="center"><input type="checkbox" name="dosnivel[<?=$d->dd2k_id?>]" value="SI"  <?if($d->dd2k_dosnivel=='SI') echo "checked";?> ></td>
                <td align="center"><input type="text" name="pasos[<?=$d->dd2k_id?>]" value="<?=$d->dd2k_paso?>" style="width:40px "></td>
            </tr>
            <?endforeach;?>
            <?endif;?>
        </tbody>    
                          
     </table>
      </form>
     </div>
      <form  action="<?=site_url('datos/diseno2k/guardar_tratamientos/')?>" id="form_tratamientos">          
       <input type="hidden" id="seve_div_tratamientos" value="SI"/>
      <div style="text-align: center;"> 
      <div style="text-align: center;">    
      <h1 style="font-size:20px;padding-top: 20px;color: black; width: 100%; ">Tratamientos
       <a style="" href="#" onclick="ver_tratamientos();return false;">
           <img src="<?php echo base_url()?>assets/images/add-row.png" title="ver-ocultar" />
       </a> 
           <a style="" href="#" onclick="guardar_tratamientos();return false;">
            <img src="<?php echo base_url()?>assets/images/save.png"  title="guardar tratamientos"/>
       </a> 
      </h1>
      </div> 
      <div id="div_tratamientos">    
     <table style="width: 70%;" align="center" border="0" width="100%" class="n_grid detail_table" id="n_grid2" cellpadding="0" cellspacing="1">
         <thead>
             <?if($detalle):?>
             <?
               $factores = Array();
               $niveles  = Array();
             ?>
             <tr>
            <th align="center">Replica</th>   
            <th align="center">Tratamiento</th>   
            <?$i=0;?>
            <?foreach ($detalle->result() as $d):?> 
            <?
            $factores[$i]      =$d->dd2k_factor;
            $niveles[$i]['-1'] = $d->dd2k_nivelbajo;
            $niveles[$i]['1']  = $d->dd2k_nivelalto;
            $i++;
            ?>
            
             <th align="center"><?=$d->dd2k_factor?></th>               
            <?endforeach;?>
             <th align="center"><?=$d->d2k_nombre_respuesta.'['.$d->d2k_unidad_respuesta.']'?></th>    
             </tr>             
            <?endif;?>
        </thead>
        <tbody>
            <?$i=1;?>
            <?foreach ($tratamientos->result() as $tra):?>
            <?$j = 0;?>
             <tr>
             <td align="center"><?=$tra->trat_replica?></td>        
             <td align="center"><?=$i++?></td>    
             <?foreach ($tablasignos[$tra->trat_numerotratamiento] as $t):?>
              <td align="center"><?=$niveles[$j++][$t]?></td>              
             <?endforeach;?>              
               <td align="center"> <input style="width:70px " name="tratamientos[<?=$tra->trat_id?>]" type="text" value="<?=$tra->trat_respuesta?>"/> </td> 
             </tr>
             <?$j++?>
             <?endforeach;?>  
       
        </tbody>                      
     </table>
      </div>
       </div>
           </form>
         <br/>
         <?if($hayanalisis):?>
          <div style="text-align: center">     
           <h1 style="font-size:20px;padding-top: 20px;color: black ">Análisis de Resultados</h1>
           <h1>ANOVA Completo
            <a style="" href="#" onclick="ver_anobacompleto();return false;">
            <img src="<?php echo base_url()?>assets/images/add-row.png" title="ver-ocultar" />
           </a>                
           </h1>
           <div id="div_anobacompleto">
               <input type="hidden" id="seve_div_anobacompleto" value="NO"/>
                <table style="width: 70%;" align="center" border="0" width="100%" class="n_grid detail_table" id="n_grid3" cellpadding="0" cellspacing="1">
                   <thead></thead>
                    <tbody>                    
                    <tr>
                        <td style="background-color:#7cb5ec" align="center"><b>Efectos</b></td>
                        <td style="background-color:#7cb5ec"align="center"><b>SC</b></td>
                        <td style="background-color:#7cb5ec"align="center"><b>GL</b></td>
                        <td style="background-color:#7cb5ec"align="center"><b>CM</b></td>
                        <td style="background-color:#7cb5ec"align="center"><b>F<sub>0</sub></b></td>
                        <td style="background-color:#7cb5ec"align="center"><b>F</b></td>
                        <td style="background-color:#7cb5ec"align="center"><b>Valor-p</b></td>
                    </tr>                        
                      <?foreach($nombreefectos as $id=> $nombreEfecto):?>
                       <tr>
                        <td align="center"><b><?=$nombreEfecto?></b></td>
                        <td align="center"><b><?=(  ($sc[$id]>1)? round($sc[$id],2): $sc[$id] )?></b></td>
                        <td align="center"><b>1</b></td>
                        <td align="center"><b><?=(  ($sc[$id]>1)? round($sc[$id],2): $sc[$id] )?></b></td>
                        <td align="center"><b><?=round($F0[$id],2)?></b></td>
                        <td align="center"><b><?=round($F[$id],2)?></b></td>
                        <td align="center"><b><?=($Valorp[$id])?></b></td>
                        </tr>                        
                      <?endforeach;?> 
                       <tr>
                        <td align="center"><b>Error</b></td>
                        <td align="center"><b><?=(  ($SCError>1)? round($SCError,2): $SCError )?></b></td>
                        <td align="center"><b><?=$GLError?></b></td>
                        <td align="center"><b><?=(  ($CMError>1)? round($CMError,2): $CMError )?></b></td>
                        <td align="center"><b></b></td>
                        <td align="center"><b></b></td>
                         <td align="center"><b></b></td>
                        </tr>
                        
                        <tr>
                        <td align="center"><b>Total</b></td>
                        <td align="center"><b><?=(  ($SCTotal>1)? round($SCTotal,2): $SCTotal )?></b></td>
                        <td align="center"><b><?=$GLTotal?></b></td>
                        <td align="center"><b></b></td>
                        <td align="center"><b></b></td>
                        <td align="center"><b></b></td>
                        <td align="center"><b></b></td>
                        </tr>                         
                    </tbody>
                </table>
           </div>
           <h1>Efectos Significativos</h1>
           <table style="width: 70%;" align="center" border="0" width="100%" class="n_grid detail_table" id="n_grid4" cellpadding="0" cellspacing="1">
              <tr>
                <?foreach($interaccionesafectan as $inter):?>
                   <?foreach ($inter as $nombre):?>
                     <td align="center"><b><?=$nombre?></b></td>       
                   <?endforeach;?>
                <?endforeach;?>   
               </tr>
           </table>
           <?=$Grafica_efectos_estandarizados?>
           
            <h1>Modelo Matemático Unitario</h1>
            <b><?=$modelo?> 
                <a style=""  target="_blank" href="<?=site_url('datos/diseno2k/analisisrespuesta')?>/<?=$diseno2k->d2k_id?>">
            <img src="<?php echo base_url()?>assets/images/abonos_temp.png" title="Analisis" />
           </a>  
            </b>
           <?=$vistagrafica_view?>
          </div>
         <?endif;?>
    </div>