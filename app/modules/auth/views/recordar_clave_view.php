<div id="div_recordar" class="boxydiv">
    <form action="<?=site_url('auth/registro/recordar/')?>" id="form_recordar" method="post">
        <table class="formulario">           
            <tr>
                <td>Correo</td>
                <td><input type="text" name="recordar[usua_correo]"></td>
            </tr>
                        
            <tr>
                <td></td>
                <td><input type="submit" value="Enviar" id="guardar_recoradar"></td>
            </tr>            
        </table>
                <p style="color: #46912F; font-size: 12px; padding-left: 15px">
                    Se te enviar&aacute; un correo electr&oacute;nico con tus<br/>
                    credenciales en CrisolDEE.                                  
              </p>
    </form>
</div>