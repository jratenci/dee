<html>
  <head>
    <title>:: CrisolDEE ::</title>
<script src="<?=base_url()?>assets/js/jquery-1.4.1.js" type="text/javascript"></script>
<link type="text/css" href="<?=base_url()?>assets/js/jquery-ui-1.8.9/css/south-street/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
<link type="text/css" href="<?=base_url()?>assets/css/main.css" rel="stylesheet" />

<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.8.9/js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?=base_url()?>assets/js/jquery.qtip-1.0.0-rc3.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/jquery.blockui.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/jquery.form.js" type="text/javascript"></script>

<script src="<?=base_url()?>assets/js/util.js" type="text/javascript"></script>

    <style type="text/css">
		body{ font-size: 9pt; margin:0px;padding:0px;font-family: arial; color:#666 }
		div#banner {
                margin-top: 30px;
                margin-left: 20px;
                }
                div.main1{border: 1px dotted #ddd; margin: 80px auto; background-color: #CDEB8B}
		div.content1{width:700px; margin: 0px auto; padding: 5px 0px 10px 0px}
                div.logo{                
                font-weight: bold;    
                color: #fff;
                width: 300px;
                float: left;
                font-size: 12px;
                border-right: 1px dotted #fff;
                }
		div.form{margin-left: 180px}
		.fixed{clear:both}
		input[type="text"], input[type="password"]
		{
			color: #666;
			border: 1px solid #ddd;
			padding: 5px;
		}

		input[type="submit"]{
			padding: 3px;
			-moz-border-radius: 5px;
			border: 1px solid #ddd;
			-ms-border-radius: 5px; /* IE 8.*/
			-webkit-border-radius: 5px; /* Safari,Chrome.*/
			border-radius: 5px; /* El estándar.*/
                        cursor: pointer;
		}

                select{
			padding: 3px;
			-moz-border-radius: 5px;
			border: 1px solid #ddd;
			-ms-border-radius: 5px; /* IE 8.*/
			-webkit-border-radius: 5px; /* Safari,Chrome.*/
			border-radius: 5px; /* El estándar.*/
		}
		div.error{background: #FF4141; color: white; padding:5px; text-align:center}

                img {border:none; color:  #2fb12f}

                div.footer_sc{
                color:#999;
                text-align: center;
                margin-top: 100px
                  }
                 
                  a:link {text-decoration:none; color: #FFFFFF; font-weight: bold;  } /* Link no visitado*/
                  a:visited {text-decoration:none; color:#FFFFFF;} /*Link visitado*/
                  a:active {text-decoration:none; color:#FFFFFF;; background:#FFFFFF;} /*Link activo*/
               
                  div.boxydiv{display:none;padding:10px;margin:0px;font-size:9pt}

    </style>
  </head>

  <body>
      <div id="banner">
        <img src="<?=base_url()?>assets/images/crisol.png" title=""/>
       <div style="float: right ">
        <p style=" padding-right: 60px;color:#46912F;line-height: 20px; word-spacing: -1px; font-weight: bold; font-size: 15px; font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
          CrisolDEE es una aplicaci&oacute;n  que le permitira crear,almacenar y analizar<br/>
         sus dise&#241;os estadisticos de experimentos.<br/>
          <br/>                             
        </p>
       </div>
       
      </div>  
     
      <div class="main1">
         
          <div class="logo" style="padding:10px">             
          </div>
    
          <div class="content1" >  
                   <div class="logo">
		  <p>
                    Bienvenido a CrisolDEE, <br/>
                    Para empezar a realizarsus dise&#241;os<br/>
                    estadisticos de experimentos, ingrese al sistema<br/>
                    con las credenciales que le fueron asignadas.                    
                    </p>
	     </div>
             <input type="hidden" id="path_server" value="<?=base_url()?>"/>
                    <div class="form">
           <form id="auth_form" method="POST" action="<?=site_url('auth/inicio/valid_user')?>">
	   <table>
	     <tr>
	       <td>Usuario </td>
	       <td><input type="text" name="usuario[usua_usuario]" /></td>
	    </tr>
	    <tr>
               <td>Clave </td>
	       <td><input type="password" name="usuario[usua_clave]" /></td>
	    </tr>
             <tr>
	      <td></td>
	      <td><input type="submit" value="Entrar" id="auth_enviar" /></td>
	    </tr>
	 </table>
	</form>
    </div>
       <?if(!is_null($msg)):?>
       <div class="error"><?=$msg?></div>
       <?endif;?>
         </div>
          <div style="text-align: center; color:#46912F">
            <a style="color:#46912F" onclick="registro();return false;" href="">Reg&iacute;strate</a>
            <a onclick="recordar();return false;" href="" style="padding-left: 20px;color:#46912F">Olvidaste tu clave?</a>
        </div>
      </div>
       <div class="footer_sc">
            <p>  &copy; 2014 CrisolDEE Powered by <a style="color: black" target="_blank" href="http://codeigniter.com">CI</a>
            <br/>jatencio@eafit.edu.co
            </p>
        </div>
     <?=$vista_registro;?>
     <?=$vista_recordar?> 
  </body>
  <script>
  $( function(){
     
   var reglas_auth = {rules:{
                    "usuario[usua_usuario]":{required:true},
                    "usuario[usua_clave]":{required:true}
                    },
                    messages:{
                    "usuario[usua_usuario]":{required:"el usuario es requerido"},
                    "usuario[usua_clave]":{required:"la clave es requerida"}

                         }
                };
   
  var reglas_registro = {rules:{
                    "registro[regi_nombre]":{required:true},
                    "registro[regi_usuario]":{required:true},
                    "registro[regi_clave]":{required:true},
                    "registro[regi_correo]":{required:true}
                    },
                    messages:{
                    "registro[regi_nombre]":{required:"el nombre es requerido"},
                    "registro[regi_usuario]":{required:"el usuario es requerido"},
                    "registro[regi_clave]":{required:"la clave es requerida"},
                    "registro[regi_correo]":{required:"la direccion de correo es requerida"}

                         }
                }; 

  $('#auth_enviar').click(function(e){
  e.preventDefault();
   p= valid_form('#auth_form',reglas_auth);
   mostrar_tip();
   if(p){
        $('#auth_form').submit();
      }//fin if p

    return false;

});

$('#guardar_registro').click(function(e){
  
   submit_formui(e,"#form_registro",reglas_registro,function(j){
      $('#div_registro').dialog('close'); 
      $.unblockUI();  
   });
   return false;
});

$('#guardar_recoradar').click(function(e){
  
   submit_formui(e,"#form_recordar",null,function(j){
      $('#div_recordar').dialog('close'); 
      $.unblockUI();  
   });
   return false;
});

  
  });//fin onready
  
  function registro(){
    new_boxui('','#div_registro','Reg&iacute;stro',300,340);  
  }
  
  function recordar(){
   new_boxui('','#div_recordar','Recordar Clave',300,190);    
  }
  </script>
</html>