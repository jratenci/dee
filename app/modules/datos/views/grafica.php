<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script> 
 var respuestaJS     = <?php echo json_encode($respuesta);?> ;
 var combinacionesJS = <?php echo json_encode($combinaciones);?> ;
 
$(function () {
   var chart;
	chart= new Highcharts.Chart({
         chart: {
            renderTo: 'container',        
            type: 'scatter',
            zoomType: 'xy'
        },
        title: {
            text:'<?='Analisis de Respuesta Media '.$diseno->d2k_nombre?>'
        },
         subtitle: {
            text:'',
            x: -20
        },

        xAxis: {
           
        },

        yAxis: {
          title: {
                text: '<?=$diseno->d2k_nombre_respuesta.'['.$diseno->d2k_unidad_respuesta.']'?>'
            }  
        },
       plotOptions: {
            scatter: {
                marker: {
                    radius: 2
                }
            }
       },
        tooltip: {
                 formatter: function () {  
                    
              return '<b> '+combinacionesJS[this.x-1]+' , '+this.y+ '</b>';
                    
            }
        },

        series: [{
                name:'<?='('.str_replace('*',',', $diseno->d2k_variables).')'?>',    
            data: respuestaJS
            ,
            pointStart: 1
        }]
    });
});

</script> 