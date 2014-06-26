
<style type="text/css">

#Labels
{
	border:1px solid rgb(204,204,204);
	font-family:Verdana;
	background-color: #F2F2F2;
	border-radius: 5px 0px 0px 5px;
	padding:5px 5px 2px 5px;
	width: 100px;
	margin-left: 5px;
	position: absolute;
}
#ComboBoxesData
{
	margin-left:109px;
}

</style>
<div>
	<div class="section-title" ><center>Generate Reports</center></div>
	<div>
		<!-- <div class="tabbable span12"> -->
			<!-- <ul class="nav nav-tabs">
				<li id ="tabPreset" class="active"><a href="#tabs1-preset" data-toggle="tab">Preset</a></li>
				<li id ="tabCustom"><a href="#tabs1-custom" data-toggle="tab">Reports</a></li>
			</ul> -->
			<!-- <div class="tab-content"> -->
				<!-- preset -->
				<!-- <div class="tab-pane active" id="tabs1-preset">
					<table>
						<tr>
							<td style="height:330px;width:50%;vertical-align: top;" rowspan="1">
								<center>										
									<div id='mapDiv' style=""></div>
									<script type="text/javascript">										
										var map = new FusionMaps("<?php echo base_url();?>assets/plugins/Fusion/FusionMaps/FCMap_KenyaCounty.swf", "Tanzania","400","350","0","0");
										//map.setDataURL("xml/commoditymap.php");
										map.render("mapDiv");
									</script>
								</center>
							</td>
							<td>									
								<div style="vertical-align:center">
									<div class="section-title">All <a><div class="right"><i class="glyphicon glyphicon-stats"></i></div></a></div>
									<div class="section-title">Tests <a><div class="right"><i class="glyphicon glyphicon-stats"></i></div></a></div>
									<div class="section-title">Errors <a><div class="right"><i class="glyphicon glyphicon-stats"></i></div></a></div>
									<div class="section-title">Equipment <a><div class="right"><i class="glyphicon glyphicon-stats"></i></div></a></div>
								</div>									
							</td>
						</tr>
						<tr>
							<td colspan="2"></td>
						</tr>
					</table>						
				</div> -->
				<!-- custom -->
				<div class="tab-pane" id="tabs1-custom">
					<form method="post" action="<?php echo base_url();?>poc/reports/get_report" id="form-report">
						<table>
							<tr>
								<td style="width:50%">
									<div class="mycontainer" id="full">
										<div class="input-group" style="width: 100%;padding:4px;">
											<span class="input-group-addon" style="width: 40%;border-radius:5px 5px 5px 5px;">Fields marked with <b style="color:red;">*</b> are required to download a report<br /></span>
										</div>
										<div class="input-group" style="width: 100%;padding:4px;">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Criteria :</span>
											<select  class="textfield form-control" id="criteria" name="the_criteria">
							                   	<option value="-1">*Select criteria to use*</option>
							                   	<?php echo $partner_option; ?>
							                   	<option value="1">Show By Device</option>
							                   	<option value="2">Show By Facility</option>
							                   	<?php if($combo_box_county_option!="")
									                   	{
									                   		echo $combo_box_county_option;
									                   	}
									                   	else
									                   	{

									                   	}
							                   	?>                  					
							                </select>
						                </div>
						                <div class="input-group" style="width: 100%;padding:4px;">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Report Type :</span>
											<select  onchange="error_p()" class="textfield form-control" name="report_type" id="test_errors" >
							                   	<option value="0">*Show Both Tests and Errors*</option> 
							                   	<option value="1"> Tests Report Only</option>
							                   	<option value="3"> Tests < 350 Report </option>
							                   	<option value="2"> Errors Report Only</option>
							                   	<option value="4"> Errors Report by % </option>								                   	                  												                   	                  					
							                </select>
						                </div>
						                <div class="input-group" style="width: 100%;padding:4px;" id="dev">
						                	<span class="input-group-addon" style="width:40%"><b style="color:red;">*</b> Device:</span>
					              		
					              			<select name='device' id='devices' style='border-radius:0px 5px 5px 0px;'; class="textfield form-control">
							              		<option value='' selected='selected'>*Select Device*</option>
							              		<?php foreach($DeviceNumberOptions as $DeviceNumber){ ?>
							              		<option value='<?php echo $DeviceNumber['serial']; ?>'><?php echo $DeviceNumber['facility']; ?>----<?php echo $DeviceNumber['serial']; ?></option>
							              		<optgroup></optgroup label="">
							              		<?php } ?>
								              	</select>
							              	<span id='locationInfo'></span>
					              		</div>

					              		<div class="input-group" style="width: 100%;padding:4px;" id="facility">
						                	<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Facility:</span>
					              		
					              			<select name='facility' id='facilities' style="border-radius:0px 5px 5px 0px;"  class="textfield form-control">
							              		<option value='' selected='selected'>*Select Facility*</option>
							              		<?php foreach($FacilitiesList as $fname){ ?>
							              		<option value='<?php echo $fname['facility']; ?>'><?php echo $fname['facility']; ?></option>
							              		<?php } ?>
								              	</select>
							              	<span id='locationInfo'></span>
					              		</div>  					
										<div class="input-group" style="width: 100%;padding:4px;" >
											<span class="input-group-addon" style="width: 40%;" ><b style="color:red;">*</b> Duration :</span>
											<select  class="textfield form-control" id="duration" name="Duration" >
							                   	<option value="-1">*Select Duration*</option>
							                   	 <option value="1">Monthly</option>
							                     <option value="2">Quartely</option>
								                 <option value="3">Bi-Annually</option>
								                 <option value="4">Yearly</option>
								                 <option value="5">Customize Dates</option>                   					
							                </select>
							            </div>	
						                <div class="input-group" style="width: 100%;padding:4px;" id="monthlyM">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Monthly :</span>
											<select class="textfield form-control" style='border-radius:0px 5px 5px 0px;' name="FieldM">
							                   	<option value="">*Select Month*</option>
							                   	<option value="1">January</option>
					                            <option value="2">February</option>
					                          	<option value="3">March</option>
					                          	<option value="4">April</option>
					                          	<option value="5">May</option>
					                          	<option value="6">June</option>
					                          	<option value="7">July</option>
					                          	<option value="8">August</option>
					                          	<option value="9">September</option>
					                          	<option value="10">October</option>
					                          	<option value="11">November</option>
					                          	<option value="12">December</option>                 					
							                </select>
							                <select  class="textfield form-control" style='border-radius:0px 5px 5px 0px;' name="YearM" onchange="">
							                   	<option value="">*Select Year*</option>
							                   	<?php foreach($yearlyReports as $Year){?>
					                            <option value="<?php echo $Year['year']; ?>"><?php echo $Year['year']; ?></option>
					                            <?php } ?>                 					
							                </select>
						                </div>
						                <div class="input-group" style="width: 100%;padding:4px;" id="quarterlyD">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Quarterly :</span>
											<select  class="textfield form-control" style='border-radius:0px 5px 5px 0px;' name="quarterly" >
							                   	<option value="">*Select a Quarter*</option>
							                   	<option value="1">January - April</option>
                              					<option value="2">May - August</option>
                              					<option value="3">September - December</option>                 					
							                </select>
							                <select  class="textfield form-control" name="YearQ" >
							                   	<option value="">*Select Year*</option>
							                   	<?php foreach($yearlyReports as $Year){?>
                              					<option value="<?php echo $Year['year']; ?>"><?php echo $Year['year']; ?></option>
                              					<?php } ?>                 					
							                </select>
						                </div>	
						                <div class="input-group" style="width: 100%;padding:4px;" id="biannual">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Bi-Annually :</span>
											<select  class="textfield form-control" style='border-radius:0px 5px 5px 0px;' name="bian">
							                   	<option value="">*Select a bi-annual*</option>
							                   	<option value="1">January - June</option>
                              					<option value="2">July - December</option>                  					
							                </select>
							                <select  class="textfield form-control" name="YearB" >
							                   	<option value="">*Select Year*</option>
							                   	<?php foreach($yearlyReports as $Year){?>
					                            <option value="<?php echo $Year['year']; ?>"><?php echo $Year['year']; ?></option>
					                            <?php } ?>                 					
							                </select>
						                </div>
						                <div class="input-group" style="width: 100%;padding:4px;" id="year">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Yearly :</span>
											<select  class="textfield form-control" name="YearO">
							                   	<option value="">*Select a Year*</option>
							                   	<?php foreach($yearlyReports as $Year){?>
					                            <option value="<?php echo $Year['year']; ?>"><?php echo $Year['year']; ?></option>
					                            <?php } ?>                 					
							                </select>
						                </div>
						                <div class="input-group" style="width: 100%;padding:4px;" id="CustDates">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Custom Dates :</span>
											<div class="input-group" style="width: 100%;">
												<span class="input-group-addon" style="width: 40%;">From :</span>
												<input type="text" id="datepickerFrom" placeholder="From" name="FromDate" style="width:150px;">
											</div> 
											<div class="input-group" style="width: 100%;">
												<span class="input-group-addon" style="width: 40%;">to :</span>
												<input type="text" id="datepickerTo" placeholder="To" name="ToDate" style="width:150px;">
											</div>
						                </div>
						            </div>
						        </td>
						        <td>
									<div class="mycontainer" id="full">
						                 
						                <div class="input-group" style="width: 100%;padding:4px;">
											<span class="input-group-addon" style="width: 40%;">Format :</span>
											<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>pdf.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="button_text()" name="format" checked value="pdf">PDF</span>
											<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>excel.png" width="30" height="30">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="button_text()" name="format" value="excel">Excel</span>
											<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>graph.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="button_text()" name="format" value="graph">Graph</span>
						                </div>									
										<div class="right" style="padding:7px 32px 7px 7px;">
											<button id="click" type="submit" class="btn btn-primary btn-mini" ><i class="glyphicon glyphicon-save"></i>Download Report</button>
											<!-- <button name="viewData" type="submit" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-upload"></i> Email Report</button> -->
											<button name="reset" type="reset" onclick="hide_divs()"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i> Reset</button>
											<!-- <a type="reset" onclick="bootstrap()"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i> Reset</a> -->
										</div>						
									</div>
								</td>
							</tr>
						</table>
					</form>


					<div class="modal fade" id="report_error" >
					  	<div class="modal-dialog" style="width:37%;margin-bottom:2px;">
					    	<div class="modal-content" >

					    		<div class="modal-header">
					        		<h4 class="modal-title">Report Details</h4>
					      		</div>

				      			<div class="modal-body" style="padding-bottom:0px;">
				      				The data for the month or year you have selected does not exist
				      				or has not yet been collected
				      			</div>
				      			<div class="modal-footer" style="height:30px;padding-top:4px;">
				      				<?php echo $this->config->item("copyrights");?>
				      			</div>

					    	</div>
					    </div>
					</div>





				</div>
			<!-- </div> -->
		<!-- </div> -->
	</div>
</div>