/**
 * General jscript 
 * for NERP
 *
 */
var box = null;
$(function(){
    
    $.ajaxSetup({ cache:false });
	$("input.ref_autocomplete").autocomplete("/index.php/inventario/productos/list_items/one", {
		max: 4,
		highlight: false,
		scroll: true,
		formatItem: function(d, i, n, value) {
			return value.split("¬")[0];
		},
		formatResult: function(data, value) {
			return value.split("¬")[0];
		}
	});


	// estilo para tablas de datos
	$("#n_grid").tablesorter({ widgets: ['zebra']});
        $("#n_grid2").tablesorter({ widgets: ['zebra']});
        $("#n_grid3").tablesorter({ widgets: ['zebra']});
        $("#n_grid4").tablesorter({ widgets: ['zebra']});
        $("#n_grid5").tablesorter({ widgets: ['zebra']});

    // Title menu tip
	
        $("a.menu_tip").each(function()
	{
		$(this).css('display','block');
		$( this ).qtip(
		{
			content:$(this).attr('rel'),
			style:
			{
				tip: 'leftTop',
				name: 'light',
				border: {
					 width: 3,
					 radius: 5,
					 color: '#A2D959'
				 }
			}
		});
	});

    
	// Ajax tip
	$("img.qtip").each(function()
	{
		$(this).css('display','block');
		$( this ).qtip(
		{
			content:
			{
				url:$(this).attr('alt')
			},
			style:
			{
				 tip: 'leftTop',
				name: 'light',
				border: {
					 width: 3,
					 radius: 5,
					 color: '#A2D959'
				 }
			}
		});
	});



/**
  *Paginacion
  *
  */
 $('#xpagin_porpagina_1').change(function(){
     //alert( $('#xpagin_porpagina option:selected').val());
   //  alert('hola');
       $.get($('#index').val(),{'per_page': $('#xpagin_porpagina_1 option:selected').val()
           }, function(data){
            return false;
        location.reload(true);
       }); //post

     return false;
    });

 $('#xpagin_pagina_1').change(function(){
    action =  $('#form_xpagin_1').attr('action');
    total_paginas = $('#pagin_total_1').val();
    ir_pagina = $(this).val();
    if(parseInt(ir_pagina)>parseInt(total_paginas))ir_pagina= total_paginas;

    offset = ($('#xpagin_porpagina_1 option:selected').val()*ir_pagina - $('#xpagin_porpagina_1 option:selected').val());
    if(offset <=0) offset = '';

    action = action+'/' +offset;
     $('#form_xpagin_1').attr('action',action);
     $('#form_xpagin_1').submit();
    return false;
    });

   $('#xpagin_pagina_2').change(function(){
    action =  $('#form_xpagin_2').attr('action');
    total_paginas = $('#pagin_total_2').val();
    ir_pagina = $(this).val();
    if(parseInt(ir_pagina)>parseInt(total_paginas))ir_pagina= total_paginas;

    offset = ($('#xpagin_porpagina_2 option:selected').val()*ir_pagina - $('#xpagin_porpagina_2 option:selected').val());
    if(offset <=0) offset = '';

    action = action+'/' +offset;
     $('#form_xpagin_2').attr('action',action);
     $('#form_xpagin_2').submit();
    return false;
    });

    $('#xpagin_porpagina_1').change(function(){
     //alert( $('#xpagin_porpagina option:selected').val());
    $('#form_xpagin_1').submit();
     return false;
    });

 $('#xpagin_porpagina_2').change(function(){
     //alert( $('#xpagin_porpagina option:selected').val());
    $('#form_xpagin_2').submit();
     return false;
    });

   //fin paginacion


$('.date-pick').datepicker({
			inline: true,
			dateFormat: 'yy-mm-dd',
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octobre','Noviembre','Diciembre']
								//minDate: new Date(2010, 12 - 1, 18),
		});



});

function new_box(e, div, tit)
{
	e.preventDefault();
	
	box = new Boxy
	(
		div,
		{
			title:tit
		}
	);
}
function cl_submit_form(e,urlToReload, form,validate_rules,with_ajax,reload_page)
{
	e.preventDefault();
	result = valid_form(form,validate_rules);
	ajax = (typeof with_ajax == "undefined") ? true : with_ajax;
	reload = (typeof with_ajax == "undefined") ? true : reload_page;
	if(result)
	{
		if(ajax)
		{
			var options = 
			{
				dataType:'json',
				type:'post',
				success: function(j)
				{
					if(j.ret)
					{
						new Boxy.alert(
						j.msg, 
						function(){
							window.location = urlToReload;
						}, 
						{title: 'Enhorabuena',modal:false});
						
						
					}
					else
					{
						new Boxy.alert(j.msg, null, {title: 'Error',modal:false});
					}
					
				}
				
			}
			$(form).ajaxSubmit(options);	
		}
		else
		{
			$(form).submit();
		}
		
	}
	return false;
}
function submit_form(e,form,validate_rules,with_ajax,reload_page)
{
	e.preventDefault();
	result = valid_form(form,validate_rules);
	ajax = (typeof with_ajax == "undefined") ? true : with_ajax;
	reload = (typeof with_ajax == "undefined") ? true : reload_page;
	if(result)
	{
		if(ajax)
		{
			var options = 
			{
				dataType:'json',
				type:'post',
				success: function(j)
				{
					if(j.ret)
					{
						new Boxy.alert(j.msg, null, {title: 'Enhorabuena',modal:false});
						
						location.reload();
					}
					else
					{
						new Boxy.alert(j.msg, null, {title: 'Error',modal:false});
					}
					
				}
				
			}
			$(form).ajaxSubmit(options);	
		}
		else
		{
			$(form).submit();
		}
		
	}
	return false;
}

