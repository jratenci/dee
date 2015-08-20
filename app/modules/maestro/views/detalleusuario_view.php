<div class="comp_info_box">
    <form action="<?=site_url()?>maestro/detalleusuario/editar/<?=$usuario->usua_id?>" id="form_editar_detalleusuario" onclick="return false;">
        
    <table>   
        <tr>
            <td><strong>ID</strong></td>
            <td><input type="text" value="<?=$usuario->usua_id?>" onFocus="blur()" /> </td>
        </tr>
        <tr>
            <td><strong>Nombre</strong></td>
            <td><input type="text" value="<?=$usuario->usua_nombre?>" onFocus="blur()" /> </td>
        </tr>
         <tr>
            <td><strong>Usuario</strong></td>
            <td><input type="text" value="<?=$usuario->usua_usuario?>" onFocus="blur()" /> </td>
        </tr>
        <tr>
            <td><strong>Correo</strong></td>
            <td><input type="text" name="usuarios[usua_correo]" value="<?=$usuario->usua_correo?>"  /> </td>
        </tr>
       
        <tr>
            <td><strong>Clave</strong></td>
            <td><input type="password" value="<?=$usuario->usua_clave?>" name="usuarios[usua_clave]"> </td>
        </tr>      
         
        
    </table>
   </form>
</div>