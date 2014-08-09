<?php 
if (isset($message)){
	echo "<div id='msg' style='margin-top: 7px;''>";
	echo $message;
	echo "</div>";
}
?>
<center>
	<div class="section-title" ><center>Last PIMA uploads</center></div>
	
		<table id="data-table" class="data-table">
			<thead>	
				<tr>			
					<th>#</th>
					<th style="width:15%">Date Uploaded</th>
					<th style="width:15%">Device Serial number</th>
					<th>Facility</th>
					<th>Uploaded by</th>
					<th style="font-size: 1.1em;color: #2d6ca2;" ># of total tests</th>
					<th style="font-size: 1.1em;color: #2aabd2;" ># of valid tests</th>
					<th style="font-size: 1.1em;color: #3e8f3e; width:15%;"># of tests &gt= 350 cells/mm3 </th>
					<th style="font-size: 1.1em;color: #eb9316; width:15%;"># of tests &lt 350 cells/mm3</th>
					<th style="font-size: 1.1em;color: #c12e2a;" ># of errors</th>
					<th style="font-size: 1.1em;color: #c12e2a;" >% of errors</th>
				</tr>
			</thead>
			<tbody>				
			<?php 

				$max_rows = 100;
				if (sizeof($uploads)<100){
					$max_rows= sizeof($uploads);
				}
				for($i=0;$i<$max_rows;$i++){
			?>	
			<tr>
				<td><?php echo $i+1;?></td>
				<td><?php echo date('d-F-Y',strtotime($uploads[$i]["upload_date"]));?></td>
				<td><?php echo $uploads[$i]["equipment_serial_number"];?></td>
				<td><?php echo $uploads[$i]["facility_name"];?></td>
				<td><?php echo $uploads[$i]["uploader_name"];?></td>
				<td style="font-size: 1.1em;color: #2d6ca2;"><center><?php echo $uploads[$i]["total_tests"];?></center></td>
				<td style="font-size: 1.1em;color: #2aabd2;"><center><?php echo $uploads[$i]["valid_tests"];?></center></td>
				<td style="font-size: 1.1em;color: #3e8f3e;"><center><?php echo $uploads[$i]["passed"];?></center></td>
				<td style="font-size: 1.1em;color: #eb9316;"><center><?php echo $uploads[$i]["failed"];?></center></td>
				<td style="font-size: 1.1em;color: #c12e2a;"><center><?php echo $uploads[$i]["errors"];?></center></td>
				<td style="font-size: 1.1em;color: #c12e2a;"><?php
				  $data=(round((($uploads[$i]["errors"]/$uploads[$i]["total_tests"])*100),1)); 
	              if($uploads[$i]["total_tests"]>0){
	              	
	                echo $data." %";
	              }
				 
	            ?></td>
	           
			</tr>
			<?php
				}
			?>		
			</tbody>
		</table>
	</div>		
</center>	

<!-- modal -->

<?php $this->load->view("upload_footer_view");?>