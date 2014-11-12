<div style='float:left;min-width:400px;'>
	<table id='counties' >
		<thead>
			<tr>
				<td>#</td>
				<td>County</td>
				<td><center>Total Tests</center></td>
				<td><center>Valid Tests</center></td>
				<td><center>Errors</center></td>
				<td><center>Tests < 500 cp/ml</center></td>
				<td><center>Tests > 500 cp/ml</center></td>
			</tr>
		</thead>
		<tbody>
			<?php $num=1;foreach($counties_results as $county_breakdown): ?>
				<tr>
					<td><?php echo $num; ?></td>
					<td><?php echo $county_breakdown['region']; ?></td>
					<td><center><?php echo $county_breakdown['total_tests']; ?></center></td>
					<td><center><?php echo $county_breakdown['valid']; ?></center></td>
					<td><center><?php echo $county_breakdown['errors']; ?></center></td>
					<td><center><?php echo $county_breakdown['failed']; ?></center></td>
					<td><center><?php echo $county_breakdown['passed']; ?></center></td>
				</tr>
			<?php $num++; endforeach; ?>
		</tbody>
	</table>
</div>
<div style='margin-left:640px;min-width:250px;min-height:300px;'>
	<div style="min-width:400px;border-radius:-15px;color:#088A29;float:left;"><center><b>% REPORTING (Hover On Map To View Statistics)<br /><?php  echo $date_filter_desc;?></b></center></div>
	<br />
	<div id="legend" style="background-color:#e9e9e9;height:40px;padding:14px;margin-left:-13px;width:550px;">
		<div style="width:50px;border-radius:-15px;background-color:#F7F7F7;color:#000;float:left;margin-left:-350px;"><center>NO PIMA</center></div>
		<div style="width:50px;border-radius:-15px;background-color:#FFCC99;color:#000;float:left;margin-left:-300px;"><center>< 25%</center></div>
		<div style="width:50px;border-radius:-15px;background-color:#FFCCCC;color:#000;float:left;margin-left:-250px;"><center>25-50%</center></div>
		<div style="width:50px;border-radius:-15px;background-color:#FFFFCC;color:#000;float:left;margin-left:-200px;"><center>50-75%</center></div>
		<div style="width:50px;border-radius:-15px;background-color:#CBCB96;color:#000;float:left;margin-left:-150px;"><center>75-99%</center></div>
		<div style="width:50px;border-radius:-15px;background-color:#B3D7FF;color:#000;float:left;margin-left:-100px;"><center>100%</center></div>
		<br style="clear: left;" />
	</div>
	<div id='mapDiv' style="margin-left:-13px; width:400px;"></div>
		<script typse="text/javascript">
			  var map = new FusionMaps("<?php echo base_url(); ?>assets/plugins/Fusion/FusionMaps/FCMap_KenyaCounty.swf", "Kenya","550","410","0","70");
									 	
										 $.ajax({
										          type:"POST",        
										           url:"<?php echo base_url();?>home/home_2/get_json_map_data",
										           success:function(data) {
									            		mapdata = jQuery.parseJSON(data);									
										 				map.setJSONData(mapdata);
														map.render("mapDiv");
														
										 		}
										 	});
		</script>
</div>
<br style="clear: left;" />
