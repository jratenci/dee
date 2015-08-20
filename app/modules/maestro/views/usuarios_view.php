<div>
   <?if($usuarios){?>
    <div style=" height: 30px; padding-right:15px;  text-align: right" >
        <div id="link" style="padding: 10px; float: right; text-align: center">
        <form action="<?=site_url('maestro/usuario/index')?>"  id="form_xpagin_1" method="post">
        <?=$this->pagination->create_links(1,$per_page)?>
        </form>

    </div>
    </div>
    <table border="0" width="100%" class="n_grid detail_table" id="n_grid" cellpadding="0" cellspacing="1">
        <thead>
            <tr>
                <th align="center">C&eacute;dula</th>
                <th align="center">Nombre</th>
                <th align="center">Tel&eacute;fono</th>
                <th align="center">Direcci&oacute;n</th>
                <th align="center">Fecha Nacimiento</th>
                <th align="center">Rol</th> 
                <th align="center">Clave</th> 
                <th align="center">Bodega</th> 
                <th align="center">Estado</th>
                <th align="center">Editar</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($usuarios->result() as $usuario):?>
            
            <tr id='rowusua<?=$usuario->usua_id?>'>
                
                <td id='tdusua_ced<?=$usuario->usua_id?>'  align="center">
                     <label for="ced_usua"><?=$usuario->usua_cedula?></label>
                </td>
                 <td id='tdusua_nom<?=$usuario->usua_id?>'  align="center">
                     <label for="nom_usua"><?=$usuario->usua_nombre?></label>
                </td>
                 <td id='tdusua_tel<?=$usuario->usua_id?>'  align="center">
                     <label for="tel_usua"><?=$usuario->usua_movil?></label>
                </td>
                 <td id='tdusua_dir<?=$usuario->usua_id?>'  align="center">
                     <label for="dir_usua"><?=$usuario->usua_direccion?></label>
                </td>
                 <td id='tdusua_fecha<?=$usuario->usua_id?>'  align="center">
                     <label for="fecha_usua"><?=$usuario->usua_fecha?></label>
                </td>
                 <td id='tdusua_rol<?=$usuario->usua_id?>'  align="center">
                     <label for="rol_usua"><?=$usuario->rol_nombre?></label>
                </td>
                 <td id='tdusua_clave<?=$usuario->usua_id?>'  align="center">
                     <label for="clave_usua"><?=$usuario->usua_clave?></label>
                </td>
                 <td id='tdusua_bode<?=$usuario->usua_id?>'  align="center">
                     <label for="bode_usua"><?=$usuario->bode_nombre?></label>
                </td>
                 <td id='tdusua_estado<?=$usuario->usua_id?>'  align="center">
                     <label for="estado_usua"><?=($usuario->usua_estado=='A')? 'Activo':'Inactivo'?></label>
                </td>
                <td id='tdusua_edit<?=$usuario->usua_id?>' align="center">
                <a href="" onclick="editar_usuario('<?=$usuario->usua_cedula?>','<?=$usuario->usua_nombre?>','<?=$usuario->usua_movil?>','<?=$usuario->usua_direccion?>','<?=$usuario->usua_fecha?>','<?=$usuario->rol_id?>','<?=$usuario->usua_estado?>','<?=$usuario->usua_clave?>','<?=$usuario->usua_id?>','<?=$usuario->bode_id?>');return false;">
                   <img class="qtip" src="<?php echo base_url()?>assets/images/edit.png" alt="Editar"/>
                 </a>
                </td>
            </tr>
            <?endforeach;?>
        </tbody>
    </table>
   <div style=" height: 30px; padding-right:15px;  text-align: right" >
        <div id="link" style="padding: 10px; float: right; text-align: center">
        <form action="<?=site_url('maestro/usuario/index')?>"  id="form_xpagin_2" method="post">
        <?=$this->pagination->create_links(2,$per_page)?>
        </form>

    </div>
    </div>
  <?}else {?>
    <div>No se encontraron usuarios</div>
    <?}?>
</div>

<?=$vista_nuevo_usuario?>
<?=$vista_editar_usuario?>
<?=$vista_buscar_usuario?>