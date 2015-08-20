   $( function(){       
   $('#div_anobacompleto').hide();  
   $("#btnguardar_diseno2k").click(function(e){
          
    submit_formui(e,"#form_nuevo_diseno2k" , null,
    function(j){
           if(j.ret)
            {
               $("#div_nuevo_diseno2k").dialog("close");       
               location.href=j.detalle;
            }else
                {
                  $.unblockUI();
                   alerta(j.msg);
                }
    }
    );
    mostrar_tip();
    });
    });  
    
function nuevo_diseno2k(){
    new_boxui('','#div_nuevo_diseno2k','Nuevo Diseño 2<sup>k</sup>',980,440);
    }  
    
function eliminar_diseno2k(id){
      confirmar("Realmente desea eliminar éste diseño?", function(){
      url= $("#url_eliminar").val();
      data1="id="+id;
      $.blockUI({message: '<h1> Espere por favor...</h1>'});
      ajax_util(url, data1,'json', function(j){
        if(j.ret){            
         location.reload();         
        }else{
         $.unblockUI();   
        alerta(j.msg);    
        }
        });    
      });
    }  
    
function guardar_tratamientos(){
$.blockUI({message: '<h1> Espere por favor...</h1>'}); 
submit_formui(null,"#form_tratamientos" , null,
    function(j){
           if(j.ret)
            {                 
            location.reload();
            }else
                {
                  $.unblockUI();
                   alerta(j.msg);
                }
    }
    );
     
} 

function guardar_variables(){
$.blockUI({message: '<h1> Espere por favor...</h1>'}); 
submit_formui(null,"#form_variables" , null,
    function(j){
           if(j.ret)
            {              
          location.reload();
            }else
                {
                  $.unblockUI();
                   alerta(j.msg);
                }
    }
    );
     
} 

function ver_anobacompleto(){
    seve = $('#seve_div_anobacompleto').val();
    if(seve=='SI'){
     $('#seve_div_anobacompleto').val('NO'); 
     $('#div_anobacompleto').hide();  
    }else{
     $('#div_anobacompleto').show();    
     $('#seve_div_anobacompleto').val('SI');   
    }
  
}

function ver_tratamientos(){
    seve = $('#seve_div_tratamientos').val();
    if(seve=='SI'){
     $('#seve_div_tratamientos').val('NO'); 
     $('#div_tratamientos').hide();  
    }else{
     $('#div_tratamientos').show();    
     $('#seve_div_tratamientos').val('SI');   
    }
  
}