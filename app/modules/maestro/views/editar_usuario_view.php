<div id="div_editar_usuario" class="boxydiv boxy-content ">
    <form action="<?=site_url('maestro/usuario/editar/')?>" id="form_editar_usuario">
        <input type="hidden" id="txtid_editar_usuario" name="id_editar_usuario">
        <table class="formulario">
            <tr>
                <td>Nombre</td>
                <td><input type="text" id="txtnombre_editar_usuario" name="usuarios[usua_nombre]" ></td>
            </tr>
            <tr>
                <td>Cedula</td>
                <td><input type="text" id="txtcedula_editar_usuario" name="usuarios[usua_cedula]"></td>
            </tr>
             <tr>
               <td>Rol </td>
	       <td align="center">
                   <select id="txtrol_editar_usuario" name="usuarios[usua_rol_id]" >
                      <?if($roles):?>
                        <?foreach($roles->result() as $rol):?>
                           <option value="<?=$rol->rol_id?>"><?=$rol->rol_nombre?></option>
                        <?endforeach;?>
                       <?endif;?>
                   </select>
               </td>
	    </tr>
            <tr>
            <td>Bodegas</td>
            <td>
                <select id="txtbodega_editar_usuario" name="usuarios[usua_bode_id]" style="float: left">                   
                     <?if($bodegas):?>
                    <?foreach ($bodegas->result() as $bo ):?>
                     <option value="<?=$bo->bode_id?>" ><?=$bo->bode_nombre?></option>
                    <?endforeach;?>
                    <?endif;?>
                </select>
                </td>
        </tr> 
            <tr>
                <td>Clave</td>
                <td><input type="password" id="txtclave_editar_usuario" name="usuarios[usua_clave]"></td>
            </tr>
            <tr>
                <td>Tel&eacute;fono</td>
                <td><input type="text" id="txtcelular_editar_usuario" name="usuarios[usua_movil]"></td>
            </tr>
            <tr>
                <td>Direcci&oacute;n</td>
                <td><input type="text" id="txtdireccion_editar_usuario" name="usuarios[usua_direccion]"></td>
            </tr>
            <tr>
                <td>Fecha Nacimiento</td>
                <td><input type="text" id="txtfecha_editar_usuario" name="usuarios[usua_fecha]" class="datepicker"></td>
            </tr>
            <tr>
               <td>Estado </td>
	       <td align="center">
                   <select id="selectestado_editar_usuario" name="usuarios[usua_estado]" >
                       <option value="A">Activo</option>
                       <option value="I">Inactivo</option>
                   </select>
               </td>
	    </tr>
            <tr>
                <td></td>
                <td><input type="button" value="Guardar" id="btneditar_usuario"></td>
            </tr>
        </table>
    </form>
</div>