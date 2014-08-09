

<div>
	<div class="section-title"><center><b><strong>CD4 Reporting</strong></b></center></div>
		<table id="data-table" >
			<thead>
				
				<tr>
					<th rowspan = "2">#</th>
					<th rowspan = "2">Facility Name</th>					
					<th colspan = "2"><center>Period</center></th>
					<th colspan = "1"><center>F-CDRR</center></th>
					<th colspan = "1"><center>PIMA </center></th>
				</tr>

				<tr>
					<th><center>From</center></th>
					<th><center>To</center></th>

					<th><center>Reported</center></th>
					
					

					<th><center>Results Uploaded</center></th>
					<
					
				</tr>
			</thead>
			<tbody>
				<!-- Call the facilities -->
				<?php
					$i=1; //counter
					foreach ($facilities as $facility) 
					{
				?>				
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $facility['facility'];?></td>
					
                    <!-- Dates from and to-->
					<td><center>x</center></td>
					<td><center>x</center></td>

					<!-- Icons Excel and PDF to allow for download -->

					<!-- F-CDRR Icons for Reporting, Excel and PDF -->
					<td><center><i class="fa fa-check-square-o fa-2x" style="color: green;"></i></center></td>
					
                    <!-- <i class="fa fa-times-circle fa-2x" style="color: red; "></i>-->
					<!-- PIMA Icons for Reporting,Excel and PDF -->
					<td><center><i class="fa fa-check-square-o fa-2x" style="color: green;"></i></center></td>
					<!-- <td><center><i class="fa fa-times fa-2x" style="color: red; "></i></center></td>-->
					
					
				</tr>
				<?php $i++;}?>

			</tbody>
		</table>
</div>