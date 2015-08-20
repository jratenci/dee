<!DOCTYPE html> 
<html> 
<head> 
	<title>:: CrisolDEE ::</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="<?=base_url()?>assets/js/jquery.mobile-1.1.0/jquery.mobile-1.1.0.min.css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/js/jquery.mobile-1.1.0/jquery.mobile.theme-1.1.0.min.css" />
	
        <script src="<?=base_url()?>assets/js/jquery-1.6.4.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.mobile-1.1.0/jquery.mobile-1.1.0.min.js"></script>
</head> 
<body> 

<div data-role="page">

    <div data-role="header" data-theme="b">
	<h1>Login</h1>
        <a data-direction="reverse" data-iconpos="notext" data-icon="home" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" title="Login"></a>
    </div><!-- /header -->

    <div data-role="content" data-theme="b">
      <form action="form.php" method="post" >     
	<label for="basic"><strong>Usuario:</strong></label>
        <input data-mini="true" type="text" name="name" id="basic" value=""  />	
        <label for="basic"><strong>Clave:</strong></label>
        <input data-mini="true" type="password" name="name" id="basic" value=""  />	
        <input data-mini="true" type="submit" name="name" id="submit" value="Enviar"  />	
      </form>       
    </div><!-- /content -->

</div><!-- /page -->

</body>
</html>