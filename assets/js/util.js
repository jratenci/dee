/**
 * @e evento que ocurre,
 * @form, id del formulario a enviar
 * @reg, reglas de validacion
 * @action, funcion que se ejecuta despues de cerrar la ventana de dialogo
 */
function  submit_formui(e,form,reg, action,reset){
  // e.preventDefault();
   p= valid_form(form,reg);

   if(p){
      $.blockUI({message: '<h1> Espere por favor...</h1>'});
       var options ={dataType:'json',
			 type:'post',
                         success: function(j){                                 
				  if(j.ret){
                                      $.unblockUI();
                                         //   Boxy.alert(j.msg, null, {title: 'Enhorabuena',modal:false});
                                     $('<div><b>'+j.msg+'</b></div>').dialog({title: 'Mensaje del sistema' ,modal:true,height: 150 ,
                                    buttons: {
			        	Ok: function() {$( this ).dialog( "close" );
                                            $.blockUI({message: ''});
                                            $(form).each (function(){this.reset();});
                                            if(action!=null) action(j);
                                            }
			                      }
                                           });
                   			 $(form).each (function(){this.reset();});
					}else{
                                            $.unblockUI();
                                            $('<div><b>'+j.msg+'</b></div>').dialog({title: 'Error',modal:true,height: 160 ,
                                         buttons: {
			        	 Ok: function() {$( this ).dialog( "close" );}
			                      }
                                           });
					  }
				}
			}
              $(form).ajaxSubmit(options);
               }//fin if p
              return false;
            }


function mostrar_tip(){
    $("a.menu_tip").each(function()
	            {
		$(this).css('display');
		$( this ).qtip(
		{position: {target: 'mouse'},
			content:$(this).attr('rel'),
			style:
			{
				tip: 'topLeft',
				name: 'light',
				border: {
					 width: 3,
					 radius: 5,
					 color: '#2fb12f'
				 }
                             }
		});
	});
}


function valid_form(form,rules){
  	var v = $(form).validate(rules);
	if(v.form())
		return true;
	else
		return false;
}

function new_boxui(e, div, tit,ancho,alto,onclose) {

  box= $(div).dialog({title: tit ,modal:false,width:ancho,height:alto,
 show: 'fade', hide: 'fade' ,
 close:function(){if(onclose !=null)onclose();
    }
   });
  return box;
}

function ajax_util(url,datos,tipo,funcion){        
    
   $.ajax({
        dataType:tipo,
        type: "POST",
        url: url,   
        cache:false,
        data: datos,// e.g "nombre=Juan&apellido=Luna"
        success: function(j){
        funcion(j);

      },
      error: function(objeto, quepaso, otroobj){
           alert(otroobj);
           
      }
});
}

function alerta(mensage,funcion){
 $('<div><b>'+mensage+'</b></div>').dialog({title:'' ,modal:true,height: 150 , width:350,
                 buttons: {
		       	Ok: function() {$( this ).dialog( "close" );
                          if(funcion !=null)funcion();
                            }
		                     }
                });
}

function confirmar(mensage,funcion){
    $('<div><b>'+mensage+'</b></div>').dialog({title:'' ,modal:true,height: 150 , width:350,
                show: 'fade', hide: 'fade' ,
                buttons: {
		       	Ok: function() {
                          $(this).dialog('close');
                          if(funcion !=null)funcion();
                        },
                        Cancelar: function() {$( this ).dialog( "close" );}
		                     }
                });   
}


function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function delcommas(nStr)
{

   nStr = nStr.replace(',','');
   return nStr;
    
}

function formatCurrency(num) {
num = num.toString().replace(/$|,/g,'');
if(isNaN(num))
num = "0";
sign = (num == (num = Math.abs(num)));
num = Math.floor(num*100+0.50000000001);
cents = num%100;
num = Math.floor(num/100).toString();
if(cents<10)
cents = "0" + cents;
for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
num = num.substring(0,num.length-(4*i+3))+','+
num.substring(num.length-(4*i+3));
return (((sign)?'':'-') + num );
}


function formato_numero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}