$(function(){
    
     reglas_usuario ={rules:{
                       "usuarios[usua_cedula]":{required:true},
                       "usuarios[usua_nombre]":{required:true},
                       "usuarios[usua_movil]":{number:true},
                       "usuarios[usua_clave]":{required:true}
                       },
                       messages:{
                       "usuarios[usua_cedula]":{required:"Digite la cédula"},
                       "usuarios[usua_nombre]":{required:"Digite el nombre"},
                       "usuarios[usua_movil]":{number:"Debe ser numérico(ejem: 4 ó 4.1)"},
                       "usuarios[usua_clave]":{required:"Digite una clave"}
                       }

                  };
                  
       
});//end onready
   
   
function editar_usuario()
{
   this.alerta('Realmente desea actualizar?',function(){
       submit_formui('','#form_editar_detalleusuario',reglas_usuario,function(j){
           location.reload();
       });
       mostrar_tip();
   });
}