<?=doctype('html4-trans');?>
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	<title>Vista de impresion</title>
         <link type="text/css" href="<?=base_url()?>assets/js/jquery-ui-1.8.9/css/south-street/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
        <?=$jsfiles?>	
	<?=$cssfiles?>
      
    <script type="text/javascript">
        <?=(is_null($jsfile)) ? '' : $jsfile?>
    </script>
	</head>
<body>
    <div style="text-align: right">
        <input type="button" value="imprimir" onclick="imprimir()"></input>
    </div>
    <div class="n_mod_content" style="width:100%; height:600px; overflow: scroll;">
       <?=$content?>
   </div>
</body>
<script type="text/javascript">
function imprimir(){
   $("div.n_mod_content").printArea();
}
</script>	
</html>
