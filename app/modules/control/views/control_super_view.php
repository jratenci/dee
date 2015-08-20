<?=doctype('html4-trans');?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/toolbar.css" />
		<title>:: <?=$this->config->item('titulo','titles')?>::</title>
		<style type="text/css">
			a{color:#4D4D4D;text-decoration:none}
			body{font-size:9pt; font-family: arial; margin:0px;padding:0px}

			.control_panel{ list-style-image:none; list-style-position:outside; list-style-type:none; margin:0; padding:0; width:700px;}
			.control_panel li{float: left;margin:10px}
			.control_panel a {
				color:#46912F;
				display:block;
				font-weight:bold;
				height:77px;
				padding-left:70px;
				padding-top:15px;
				text-decoration:none;
				width:90px;
			}
			.control_panel a:hover{
				color:#FAF47A;
			}
               .control_panel .mante{font-size: 8pt;background:transparent url(<?=base_url()?>/assets/images/config.png) no-repeat scroll center center;}

        </style>
	</head>
	<body>
		<div class="n_wrapper">

			<div class="n_top_toolbar">
				<div class="n_main_title">
				<h1>	:: <?=$this->config->item('control','titles')?> ::</h1>
				</div>
				<div class="nsubmenu" >
                     <?if($this->session->userdata('rol_nom')!='SUPER'):?>
     				<b><?=strtoupper($this->session->userdata('com_nom'))?></b>::<b><?= strtoupper($this->session->userdata('bod_nom'))?></b>
                     <?endif;?>
                      <?if($this->session->userdata('rol_nom')=='SUPER'):?>
                     <b><?='SUPER USUARIO'?></b>
                     <?endif;?>
                    <a href="<?=base_url()?>tmp/GUIA_NERP.pdf" class="sub_help">ayuda</a>
					 &nbsp;&nbsp;:: &nbsp;&nbsp;
					<a title="salir del sistema" href="<?php echo site_url('auth/inicio/logout')?>" class="sub_out">salir</a>
				</div>
			</div>

	    	<div class="n_main" style="width:580px;margin:0px auto">

			<ul class="control_panel">
            <li>
			<a href="<?php echo site_url('configuracion/inicio') ?>" class="mante">Configuracion General</a>
			</li>
            </ul>


   		</div>

		</div>
	</body>
</html>
