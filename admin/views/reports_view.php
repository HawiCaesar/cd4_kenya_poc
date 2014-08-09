<script language="javascript">
$(function(){ //this function calls the devices that have reported. It is called by clicking on the equipment reporting tab
         $("#tabEquipRepo").click(function()
         {
         	$.ajax({
				      url: '<?php echo base_url();?>admin/reports/ajax_equipment_call',
				      success: function(data){
				       $('#devices').html(data);
				      }

			  		});
         });

});
$(function(){ //this function calls the counties that have reported. It is called by clicking on the county reporting tab
		 $("#tabCountyRepo").click(function()
         {
         	$.ajax({
				      url: '<?php echo base_url();?>admin/reports/ajax_county_call',
				      success: function(data){
				       $('#Counties').html(data);
				      }

			  		});
         });
});

$(document).ready(function(){ //this function calls the facilities that have reported. This runs automatically when the page loads
	$.ajax({
      url: '<?php echo base_url();?>admin/reports/ajax_facility_call',
      success: function(data) {
       $('#facilities').html(data);
      }

  	});

});



</script>
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

<div class="tabbable span12" style="margin-top:5px;">
	<ul class="nav nav-tabs">
		<li id ="tabFacRepo" class="active"><a href="#tabs1-facRepo" data-toggle="tab">Facility Reporting</a></li>
		<li id ="tabEquipRepo"><a href="#tabs1-equipRepo" data-toggle="tab">Equipment Reporting</a></li>
		<li id ="tabCountyRepo"><a href="#tabs1-countyRepo" data-toggle="tab">County Reporting</a></li>
		<li id ="tabAllRepo"><a href="#tabs1-allRepo" data-toggle="tab">All Data Reporting</a></li>
		<!-- <li id ="tabLogs" ><a href="#tabs1-logs" data-toggle="tab">User Logs</a></li> -->
	</ul>
	<div class="tab-content">
		<!-- Facility reporting -->
		<div class="tab-pane active" id="tabs1-facRepo">
			<form method="post" action="<?php echo base_url();?>admin/reports/get_reports" id="form-report">
						<table>
							<tr>
								<td style="width:50%">
									<div class="mycontainer" id="full">
										<div class="input-group" style="width: 100%;padding:4px;">
											<span class="input-group-addon" style="width: 40%;border-radius:5px 5px 5px 5px;">Fields marked with <b style="color:red;">*</b> are required to download a report
										</div>
										<div class="input-group" style="width: 100%;padding:4px;" id="facility">
						                	<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Facility:</span>
					              		
					              			<select name='facility' id='facilities' style="border-radius:0px 5px 5px 0px;"  class="textfield form-control">	
					              				
					              			</select>
					              		</div>
										<div class="input-group" style="width: 100%;padding:4px;">
											<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Report Type :</span>
											<select onchange="error_percentage_facility()" class="textfield form-control" name="report_type" id="test_errors_facility" >
							                   	<option value="0">*Show Both Tests and Errors*</option> 
							                   	<option value="1"> Tests Report Only</option>
							                   	<option value="3"> Tests < 500 Report </option>
							                   	<!-- <option value="5"> Tests < 100 Report </option> -->	
							                   	<option value="2"> Errors Report Only</option>
							                   	<!-- <option value="4"> Errors Report by % </option>-->	
							                   							                   	                  												                   	                  					
							                </select>
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
						                 
						                <div class="input-group" style="width: 100%;padding:4px;" >
											<span class="input-group-addon" style="width: 40%;">Format :</span>
											<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>pdf.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" name="format_facility" onclick="facility_pdf()" checked value="pdf">PDF</span>
											<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>/excel.png" width="30" height="30">&nbsp;&nbsp;&nbsp;<input type="radio" name="format_facility" onclick="facility_excel()" value="excel">Excel</span>
						                	<!-- <span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>graph.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" name="format_facility" onclick="facility_graph()" value="graph">Graph</span> -->
						                	<input type="hidden" name="tab_name" value="facility_tab" />
						                </div>									
										<div class="right" style="padding:7px 32px 7px 7px;">
											<button id="click_facility" type="submit" onclick="" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-save"></i>Download Report</button>
											<!-- <button name="viewData" type="submit" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-upload"></i> Email Report</button> -->
											<button name="reset" type="reset" onclick="hide_divs_facility()"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i> Reset</button>
										</div>						
									</div>
								</td>
							 </tr>
						</table>
			</form>
		</div>

		<!-- ================= Equipment reporting ================================================= -->

		<div class="tab-pane " id="tabs1-equipRepo" >
			<form method="post" action="<?php echo base_url();?>admin/reports/get_reports" id="form-report">
				<table>
					<tr>
						<td style="width:50%">
							<div class="mycontainer" id="full">
								<div class="input-group" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;border-radius:5px 5px 5px 5px;">Fields marked with <b style="color:red;">*</b> are required to download a report
								</div>
							  	<div class="input-group" style="width: 100%;padding:4px;" id="dev">
				                	<span class="input-group-addon" style="width:40%"><b style="color:red;">*</b> Device:</span>
			              			<select name='device' id='devices' style='border-radius:0px 5px 5px 0px;'; class="textfield form-control">
					              				
					              	</select>
					              	<span id='locationInfo'></span>
			              		</div>
								<div class="input-group" style="width: 100%;padding:4px;">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Report Type :</span>
									<select onchange="error_percentage_equipment()" class="textfield form-control" name="report_type" id="test_errors_equipment" >
					                   	<option value="0">*Show Both Tests and Errors*</option> 
					                   	<option value="1"> Tests Report Only</option>
					                   	<option value="3"> Tests < 500 Report </option>
					                   	<!-- <option value="5"> Tests < 100 Report </option> -->	
					                   	<option value="2"> Errors Report Only</option>
					                   	<!-- <option value="4"> Errors Report by % </option> -->							                   	                  												                   	                  					
					                </select>
				                </div>
				                <div class="input-group" style="width: 100%;padding:4px;" >
									<span class="input-group-addon" style="width: 40%;" ><b style="color:red;">*</b> Duration :</span>
									<select  class="textfield form-control" id="duration_equip" name="Duration" >
					                   	<option value="-1">*Select Duration*</option>
					                   	 <option value="1">Monthly</option>
					                     <option value="2">Quartely</option>
						                 <option value="3">Bi-Annually</option>
						                 <option value="4">Yearly</option>
						                 <option value="5">Customize Dates</option>                   					
					                </select>
					            </div>
					            <div class="input-group" style="width: 100%;padding:4px;" id="monthly_equip">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="quarterly_equip">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="biannual_equip">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="year_equip">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Yearly :</span>
									<select  class="textfield form-control" name="YearO">
					                   	<option value="">*Select a Year*</option>
					                   	<?php foreach($yearlyReports as $Year){?>
			                            <option value="<?php echo $Year['year']; ?>"><?php echo $Year['year']; ?></option>
			                            <?php } ?>                 					
					                </select>
				                </div>
				                <div class="input-group" style="width: 100%;padding:4px;" id="CustDates_equip">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Custom Dates :</span>
									<div class="input-group" style="width: 100%;">
										<span class="input-group-addon" style="width: 40%;">From :</span>
										<input type="text" id="datepickerFrom_equip" placeholder="From" name="FromDate" style="width:150px;">
									</div> 
									<div class="input-group" style="width: 100%;">
										<span class="input-group-addon" style="width: 40%;">to :</span>
										<input type="text" id="datepickerTo_equip" placeholder="To" name="ToDate" style="width:150px;">
									</div>
				                </div>
							</div>
						</td>
						<td>
							<div class="mycontainer" id="full">
								<div class="input-group" style="width: 100%;padding:4px;">
									<span class="input-group-addon" style="width: 40%;">Format :</span>
									<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>pdf.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="equipment_pdf()" name="format_equipment" checked value="pdf">PDF</span>
									<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>/excel.png" width="30" height="30">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="equipment_excel()" name="format_equipment" value="excel">Excel</span>
				               		<!-- <span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>graph.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="equipment_graph()" name="format_equipment" value="graph">Graph</span> -->
				                	<input type="hidden" name="tab_name" value="equipment_tab" />
				                </div>									
								<div class="right" style="padding:7px 32px 7px 7px;">
									<button id="click_equipment" type="submit" onclick="" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-save"></i>Download Report</button>
									<!-- <button name="viewData" type="submit" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-upload"></i> Email Report</button> -->
									<button name="reset" type="reset" onclick="hide_divs_equip()"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i> Reset</button>
								</div>		
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- County reporting -->
		<div class="tab-pane " id="tabs1-countyRepo" >
			<form method="post" action="<?php echo base_url();?>admin/reports/get_reports" id="form-report">
				<table>
					<tr>
						<td style="width:50%">
							<div class="mycontainer" id="full">
								<div class="input-group" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;border-radius:5px 5px 5px 5px;">Fields marked with <b style="color:red;">*</b> are required to download a report
								</div>
								<input type="hidden" name="bigger_criteria" value="4"/>
								<div class="input-group" style="width: 100%;padding:4px;" id="county">
				                	<span class="input-group-addon" style="width:40%"><b style="color:red;">*</b> County:</span>
			              			<select name='county_value' id='Counties' style='border-radius:0px 5px 5px 0px;'; class="textfield form-control">
					              		
					              	</select>
					              	<span id='locationInfo'></span>
			              		</div>

			              		<div class="input-group" style="width: 100%;padding:4px;">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Report Type :</span>
									<select onchange="error_percentage_county()" class="textfield form-control" name="report_type" id="test_errors_county" >
					                   	<option value="0">*Show Both Tests and Errors*</option> 
					                   	<option value="1"> Tests Report Only</option>
					                   	<option value="3"> Tests < 500 Report </option>
					                   	<!-- <option value="5"> Tests < 100 Report </option> -->	
					                   	<option value="2"> Errors Report Only</option>
					                   	<!-- <option value="4"> Errors Report by % </option>	-->						                   	                  												                   	                  					
					                </select>
				                </div>
				                <div class="input-group" style="width: 100%;padding:4px;" >
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Duration :</span>
									<select  class="textfield form-control" id="duration_county" name="Duration" >
					                   	<option value="-1">*Select Duration*</option>
					                   	 <option value="1">Monthly</option>
					                     <option value="2">Quartely</option>
						                 <option value="3">Bi-Annually</option>
						                 <option value="4">Yearly</option>
						                 <option value="5">Customize Dates</option>                   					
					                </select>
					            </div>
					            <div class="input-group" style="width: 100%;padding:4px;" id="monthly_county">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="quarterly_county">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="biannual_county">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="year_county">
									<span class="input-group-addon" style="width: 40%;">Yearly :</span>
									<select  class="textfield form-control" name="YearO">
					                   	<option value="">*Select a Year*</option>
					                   	<?php foreach($yearlyReports as $Year){?>
			                            <option value="<?php echo $Year['year']; ?>"><?php echo $Year['year']; ?></option>
			                            <?php } ?>                 					
					                </select>
				                </div>
				                <div class="input-group" style="width: 100%;padding:4px;" id="CustDates_county">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Custom Dates :</span>
									<div class="input-group" style="width: 100%;">
										<span class="input-group-addon" style="width: 40%;">From :</span>
										<input type="text" id="datepickerFrom_county" placeholder="From" name="FromDate" style="width:150px;">
									</div> 
									<div class="input-group" style="width: 100%;">
										<span class="input-group-addon" style="width: 40%;">to :</span>
										<input type="text" id="datepickerTo_county" placeholder="To" name="ToDate" style="width:150px;">
									</div>
				                </div>

							</div>
						</td>
						<td>
							<div class="mycontainer" id="full">
								<div class="input-group" style="width: 100%;padding:4px;">
									<span class="input-group-addon" style="width: 40%;">Format :</span>
									<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>pdf.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="county_pdf()" name="format_county" checked value="pdf">PDF</span>
									<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>/excel.png" width="30" height="30">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="county_excel()" name="format_county" value="excel">Excel</span>
				                	<!-- <span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>graph.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="county_graph()" name="format_county" value="graph">Graph</span> -->
				                	<input type="hidden" name="tab_name" value="county_tab" />
				                </div>									
								<div class="right" style="padding:7px 32px 7px 7px;">
									<button id="click_county" type="submit" onclick="" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-save"></i>Download Report</button>
									<!-- <button name="viewData" type="submit" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-upload"></i> Email Report</button> -->
									<button name="reset" type="reset" onclick="hide_divs_county()"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i> Reset</button>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- All Data reporting -->
		<div class="tab-pane " id="tabs1-allRepo" >
			<form method="post" action="<?php echo base_url();?>admin/reports/get_reports" id="form-report">
				<table>
					<tr>
						<td style="width:50%">
							<div class="mycontainer" id="full">
								<div class="input-group" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;border-radius:5px 5px 5px 5px;">Fields marked with <b style="color:red;">*</b> are required to download a report
								</div>
								<input type="hidden" name="bigger_criteria" value="5"/>
								<div class="input-group" style="width: 100%;padding:4px;">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Report Type :</span>
									<select onchange="error_percentage_all()" class="textfield form-control" name="report_type" id="test_errors_all" >
					                   	<option value="0">*Show Both Tests and Errors*</option> 
					                   	<option value="1"> Tests Report Only</option>
					                   	<option value="3"> Tests < 500 Report </option>
					                   	<!-- <option value="5"> Tests < 100 Report </option> -->	
					                   	<option value="2"> Errors Report Only</option>
					                   	<!-- <option value="4"> Errors Report by % </option> -->							                   	                  												                   	                  					
					                </select>
				                </div>
				                <div class="input-group" style="width: 100%;padding:4px;" >
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Duration :</span>
									<select  class="textfield form-control" id="duration_all" name="Duration" >
					                   	<option value="-1">*Select Duration*</option>
					                   	 <option value="1">Monthly</option>
					                     <option value="2">Quartely</option>
						                 <option value="3">Bi-Annually</option>
						                 <option value="4">Yearly</option>
						                 <option value="5">Customize Dates</option>                   					
					                </select>
					            </div>
					            <div class="input-group" style="width: 100%;padding:4px;" id="monthly_all">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="quarterly_all">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="biannual_all">
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
				                <div class="input-group" style="width: 100%;padding:4px;" id="year_all">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Yearly :</span>
									<select  class="textfield form-control" name="YearO">
					                   	<option value="">*Select a Year*</option>
					                   	<?php foreach($yearlyReports as $Year){?>
			                            <option value="<?php echo $Year['year']; ?>"><?php echo $Year['year']; ?></option>
			                            <?php } ?>                 					
					                </select>
				                </div>
				                <div class="input-group" style="width: 100%;padding:4px;" id="CustDates_all">
									<span class="input-group-addon" style="width: 40%;"><b style="color:red;">*</b> Custom Dates :</span>
									<div class="input-group" style="width: 100%;">
										<span class="input-group-addon" style="width: 40%;">From :</span>
										<input type="text" id="datepickerFrom_all" placeholder="From" name="FromDate" style="width:150px;">
									</div> 
									<div class="input-group" style="width: 100%;">
										<span class="input-group-addon" style="width: 40%;">to :</span>
										<input type="text" id="datepickerTo_all" placeholder="To" name="ToDate" style="width:150px;">
									</div>
				                </div>

							</div>
						</td>
						<td>
							<div class="mycontainer" id="full">
								<div class="input-group" style="width: 100%;padding:4px;">
									<span class="input-group-addon" style="width: 40%;">Format :</span>
									<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>pdf.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="all_pdf()"  name="format_all" checked value="pdf">PDF</span>
									<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>/excel.png" width="30" height="30">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="all_excel()"  name="format_all" value="excel">Excel</span>
				                <!--	<span class="input-group-addon" style="width: 30%;"><img src="<?php echo img_url();?>graph.png" width="25" height="25">&nbsp;&nbsp;&nbsp;<input type="radio" onclick="all_graph()" name="format_all" value="graph">Graph</span> -->
				                	<input type="hidden" name="tab_name" value="all_tab" />
				                </div>									
								<div class="right" style="padding:7px 32px 7px 7px;">
									<button id="click_all" type="submit" onclick="" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-save"></i>Download Report</button>
									<!-- <button name="viewData" type="submit" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-upload"></i> Email Report</button> -->
									<button name="reset" type="reset" onclick="hide_divs_all()"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i> Reset</button>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- logs -->
		<!-- <div class="tab-pane " id="tabs1-logs" >
			This is usage logs
		</div> -->
		
	</div>
</div>