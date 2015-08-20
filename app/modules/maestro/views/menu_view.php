<ul class="n_left_menu" style="">
    <li><a class="menu_tip" href="<?=site_url('maestro/detalleusuario')?>" rel="Detalle del usuario"><img src="<?=base_url()?>assets/images/estado_cuenta.png"/></a></li>
      <?if($this->session->userdata('rol')==1):?>
    <li><a class="menu_tip" href="<?=site_url('maestro/usuario')?>" rel="Usuarios"><img src="<?base_url()?>assets/images/terceros.png" /></a></li>
     <?endif;?>
     
  </ul>