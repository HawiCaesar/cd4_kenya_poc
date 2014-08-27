<script type="text/javascript">
		$(function () {
            $('#container').highcharts({
                title: {
                    text: 'Graphical Representation',
                    x: -20 //center
                },
                subtitle: {
                    text: '<?php if($customized==1){ foreach($categories as $category){ echo $category." ";  }} else { } ?>',
                    x: -10
                },
                xAxis: {
                        categories: <?php if($customized==1){ echo $customized;}else{ echo json_encode($categories); } ?>

                    },
                yAxis: {
                     title: { text: 'Tests Done' }
                   
                },
                
                tooltip: {
                     valueSuffix: '<?php if($percentage_flag==1){ echo " %";}else{ }?>'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                credits: {
                    enabled: false
                },
                yAxis: {
                    min: 0
                },
                series:  <?php echo json_encode($graph_data); ?> 
            });
        });
</script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>