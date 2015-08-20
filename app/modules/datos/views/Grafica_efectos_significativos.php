<div id="container" style="width: 70%; height: 400px; margin: 0 auto"></div>
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
            renderTo: 'container',        
            type: 'column',
            zoomType: 'y'
        },
        title: {
            text: 'Efectos Estimados'
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
                text: 'Efecto Estimado'
            }            
                        
        },
        legend: {
            enabled: false
        },
        tooltip: {
            formatter: function () {  
              return  Highcharts.numberFormat(this.point.y*100/<?=$total?>,1)+'%';
            
            }
        },
        series: [{
            name: 'Efectos',
            data: [               
                <?foreach($efectos as $nombre=>$valor):?>  
                     
                {name: '<b><?=$nombre?></b>',y: <?=$valor?>},
                <?endforeach;?>                          
            ],
            dataLabels: {
                enabled: true,
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