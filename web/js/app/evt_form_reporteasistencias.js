function recarga()
{ 
    var options = {
        chart: {
            renderTo: 'container_highchart',
            type: 'column',
            margin: [ 50, 50, 120, 80],
//            options3d: {
//                enabled: true,
//                alpha: 15,
//                beta: 15,
//                depth: 50,
//                viewDistance: 25
//            }
           
 
        },
        title: {
            text: 'Reporte de Asistencias por Eventos'
        },
		subtitle: {
                text: '',
				 style: {
						color: 'rgb(85,85,85)',
						fontWeight: 'bold'
						},
				 align: 'center'
				
            },
        xAxis: [],
        yAxis: {
            min: 0,
            title: {
                text: 'Número de Asistentes'
            }
        },
        legend: {
            layout: 'vertical',
            backgroundColor: '#FFFFFF',
            align: 'left',
            verticalAlign: 'top',
            x: 80,
            y: 40,
            floating: true,
            shadow: true
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.x +'</b><br/>' + this.series.name + ': ' + this.y + ' Alumnos';
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
        },
        series: []
    }
    var url = 'index.php?controller=reporteasistencias&action=get&caso=grafico1';
    var xAxis = {
        
        categories: [],
        labels: {
            rotation: -17,
            align: 'right',
            style: {
                fontSize: '12px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    };
    var seriesTotal = {
        data: []
    };
    seriesTotal.name = 'Total';
    var seriesMasculino = {
        data: []
    };
    seriesMasculino.name = 'Asistio';
    var seriesFemenino = {
        data: []
    };
    seriesFemenino.name = 'No Asistio';
    jQuery.getJSON(url, function(data) {
        jQuery.each(data, function(key1,val1) {
            xAxis.categories.push(key1);
            jQuery.each(val1, function(key2,val2) {
                if(key2 == 0){
                    seriesTotal.data.push(val2);
                }
                else if(key2 == 1){
                    seriesMasculino.data.push(val2);
                }
                else if(key2 == 2){
                    seriesFemenino.data.push(val2);
                }
            });
        });
        options.xAxis.push(xAxis);
        options.series.push(seriesTotal);
        options.series.push(seriesMasculino);
        options.series.push(seriesFemenino);
        var chart = new Highcharts.Chart(options);
    });
    return false;
}     
$(function() {
   

   

    $("#save").click(function() {
        bval = true;
        
        if (bval) {
            $("#frm").submit();
        }
        return false;
    });
});

