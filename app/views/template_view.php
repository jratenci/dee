<?=doctype('html4-trans');?>
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	<title><?=$title?></title>
         <link type="text/css" href="<?=base_url()?>assets/js/jquery-ui-1.8.9/css/south-street/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
        
	<?=$jsfiles?>
	<?=$cssfiles?>
      
    <script type="text/javascript">
        <?=(is_null($jsfile)) ? '' : $jsfile?>
    </script>
	</head>
<body>
	<div class="n_wrapper">
            <input type="hidden" id="path_server" value="<?=base_url()?>"/>
			<div class="n_top_toolbar">
				<div class="n_main_title">
					<h1><?=$title?></h1>
				</div>
				<div class="nsubmenu">
                                Usuario: <b><?=strtoupper($this->session->userdata('usuario_nombre'))?></b>:: ID <b><?=strtoupper($this->session->userdata('usuario_id'))?></b>
                              	<a href="<?=site_url('control/inicio')?>" class="sub_back">volver al menú</a>
					 &nbsp; &nbsp;:: &nbsp;&nbsp;
					<a href="" class="sub_help">ayuda</a>
					 &nbsp;&nbsp;:: &nbsp;&nbsp;
					<a title="salir del sistema" href="<?=site_url('auth/inicio/logout')?>" class="sub_out">salir</a>
				</div>
			</div>
			
			<div class="n_main">
			
				<div class="n_left">
					<?=$left_menu?>
				</div>
				
				<div class="main_content" >
					<div class="n_mod_bar">
						<div class="n_mod_items" >
							<?=$mod_menu?>
						</div>
						<div class="n_mod_title" >
						 	<h1 style="text-align: center" id="mod_title"><?=$mod_title?></h1>
						</div>
					</div>
					<div class="n_mod_content">
						<?=$content?>
					</div>
				</div>
				<div class="fixed"></div>
			</div>
		</div> 
	</body>
	
</html>
