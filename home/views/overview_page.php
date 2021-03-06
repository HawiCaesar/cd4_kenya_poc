<div class="row"> <!-- first row -->
			<div class="col-md-4" style="">					
				<table>
					<tr>
						<td><br/>
							<div style="width:400px;border-radius:-15px;color:#088A29;float:left;margin-left:-20px;"><center><b>DEVICE REPORTING (Hover On Map To View Statistics)<br /><?php  echo $date_filter_desc;?></b></center></div>
							<br />
							<div id="legend" style="background-color:#e9e9e9;height:40px;padding:10px;margin-left:-13px;max-width:400px;">
								<div style="width:50px;border-radius:-15px;background-color:#F7F7F7;color:#000;float:left;margin-left:50px;"><center>NO PIMA</center></div>
								<div style="width:50px;border-radius:-15px;background-color:#FFCC99;color:#000;float:left;"><center>< 25%</center></div>
								<div style="width:50px;border-radius:-15px;background-color:#FFCCCC;color:#000;float:left;"><center>25-50%</center></div>
								<div style="width:50px;border-radius:-15px;background-color:#FFFFCC;color:#000;float:left;"><center>50-75%</center></div>
								<div style="width:50px;border-radius:-15px;background-color:#CBCB96;color:#000;float:left;"><center>75-99%</center></div>
								<div style="width:50px;border-radius:-15px;background-color:#B3D7FF;color:#000;float:left;"><center>100%</center></div>
								<br style="clear: left;" />
							</div>
							<div id='mapDiv' style="margin-left:-13px;"></div>
								<script typse="text/javascript">
									 var map = new FusionMaps("<?php echo base_url();?>assets/plugins/Fusion/FusionMaps/FCMap_KenyaCounty.swf", "Kenya","400","410","0","0");
									 	
										 $.ajax({
										          type:"POST",        
										           url:"<?php echo base_url('home/home/get_json_map_data');?>",
										           success:function(data) {
									            		mapdata = jQuery.parseJSON(data);									
										 				map.setJSONData(mapdata);
														map.render("mapDiv");
														
										 		}
										 	});
								</script>
								
						</td>
					</tr>
				</table>
			</div>
			<div class="row" style="">
				<div class="col-md-5" style="padding:0px;">
					<script type="text/javascript">
								    $(function () {
							            $('#cd4_tests_year').highcharts({
							                title: {
							                    text: ' CD4 Tests for Year <?php echo $date_filter_year;?>',
							                    x: -20 //center
							                },
							                xAxis: {
							                        categories: <?php echo json_encode($categories); ?>

							                    },
							                yAxis: {
							                     title: { text: 'No Tests Vs Errors' }
							                   
							                },
							                
							                // tooltip: {
							                //      valueSuffix: ''
							                // },
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
							                series:  <?php echo json_encode($cd4_tests_graph); ?> 
							            });
							        });							    
							    </script>
							    <div id="cd4_tests_year" style="min-width: 490px; height: 250px; margin: 0 auto;border:3px solid #ABC;"></div>
				</div>
				<div class="col-md-2">
					<script type="text/javascript">
								    $(function () {
									    $('#pie_tests_errors').highcharts({
									        chart: {
									            plotBackgroundColor: null,
									            plotBorderWidth: 0,//null,
									            plotShadow: false
									        },
									        title: {
									            text: 'Device Tests Vs Errors'
									        },
									        subtitle: {
							                    text: '<?php echo $date_filter_desc;?>',
							                    x: -10
							                },
									        tooltip: {
									            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
									        },
									         credits: {
							                    enabled: false
							                },
									        plotOptions: {
									            pie: {
									                allowPointSelect: true,
									                cursor: 'pointer',
									                dataLabels: {
									                    enabled: true,
									                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
									                    style: {
									                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
									                    }
									                }
									            }
									        },
									        series:	<?php echo json_encode($tests_errors_pie_chart); ?>

									    });
									});				    
							    </script>  
							    <div id="pie_tests_errors" style="min-width: 300px; height: 250px; margin: 0 auto;border:3px solid #ABC;"></div>
				</div>
				<div class="col-md-5" style="padding:0px;">
					<div class="section-title" ><center>Statistics for : <?php  echo $date_filter_desc;?></center></div>
						<table class="data-table" style=" margin-left:0px;">
		                    <tbody>
		                    	<?php 
		                    		foreach ($pima_statistics as $pima_s ) { 
		                    	?>
				                <tr>						                	
				                    <td><center><?php echo $pima_s['caption'];?></center></td>
				                    <td style="font-family:Georgia, 'Times New Roman', Times, serif ;background-color: #F2F2F2"><center><?php echo $pima_s['data'];?></center></td>					                   					                   
				                </tr>
				                <?php 
		                    		} 
		                    	?> 
		           	 		</tbody>
		        		</table>
				</div>
				<div class="col-md-2">
					<script type="text/javascript">
						$.ajax({
							          type:"POST",        
							          url:"<?php echo base_url('home/home/national_progress_bar_reported');?>",
							          success:function(data) {
					            			$('#reported').append(data);

									}
								});

					</script>
					<div class="section-title" style="min-width:300px;"><center>% Devices Reported: <?php  echo $date_filter_desc;?></center></div>
					<div class="progress" id="reported" style='height:50px; min-width:300px;'>
					</div>
					<script type="text/javascript">
							$.ajax({
								          type:"POST",        
								          url:"<?php echo base_url('home/home_2/national_progress_bar_not_reported');?>",
								          success:function(data) {
						            			$('#notreported').append(data);
										}
									});

					</script>
					<div class="section-title" style="min-width:300px;"><center>% Devices NOT Reported: <?php  echo $date_filter_desc;?></center></div>
					<div style="color:red;min-width:300px;">Click Percentage Value to view counties not reported</div>
					<div class="progress" id="notreported" style='height:50px;min-width:300px;'>
					</div>
				</div>
			</div>
</div><!--  end of row -->
<div class="row">
	<div class="col-md-16">
		<div class="section-title" ><center>Errors encountered For: <?php echo $date_filter_desc;?></center></div>
								<div id="chartTestDataColumn" style="align:center;"></div>
								<script type="text/javascript">
								     $(function () {
								      $('#errorscolumn').highcharts({
								     		chart: {
							                type: 'column',
							                height:260
							            },
							            title: {
							                text: 'PIMA Errors'
							            },
							            subtitle: {
							                text: ''
							            },
							            xAxis: {
							                categories: [
							                    'Errors Reported'
							                ]
							            },            
							            yAxis: {
							                min: 0,
							                title: {
							                    text: 'Error Frequency'
							                }
							            },            
							            credits:{
							                enabled:false
							            },
							            tooltip: {
							                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
							                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							                    '<td style="padding:0"><b>{point.y} </b></td><td style="padding:0">,  </b></td></tr>',
							                footerFormat: '</table>',
							                shared: false,
							                useHTML: true
							            },
							            plotOptions: {
							                column: {
							                    pointPadding: 0.1,
							                    borderWidth: 0
							                }
							            },
							            series: <?php echo json_encode($error_data);?>
								     });
								    });							    
							    </script>
							    <div style="width: 100%;float:left; border:solid;border-color:aliceblue;">
			    		<div id="errorscolumn">
			    		</div>
			    	</div>
	</div>
</div>
<script type="text/javascript">
	$.ajax({
		          type:"POST",        
		          url:"<?php echo base_url('home/home/national_breakdown_not_reported');?>",
		          success:function(data) {
            			$('#response').append(data);
				}
			});

</script>
<!-- non reported modal -->
	<div class="modal fade" id="nrep" >
	  	<div class="modal-dialog" style="width:47%;margin-bottom:2px;">
	    	<div class="modal-content" >
	      		<div class="modal-header">
	        	<h4>Counties Not Reported<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h4>
	      		</div>
	      			<div id="response"></div>   				      		
	      		<div class="modal-footer" style="height:11px;padding-top:11px;">
	      			<?php echo $this->config->item("copyrights");?>
	      		</div> 
	   		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<!-- END non reported modal -->
