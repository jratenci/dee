    $( function(){

    var reglas_usuario = {rules:{
                "usuarios[usua_nombre]":{required:true},
                "usuarios[usua_cedula]":{required:true},
                "usuarios[usua_clave]":{required:true},
                "usuarios[usua_rol_id]":{required:true},
                "usuarios[usua_finc_id]":{required:true}
                },
                messages:{
                "usuarios[usua_nombre]":{required:"Digite el nombre"},
                "usuarios[usua_cedula]":{required:"Digite la cedula"},
                "usuarios[usua_clave]":{required:"Digite la clave"},
                "usuarios[usua_rol_id]":{required:"Seleccione el rol"},
                "usuarios[usua_finc_id]":{required:"Seleccione la finca"}
                     }
            };

    $(function (){
    var pickerOpts={
    dateFormat:"yy/mm/dd",
    dayNamesMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
    monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]
    };
    $(".datepicker").datepicker(pickerOpts)
    });


    $("#btnguardar_usuario").click(function(e){
    
    rol=$("#selectrol_add_user option:selected").text();
    bodega=$("#add_cultivo option:selected").text();
    
    submit_formui(e,"#form_nuevo_usuario" , reglas_usuario,
    function(j){
           if(j.ret)
            {
               $("#div_nuevo_usuario").dialog("close");          
               add_fill_usuario(j.usua_cedula,j.usua_nombre,j.usua_movil,j.usua_direccion,j.usua_fecha,rol,j.usua_rol_id,j.usua_clave,j.usua_id,bodega,j.usua_bode_id);
               $.unblockUI();
            }else
                {
                  $.unblockUI();
                   alerta(j.msg);
                }
    }
    );
    mostrar_tip();
    });

    $("#btneditar_usuario").click(function(e){

    rol=$("#txtrol_editar_usuario option:selected").text();
    bodega=$("#txtbodega_editar_usuario option:selected").text();

    submit_formui(e,"#form_editar_usuario" , reglas_usuario,
    function(j){
           if(j.ret)
            {
               $("#div_editar_usuario").dialog("close");          
               edit_fill_usuario(j.usua_cedula,j.usua_nombre,j.usua_movil,j.usua_direccion,j.usua_fecha,rol,j.usua_rol_id,j.usua_estado,j.usua_clave,j.usua_id,bodega,j.usua_bode_id);
               $.unblockUI();
            }else
                {
                  $.unblockUI();
                   alerta(j.msg);
                }
    }
    );
    mostrar_tip();
    });

    });//fin on ready


    function nuevo_usuario(){
    new_boxui('','#div_nuevo_usuario','Nuevo usuario',360,450);
    }

    function editar_usuario(cedula,nombre,celular,direccion,fecha,rol,estado,clave,id,bodega)
    {
    $("#txtid_editar_usuario").val(id);
    $("#txtnombre_editar_usuario").val(nombre);
    $("#txtcedula_editar_usuario").val(cedula);
    $("#txtrol_editar_usuario").val(rol);
    $("#txtclave_editar_usuario").val(clave);
    $("#txtcelular_editar_usuario").val(celular);
    $("#txtdireccion_editar_usuario").val(direccion);
    $("#selectestado_editar_usuario").val(estado);
    $("#txtfecha_editar_usuario").val(fecha);
    $("#txtbodega_editar_usuario").val(bodega);

    new_boxui('','#div_editar_usuario','Editar usuario',350,490);

    }

    function buscar_usuario(){

    new_boxui('','#div_buscar_usuario','Buscar usuario',320,220);

    }
    
    function  add_fill_usuario(cedula,nombre,telefono,direccion,fecha,rol,rol_id,clave,usua_id,bodega,bode_id)
    {
      
      var row = "<tr id='rowusua"+usua_id+"'>"+
                      '<td id="tdusua_ced'+usua_id+'" align="center">'+
                         '<label  for="ced_usua">'+cedula+'</label>'+
                      '</td>'+
                      
                       '<td id="tdusua_nom'+usua_id+'" align="center">'+
                         '<label  for="nom_usua">'+nombre+'</label>'+
                      '</td>'+ 
                      
                       '<td id="tdusua_tel'+usua_id+'" align="center">'+
                         '<label  for="tel_usua">'+telefono+'</label>'+
                      '</td>'+ 
                      
                       '<td id="tdusua_dir'+usua_id+'" align="center">'+
                         '<label  for="dir_usua">'+direccion+'</label>'+
                      '</td>'+ 
                      
                       '<td id="tdusua_fecha'+usua_id+'" align="center">'+
                         '<label  for="fecha_usua">'+fecha+'</label>'+
                      '</td>'+ 
                      
                       '<td id="tdusua_rol'+usua_id+'" align="center">'+
                         '<label  for="rol_usua">'+rol+'</label>'+
                      '</td>'+ 
                      
                       '<td id="tdusua_clave'+usua_id+'" align="center">'+
                         '<label  for="clave_usua">'+clave+'</label>'+
                      '</td>'+ 
                      
                       '<td id="tdusua_bode'+usua_id+'" align="center">'+
                         '<label  for="bode_usua">'+bodega+'</label>'+
                      '</td>'+ 
                      
                       '<td id="tdusua_estado'+usua_id+'" align="center">'+
                         '<label  for="estado_usua">'+'Activo'+'</label>'+
                      '</td>'+ 
                                              
                      '<td  id="tdusua_edit'+usua_id+'" align="center">'+
                      "<a href='#' onClick='editar_usuario(\""+cedula+"\",\""+nombre+"\",\""+telefono+"\",\""+direccion+"\",\""+fecha+"\",\""+rol_id+"\",\""+'A'+"\",\""+clave+"\",\""+usua_id+"\",\""+bode_id+"\"); return false;'><img src='<?=base_url()?>/assets/images/edit.png' title='Editar usuario'/></a>"+
                    '</td>'+'<tr>';
          $("#n_grid tbody").append(row);
                   
    }
   
   function  edit_fill_usuario(cedula,nombre,movil,direccion,fecha,rol,rol_id,estado,clave,usua_id,bodega,bode_id)
   {
       est= (estado=='A')?'Activo':'Inactivo';
       
       str_estado = '<label for="estado_usua">'+est+'</label>';
      
       str_edit =  "<a href='#' onClick='editar_usuario(\""+cedula+"\",\""+nombre+"\",\""+movil+"\",\""+direccion+"\",\""+fecha+"\",\""+rol_id+"\",\""+estado+"\",\""+clave+"\",\""+usua_id+"\",\""+bode_id+"\"); return false;'><img src='<?=base_url()?>/assets/images/edit.png' title='Editar usuario'/></a>";
                    
       $("#tdusua_ced"+usua_id).html('<label  for="ced_usua">'+cedula+'</label>');    
       $("#tdusua_nom"+usua_id).html('<label  for="nom_usua">'+nombre+'</label>');    
       $("#tdusua_ced"+usua_id).html('<label  for="ced_usua">'+cedula+'</label>');    
       $("#tdusua_tel"+usua_id).html('<label  for="tel_usua">'+movil+'</label>');    
       $("#tdusua_dir"+usua_id).html('<label  for="dir_usua">'+direccion+'</label>');    
       $("#tdusua_fecha"+usua_id).html('<label  for="fecha_usua">'+fecha+'</label>');    
       $("#tdusua_rol"+usua_id).html('<label  for="rol_usua">'+rol+'</label>');    
       $("#tdusua_clave"+usua_id).html('<label  for="clave_usua">'+clave+'</label>');    
       $("#tdusua_bode"+usua_id).html('<label  for="bode_usua">'+bodega+'</label>');    
       $("#tdusua_estado"+usua_id).html(str_estado);    
       
       $("#tdusua_edit"+usua_id).html(str_edit);   
   }
              