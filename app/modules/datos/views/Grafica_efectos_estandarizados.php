<div id="container2" style="width:100%; height: 400px; margin: 0 auto"></div>
<?
$total = 0;
  foreach($efectos as $nombre=>$valor){
    $total+=$valor;
  }
?>
<script> 
  $(function () {
   var chart;
	chart= new Highcharts.Chart({
        chart: {
            renderTo: 'container2',        
            type: 'column',
            zoomType: 'y'
        },
        title: {
            text: 'Pareto de Efectos Estimados'
        },
        subtitle: {
            text: '<span><b style="color:blue; font-size:13px">+</b></span>  <span><b style="color:#FF7DFF;font-size:14px">-</b></span>'
        },
        
        xAxis: {
            type: 'category',
            labels: {               
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Efecto Estandarizado'
            },
           
            plotLines: [{
                value: <?=$StudentParaEfectoEstandarizado?>,
                color: 'red',
                dashStyle: 'shortdot',
                width: 0.5,
                label: {
                    text: '<?=$StudentParaEfectoEstandarizado?>',
                    align: 'right',
                    style: {
                        color: 'gray'
                    }
                }
            }]
            
        },
        legend: {
            enabled: false
        },
        tooltip: {
            formatter: function () {  
              return  Highcharts.numberFormat(this.point.y,3);
            
            }
        },
        series: [{
            name: 'Efectos',
            data: [               
                <?foreach($efectosestandarizados as $nombre=>$valor):?>  
                     
                {name: '<b style="font-size:8px"><?=$nombre?></b>',y: <?=$valor?>, color:<?=( ($estandarizados_signos[$nombre]=='+')? '"#7cb5ec"': '"#FF7DFF"' )  ?> },
                <?endforeach;?>                          
            ],
            dataLabels: {
                enabled: false,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                x: 4,
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif',
                    textShadow: '0 0 3px black'
                }
            }
        }]
    });
});

function sumar_serie(arreglo){
var index;
var total_serie = 0;
for(index = 0; index < arreglo.length; index++) {
    total_serie += arreglo[index].y;
} 

return total_serie;
}
</script>