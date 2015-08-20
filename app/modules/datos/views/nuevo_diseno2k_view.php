    <div id="div_nuevo_diseno2k" class="boxydiv ">
         <form  action="<?=site_url('datos/diseno2k/guardar/')?>" id="form_nuevo_diseno2k">
              <table border="0" width="100%" class="n_grid detail_table" id="n_grid2" cellpadding="0" cellspacing="1">
              <tbody>
                <tr>
                <td align="left"> <label><strong>Nombre de Diseño</strong></label></td>
                 <td align="center"><input type="text"  value=""  name="nombrediseno" style="width: 350px"/></td>
                 <td align="center"> <label><strong>Réplicas</strong></label> </td>                   
                 <td align="center">
                     <select name="replicas" style="width: 50px">
                             <option value="2">2</option>
                             <option value="3">3</option>
                             <option value="4">4</option>
                             <option value="5">5</option>                             
                         </select>  
                     </td>
              </tr>
              <tr>
               <td align="left">  <label><strong>Nombre Variable de Respuesta</strong></label></td>  
               <td align="center"> <input type="text"  value=""  name="nombrerespuesta" style="width: 350px"/> </td>
               <td align="center"><label><strong>Unidad</strong></label></td>
               <td align="center"><input type="text"  value=""  name="unidadrespuesta" style="width: 50px"/></td>
              </tr>
               </tbody>
        </table>
                                     
                <h2>Variables de Proceso</h2>
                <table border="0" width="100%" class="n_grid detail_table" id="n_grid" cellpadding="0" cellspacing="1">
        <thead>
            <tr>
                <th align="center"></th>                              
                <th align="center">Nombre</th>
                <th align="center">Nivel Bajo</th>
                <th align="center">Nivel Alto</th>
                <th align="center">Unidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center" style="color: green">A</td>                              
                <td align="center"><input type="text" value="" name="nombres[]" /> </td>
                <td align="center"><input type="text" value="" name="nivelesb[]" /></td>
                <td align="center"><input type="text" value="" name="nivelesa[]" /></td>
                <td align="center"><input type="text" value="" name="unidades[]" /></td>
            </tr>  
             <tr>
                <td align="center" style="color: blue">B</td>                              
                <td align="center"><input type="text" value="" name="nombres[]" /> </td>
                <td align="center"><input type="text" value="" name="nivelesb[]" /></td>
                <td align="center"><input type="text" value="" name="nivelesa[]" /></td>
                <td align="center"><input type="text" value="" name="unidades[]" /></td>
            </tr> 
             <tr>
                <td align="center" style="color: #f66">C</td>                              
                <td align="center"><input type="text" value="" name="nombres[]" /> </td>
                <td align="center"><input type="text" value="" name="nivelesb[]" /></td>
                <td align="center"><input type="text" value="" name="nivelesa[]" /></td>
                <td align="center"><input type="text" value="" name="unidades[]" /></td>
            </tr>  
             <tr>
                <td align="center" style="color: darkorchid">D</td>                              
                <td align="center"><input type="text" value="" name="nombres[]" /> </td>
                <td align="center"><input type="text" value="" name="nivelesb[]" /></td>
                <td align="center"><input type="text" value="" name="nivelesa[]" /></td>
                <td align="center"><input type="text" value="" name="unidades[]" /></td>
            </tr> 
             <tr>
                <td align="center" style="color: fuchsia">E</td>                              
                <td align="center"><input type="text" value="" name="nombres[]" /> </td>
                <td align="center"><input type="text" value="" name="nivelesb[]" /></td>
                <td align="center"><input type="text" value="" name="nivelesa[]" /></td>
                <td align="center"><input type="text" value="" name="unidades[]" /></td>
            </tr>  
        </tbody>
        </table>
        <div style="text-align:center">        
        <input type="button" id="btnguardar_diseno2k" value="Guardar"/>
        </div>    
       </form>
    </div>