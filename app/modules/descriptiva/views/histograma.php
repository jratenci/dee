<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
//    print_r($relativas);
var relativasJS     = <?php echo json_encode($relativas);?> ;
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Histograma'
        },
        subtitle: {
            text: 'Source: DEE'
        },
        xAxis: {
            categories: [
                'Datos'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Frecuencia'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
        pointPadding: 0,
        borderWidth: 0,
        groupPadding: 0,
        shadow: false
    }
        },
        series: [{
            name: 'datos',
            data: relativasJS

        }]
    });
});
</script>