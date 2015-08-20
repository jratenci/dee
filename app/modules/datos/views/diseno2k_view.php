<div>
    <?if($diseno2k){?>
    <input type="hidden" id="url_eliminar" value="<?=site_url()?>datos/diseno2k/eliminar" />
        <div style=" height: 30px; padding-right:15px;  text-align: right" >
        <div id="link" style="padding: 10px; float: right; text-align: center">
        <form action="<?=site_url('datos/diseno2k/index')?>"  id="form_xpagin_1" method="post">
        <?=$this->pagination->create_links(1,$per_page)?>
        </form>
    </div>
    </div>
   <input type="hidden" id="url_eliminar" value="<?=site_url()?>datos/diseno2k/eliminar" />
   
    <table border="0" width="100%" class="n_grid detail_table" id="n_grid" cellpadding="0" cellspacing="1">
        <thead>
            <tr>
                <th align="center">ID</th>                              
                <th align="center">Nombre</th>
                <th align="center">Factores</th>
                <th align="center">Replicas</th>
                <th align="center">Tratamientos</th>
                <th align="center">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($diseno2k->result() as $row_diseno2k):?>          
            <tr>                 
                <td align="center"><?=$row_diseno2k->d2k_id?></td>
                <td align="center"><?=$row_diseno2k->d2k_nombre?></td>                
                <td align="center"><?=$row_diseno2k->factores?></td>                
                <td align="center"><?=$row_diseno2k->d2k_replicas?></td>                
                            
                <td align="center">
                    <a href="<?=site_url()?>datos/diseno2k/detalle/<?=$row_diseno2k->d2k_id?>" >
                   <img class="qtip" src="<?=base_url()?>assets/images/edit.png" alt="tratamientos"/>
                 </a>                    
                </td>
                <td  align="center">
                <a href="#" onclick="eliminar_diseno2k('<?=$row_diseno2k->d2k_id?>');return false;">
                   <img src="<?php echo base_url()?>assets/images/cancel.png" />
                 </a>                    
                </td>
            </tr>
            <?endforeach;?>
        </tbody>
    </table>
   <div style=" height: 30px; padding-right:15px;  text-align: right" >
        <div id="link" style="padding: 10px; float: right; text-align: center">
        <form action="<?=site_url('datos/diseno2k/index')?>"  id="form_xpagin_2" method="post">
        <?=$this->pagination->create_links(2,$per_page)?>
        </form>
    </div>
    </div>
    <?}else {?>
    <div style="text-align: center; padding: 60px;color:#46912F;line-height: 20px; word-spacing: -1px; font-weight: bold; font-size: 18px; font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
       No se encontraron diseños 2<sup>k</sup>.
    </div>
    <?}?>
</div>
<?=$vista_nuevo_diseno2k?>