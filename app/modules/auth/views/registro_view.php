<div id="div_registro" class="boxydiv">
    <form action="<?=site_url('auth/registro/guardar/')?>" id="form_registro" method="post">
        <table class="formulario">
            <tr>
                <td>Nombre</td>
                <td><input type="text" name="registro[regi_nombre]"></td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td><input type="text" name="registro[regi_usuario]"></td>
            </tr>
            <tr>
                <td>Clave</td>
                <td><input type="text" name="registro[regi_clave]" ></td>
            </tr>
            <tr>
                <td>Correo</td>
                <td><input type="text" name="registro[regi_correo]"></td>
            </tr>
                        
            <tr>
                <td></td>
                <td><input type="submit" value="Enviar" id="guardar_registro"></td>
            </tr>            
        </table>
                <p style="color: #46912F; font-size: 12px; padding-left: 15px">
                    Se te enviar&aacute; un correo electr&oacute;nico con un link<br/>
                    donde podras activar tu cuenta en CrisolDEE.                                    
              </p>
    </form>
</div>