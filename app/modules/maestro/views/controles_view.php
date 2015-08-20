<div id="div_acciones">
 <a style="" href="#" onClick="nuevo_control();return false;">     
   <img  src="<?php echo base_url()?>assets/images/add-row.png" alt="Agregar control"/>
 </a>    
    <input type="hidden" id="id_estacion_controles"   value="" />
    <input type="hidden" id="nombre_estacion_controles"   value="" />
   <?if($controles){?>    
<input type="hidden" id="url_eliminar_control" value="<?=site_url()?>maestro/estaciones/eliminar_control" />
<input type="hidden" id="url_editar_control" value="<?=site_url()?>maestro/estaciones/editar_control" />

<input type="hidden" id="url_controles" value="<?=site_url()?>maestro/estaciones/controles" />
      
    <table border="0" width="100%" class="n_grid detail_table" id="n_grid" cellpadding="0" cellspacing="1">
      <thead>
            <tr>
                <th align="center">Sensor</th>
                <th align="center">Condición</th>
                <th align="center">Valor</th>               
                <th align="center">Acción</th>
                <th align="center">Valor</th>
                <th align="center">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($controles->result() as $c):?>            
            
            <tr id='rowcontrol<?=$c->cont_id?>'>
               
             <td  align="center"><?=$c->sens_nombre?></td>
             <td align="center"> <?=$c->cont_operador?> </td>  
             <td align="center"> <?=$c->cont_valor_sensor?></td>               
             <td align="center"> <?=$c->acci_codigo?> </td> 
             <td align="center"> <?=$c->cont_valor_accion?> </td>        
              
             <td id='tdaccion_eliminar<?=$e->acci_id?>' align="center">
               <a href="" onClick="eliminar_control('<?=$c->cont_id?>');return false;">
                   <img src="<?php echo base_url()?>assets/images/cancel.png" />
               </a>                 
            </td>
            </tr>
            <?endforeach;?>
        </tbody>
    </table>
    
  <?}else {?>
   <div style="text-align: center; padding: 60px;color:#46912F;line-height: 20px; word-spacing: -1px; font-weight: bold; font-size: 18px; font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
     No se encontraron controles
  </div>
    <?}?>
<?=$vista_nuevo_control?>

</div>
