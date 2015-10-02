<?php
/**
 | Configuracion general para NERP
*/
/*
 | Activar o Inactivar el profile
 |
*/
$config['enable_profiler'] = FALSE;
/**
 | Archivos comunes para el funcionamiento
 |
*/
$config['files']['jsfile'] = 'jscript.js';
$config['files']['module_menu'] = 'menu_view';
$config['files']['layout'] = 'template_view';


/**
 | assets comunes de la aplicacion
 |
*/
$config['assets']['js'] = array('jquery-1.4.4',
                                'jquery-ui-1.8.9/js/jquery-ui-1.8.9.custom.min',
                                'highcharts/js/highcharts',
                                 'highcharts/js/highcharts-more',
                                'highcharts/js/modules/exporting',
                                'jquery.bgiframe.min',                               
                                'jquery.qtip-1.0.0-rc3.min',
                                'jquery.validate',
                                'jquery.form',
                                'jquery.boxy',
                                'jquery.tablesorter.min',
                                'jquery.maskedinput-1.2.2.min',
                                'jquery.loading',
                                'jquery.blockui',
                                'query.printarea',
                                'general',
                                'util',
                                'multiselect'  
                                );
$config['assets']['css'] = array('toolbar','main','boxy','autocomplete','multiselect');


$config['titles']['control']='Panel de Control';
$config['titles']['titulo']='CrisolDEE';
