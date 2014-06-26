<html>
<head>
	<title>CD4 LIMS | Reports</title>
	<link rel="SHORTCUT ICON" href="<?php echo base_url(); ?>img/naslogo.jpg">
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/Plugins/Fusion/FusionCharts/FusionCharts.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/Plugins/Fusion/FusionCharts/FusionChartsExportComponent.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/plugins/Bootstrap/js/bootstrap.min.js' type='text/javascript'></script>'></script>
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/plugins/Bootstrap/css/bootstrap.min.css' type='text/css'></link>
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/plugins/Bootstrap/css/bootstrap-theme.min.css' type='text/css'></link>
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/site.css' type='text/css'></link>

</head>
<body>
<div id="data">
	<img src="<?php echo $img ?>" style="margin-left:450px;"/>
	<br />
	<br />
	<div class="section-title" style="width:600px;margin-left:260px;" ><center>Generated Report</center></div>
	<div class="section-title" style="width:400px;margin-left:900px;position:absolute; margin-top:51px;" ><center>Important Note</center></div>
	<div class="info" style="width:400px;margin-left:900px;position:absolute; margin-top:91px;" >To Download the graph, click on <img src="<?php echo base_url();?>img/download_graph.png" /> on the top right corner of the graph
		<br />Click on any of the chart legend options, just below the chart, to view individual points
	</div>
	<div="tabledat">
		<form method="POST" action="<?php echo base_url();?>poc/reports/print_pdf">

			<input type="hidden" name="facility" value="<?php echo $facility;?>"/>
			<input type="hidden" name="device" value="<?php echo $device;?>"/>
			<input type="hidden" name="all" value="<?php echo $all;?>"/>
			<input type="hidden" name="county_name" value="<?php echo $county_name;?>"/>
			<input type="hidden" name="login_id" value="<?php echo $login_id;?>" />

			<input type="hidden" name="report_type" value="<?php echo $report_type;?>"/>
			<input type="hidden" name="tests_done" value="<?php echo $tests_done;?>"/>
			<input type="hidden" name="errors" value="<?php echo $errors;?>"/>
			<input type="hidden" name="less_than350" value="<?php echo $less_than350;?>" />
			<input type="hidden" name="greater_equal_to350" value="<?php echo $greater_equal_to350;?>" />
			<input type="hidden" name="count" value="<?php echo $count;?>"/>

			<input type="hidden" name="month" value="<?php echo $the_month;?>"/>
			<input type="hidden" name="quarter" value="<?php echo $quarter;?>"/>
			<input type="hidden" name="bian" value="<?php echo $bian;?>"/>
			<input type="hidden" name="year" value="<?php echo $Year;?>"/>
			<input type="hidden" name="year_cri" value="<?php echo $Year_cri;?>"/>
			<input type="hidden" name="from" value="<?php echo $from;?>"/>
			<input type="hidden" name="end" value="<?php echo $to;?>"/>
			<div id="pdf_button" style="margin-left:470px;">
				<input type="submit" value ="Click to Download CD4 Report" class="btn btn-primary btn-mini" style="margin-left:-100px;"/>
				<a style="text-decoration:none;" href="<?php echo base_url(); ?>poc/reports/" class="btn btn-primary btn-mini">Back to reports page</a>
			</div>
		</form>
	</div>
	<br/>
	<?php if($report_type!=4){ ?>
		<div id="line_graph" style="margin-left:260px;"></div>
			<script type="text/javascript">
				FusionCharts.setCurrentRenderer("javascript");
			    var myChart = new FusionCharts( "FusionCharts/Charts/MSLine.swf", "chart1","600", "400", "0", "0");
			    myChart.setDataURL("<?php echo base_url();?>poc/reports_charts/chart_functions/<?php echo $tests_done;?>/<?php echo $errors; ?>/<?php echo $count ?>/<?php echo $less_than350;?>/<?php echo $report_type;?>/<?php if($facility==''){$Facility='0';echo $Facility;}else{echo $facility;}?>/<?php if($device==''){$Device='0'; echo $Device;}else{echo $device;}?>/<?php if($all==''){$All='0';echo $All;}else{echo $all;}?>/<?php if($the_month==''){$The_month='0';echo $The_month;}else{echo $the_month;}?>/<?php if($q_no==''){echo $Q_no='0';}else{echo $q_no;};?>/<?php if($b_no==''){echo $B_no='0';}else{echo $b_no;};?>/<?php if($Year_cri==''){echo $Yearly='0'; }else{echo $Year_cri;}?>/<?php if($Year==''){echo $the_year='0';}else{echo $Year;}?>/<?php if($from==''){echo $From='0';}else{echo $from;}?>/<?php if($to==''){echo $To='0';}else{echo $to;}?>/<?php if($county_name==''){echo $County_name='0';}else{echo $county_name;}?>/<?php echo $login_id;?>");
				myChart.render("line_graph");
			</script>
		<div id="line_graph_exp" align="center"></div>
			<script type="text/javascript">
				var myExportComponent = new FusionChartsExportObject("fcExporter1", "<?php echo base_url();?>assets/Plugins/Fusion/FusionCharts/Charts/FCExporter.swf");
			    //Render the exporter SWF in our DIV line_graph_exp
				myExportComponent.Render("line_graph_exp");
		   </script>
	<?php } else{ ?>
		<div id="doughnut_graph" style="margin-left:260px;border:1px solid black; width:600px;" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
		   <script type="text/javascript">
		   	  FusionCharts.setCurrentRenderer('javascript');
		      var myChart2900 = new FusionCharts("FusionCharts/Charts/Doughnut2D.swf", "ChartId", "590", "350", "0", "0");
		   	  myChart2900.setDataURL(" <?php echo base_url(); ?>poc/reports_charts/percentage_error_chart/<?php echo $tests_done;?>/<?php echo $errors; ?>/<?php echo $count ?>/<?php if($facility==''){$Facility='0';echo $Facility;}else{echo $facility;}?>/<?php if($device==''){$Device='0'; echo $Device;}else{echo $device;}?>/<?php if($all==''){$All='0';echo $All;}else{echo $all;}?>/<?php if($the_month==''){$The_month='0';echo $The_month;}else{echo $the_month;}?>/<?php if($q_no==''){echo $Q_no='0';}else{echo $q_no;};?>/<?php if($b_no==''){echo $B_no='0';}else{echo $b_no;};?>/<?php if($Year_cri==''){echo $Yearly='0'; }else{echo $Year_cri;}?>/<?php if($Year==''){echo $the_year='0';}else{echo $Year;}?>/<?php if($from==''){echo $From='0';}else{echo $from;}?>/<?php if($to==''){echo $To='0';}else{echo $to;}?>/<?php if($county_name==''){echo $County_name='0';}else{echo $county_name;}?>/<?php echo $login_id;?>");      
		      myChart2900.render("doughnut_graph");
		   </script>
		<div id="doughnut_exp" align="center"></div>
			<script type="text/javascript">
				var myExportComponent = new FusionChartsExportObject("fcExporter1", "<?php echo base_url();?>assets/Plugins/Fusion/FusionCharts/Charts/FCExporter.swf");
			    //Render the exporter SWF in our DIV doughnut_exp
				myExportComponent.Render("doughnut_exp");
		   </script>
	<?php $percentage_errors=0;
			if($count==0)
			{
				$count=1;
				$percentage_errors=($errors/$count)*100;
			}
			else
			{
				$percentage_errors=($errors/$count)*100; 
			}
			if($percentage_errors>5)
			{
			?>
				<!-- <div id="error_div" style="margin-left:260px;"><b style="color:red">The errors have exceeded 5%</b></div> -->

			<?php
			}
			else if($percentage_errors<5 && $percentage_errors>0)
			{
			?>
				<!-- <div id="error_div" style="margin-left:260px;">The errors are within the normal limit</div> -->
			<?php	
			}
			else
			{
			?>
				<div id="error_div" style="margin-left:260px;"><b>There are no errors.</b></div>
			<?php
			}

			 } ?>
</div>

<br />
<br />


		<div id="footer">
				<div id="network">	
										
					<div class="left" style="padding-left:43%;">	
						<ul class="tabbed" id="network-tabs" >
							<li class="current-tab" >
								<!--<a onclick = "user_filter(0)" href="http://localhost/cd4Poc/">National Data</a></li>-->						
														<li class="" >
								<!--<a href="" onclick = "user_filter(1)">ICAP								</a>-->
							</li>
													</ul>
						<script>
							function user_filter(value){
						      $.ajax({
						          type:"POST",
						          async:false,
						          data:"&value="+value,
						            url:"http://localhost/cd4Poc/Home/user_filter_post",  
						            success:function(data) {
						                  $("#exists").val(data);           
						              }
						      });
						    }
						</script>
					</div>	
										<div class="right" id="welcome">
						<ul class="tabbed" id="network-tabs">
							<li class="current-tab" >&copy 2014 NASCOP </li>
						</ul>						
					</div>					
				</div>
				<div class="clearer">&nbsp;</div>
			</div>
		</div>
	</div>
</body>
</html>
