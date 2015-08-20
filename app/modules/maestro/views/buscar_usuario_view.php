<div id="div_buscar_usuario" class="boxydiv boxy-content ">
    <form action="<?=site_url('maestro/usuario/index/')?>" id="form_buscar_usuario" method="post">
        <table class="formulario">
            <tr>
                <td>C&eacute;dula</td>
                <td><input type="text" name="usuario[usua_cedula]"></td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input type="text" name="usuario[usua_nombre]" ></td>
            </tr>
            <tr>
                   <td>Rol </td>
                   <td align="center">
                       <select name="usuario[rol_id]" >
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
                <td></td>
                <td><input type="submit" value="Buscar" id="guardar_usuario"></td>
            </tr>
        </table>
    </form>
</div>