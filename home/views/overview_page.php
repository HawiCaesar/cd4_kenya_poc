<div class="row">
	<div class="tabbable span12">
		<!-- <ul class="nav nav-tabs">
			
			<li id ="tabPima" class="active"><a id = "linkPima" href="#tabs1-pima" data-toggle="tab">PIMA</a></li>
			<li id ="tabSummary" ><a id = "linkSummary"  href="#tabs1-summary" data-toggle="tab">Summary</a></li>
		</ul> -->
		<!-- <div class="tab-content"> -->

			
			<!-- PIMA -->
			<div class="tab-pane  active" id="tabs1-pima">					
				<table>
					<tr>
						<td>
							<div id='mapDiv' style=""></div>
									<script type="text/javascript">										
										var map = new FusionMaps("<?php echo base_url();?>assets/plugins/Fusion/FusionMaps/FCMap_KenyaCounty.swf", "Kenya","400","550","0","0");
										//map.setDataURL("xml/commoditymap.php");
										map.render("mapDiv");
									</script>
						</td>
						<td style="height:130px;width:30%;vertical-align: top;">
							<center>
								<div class="section-title" ><center>% CD4 Tests for Year <?php echo $date_filter_year;?></center></div>
								<div id="yearlyTestReportingRates" style="align:center;"></div>
								<script type="text/javascript">
								    FusionCharts.setCurrentRenderer('javascript');
								    var myChart = new FusionCharts( "FusionCharts/MSLine.swf", "chartyearlyTestReportingRates","400", "220", "0", "0");
								    myChart.setJSONUrl(" <?php echo base_url()?>poc/charts/yearly_test_reporting_rates");
								    myChart.render("yearlyTestReportingRates");							    
							    </script>
						    </center>  
						   <!--  <center> -->
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
							<!-- </center>  -->
						</td>
						<td style="height:130px;width:30%;vertical-align: top;">
							<center>
								<div class="section-title" ><center>Pima Reporting trends for year <?php  echo $date_filter_year;?></center></div>
								<div id="yearlyFacilityPimaReportingRates" style="align:center;"></div>
								<script type="text/javascript">
								    FusionCharts.setCurrentRenderer('javascript');
								    var myChart = new FusionCharts( "FusionCharts/MSLine.swf", "chartyearlyFacilityPimaReportingRates","400", "220", "0", "0");
								    myChart.setJSONUrl(" <?php echo base_url()?>poc/charts/yearly_facility_pima_reporting_rates");
								    myChart.render("yearlyFacilityPimaReportingRates");							    
							    </script>
						    </center>  
						</td>
						
					</tr>
					<tr>
						<td style="height:130px;width:30%;vertical-align: top;" colspan="2">
							<center>
								<div class="section-title" ><center>Errors encountered For: <?php echo $date_filter_desc;?></center></div>
								<div id="chartTestDataColumn" style="align:center;"></div>
								<script type="text/javascript">
								    FusionCharts.setCurrentRenderer('javascript');
								    var myChart = new FusionCharts( "FusionCharts/Column2D.swf", "chartchartTestDataColumn","820", "220", "0", "0");
								    myChart.setJSONUrl(" <?php echo base_url()?>poc/charts/periodic_facility_pima_errors");
								    myChart.render("chartTestDataColumn");							    
							    </script>
						    </center>       
						</td>
						<td style="height:130px;width:30%;vertical-align: top;">
							<center>
								<div class="section-title" ><center>Device Errors For: <?php  echo $date_filter_desc;?></center></div>
								<div id="periodicTestErrorPerc" style="align:center;"></div>
								<script type="text/javascript">
								    FusionCharts.setCurrentRenderer('javascript');
								    var myChart = new FusionCharts( "FusionCharts/Pie2D.swf", "chartperiodicTestErrorPerc","400", "220", "0", "0");
								    myChart.setJSONUrl(" <?php echo base_url()?>poc/charts/periodic_test_error_perc");
								    myChart.render("periodicTestErrorPerc");							    
							    </script>
						    </center>       
						</td>
					</tr>
				</table>
			</div>				
		<!-- </div> --><!-- /.tab-content -->
	</div><!-- /.tabbable -->
</div><!-- /.row -->
