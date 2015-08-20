<div id="div_nuevo_usuario" class="boxydiv">
    <form action="<?=site_url('maestro/usuario/guardar/')?>" id="form_nuevo_usuario">
        <table class="formulario">
            <tr>
                <td>Nombre</td>
                <td><input type="text" name="usuarios[usua_nombre]" ></td>
            </tr>
            <tr>
                <td>C&eacute;dula</td>
                <td><input type="text" name="usuarios[usua_cedula]"></td>
            </tr>
             <tr>
                   <td>Rol </td>
                   <td align="center">
                       <select id="selectrol_add_user" name="usuarios[usua_rol_id]" >
                           <option value="">Seleccionar</option>
                           <?if($roles):?>
                            <?foreach($roles->result() as $rol):?>
                              <option value="<?=$rol->rol_id?>"><?=$rol->rol_nombre?></option>
                            <?endforeach;?>
                           <?endif;?>
                       </select>
                   </td>
	      </tr>
            <tr>
                <td>Bodega</td>
                <td>
                 <select id="add_cultivo" name="usuarios[usua_bode_id]" style="float: left">
                    <option value="">Seleccionar</option>
                     <?if($bodegas):?>
                    <?foreach ($bodegas->result() as $bode ):?>
                     <option value="<?=$bode->bode_id?>"><?=$bode->bode_nombre?></option>
                    <?endforeach;?>
                    <?endif;?>
                </select>
                </td>
            </tr> 
             <tr>
                <td>Clave</td>
                <td><input type="password" name="usuarios[usua_clave]"></td>
            </tr>
            <tr>
                <td>Tel&eacute;fono</td>
                <td><input type="text" name="usuarios[usua_movil]"></td>
            </tr>
            <tr>
                <td>Direcci&oacute;n</td>
                <td><input type="text" name="usuarios[usua_direccion]"></td>
            </tr>
            <tr>
                <td>Fecha Nacimiento</td>
                <td><input type="text" name="usuarios[usua_fecha]" class="datepicker"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" value="Guardar" id="btnguardar_usuario"></td>
            </tr>
        </table>
    </form>
</div>