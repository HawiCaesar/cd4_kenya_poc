<div>
	<div class="section-title"><center><b><strong>CD4 Reporting - <?php 
				if($this->session->userdata('cd4_filter_desc'))
				{
					echo $this->session->userdata('cd4_filter_desc');
				}
				else
				{
					echo date('F , Y', strtotime("-1 months"));
				}

				 ?></strong></b></center></div>
				 <div class="progress">
				  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percentage_cd4_reported ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_cd4_reported ?>%;">
				    <b>F-CDRR: <?php echo $percentage_cd4_reported ?> %</b>
				  </div>
				</div>

				<div class="progress">
				  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percentage_cd4poc_reported ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_cd4poc_reported ?>%;">
				    <b>PIMA Results Uploaded: <?php echo $percentage_cd4poc_reported ?> %</b>
				  </div>
				</div>
				<?php
				$this->load->view('admin/admin_filter_view');
				foreach($facility_results as $facility_list) //loop through all facilites and set search key
				{
					$searchkey_array[$facility_list['name']]=$facility_list['name'];
				}

				foreach($poc_facility_list as $poc_details) // loop through cd4poc facilities and set search key
				{
					$searchkey_array_poc[$poc_details['facility_name']]=$poc_details['facility_name'];
				}

				//set new arrays
				$poc_results=array();
				$cd4_fcdrr_results=array();

				// if(!$cd4_results==0)// check if fcdrr is null
				// {
					foreach($cd4_results as $key => $cd4)
					{
						if(array_key_exists($cd4['cd4_name'], $searchkey_array))
						{
							$cd4_fcdrr_results[$cd4['cd4_name']]=$cd4['cd4_name'];
						}
						else
						{
							$cd4_fcdrr_results[$cd4['cd4_name']]="-";
						}
					}

					foreach($cd4poc_results as $key => $cd4poc)
					{
						if($cd4poc['poc_name'] && $cd4poc['cd4_test_id']==NULL)
						{
							$poc_results[$cd4poc['poc_name']]="--";
						}
						else if($cd4poc['cd4_test_id'])
						{
							$poc_results[$cd4poc['poc_name']]=$cd4poc['poc_name'];
						}
					}	

					 //print_r($poc_results);die;
				//}

				
		?>
		<table id="data-table" >
			<thead>
				
				<tr>
					<th rowspan = "2">#</th>
					<th rowspan = "2">Facility Name</th>					
					<th colspan = "2"><center>Period</center></th>
					<th colspan = "1"><center>F-CDRR</center></th>
					<th colspan = "1"><center>PIMA</center></th>
				</tr>

				<tr>
					<th><center>From</center></th>
					<th><center>To</center></th>
					<th><center>Reported</center></th>					
					<th><center>Results Uploaded</center></th>
					
				</tr>
			</thead>
			<tbody>
				<?php $i=1;
					foreach($facility_results as $facility_list): ?>
					<tr>
						<td><?php echo $i?></td>
						<td><?php echo $facility_list['name'];?></td>
						<td><center><?php if($this-> session-> userdata('cd4_start_date')){
											echo date("jS F Y",strtotime($this-> session-> userdata('cd4_start_date')));
										}else{
												echo $start= date('jS F Y', strtotime("first day of -1 months"));
											} ?></center></td>
						<td><center><?php if($this-> session-> userdata('cd4_stop_date')){
											echo date("jS F Y",strtotime($this-> session-> userdata('cd4_stop_date')));
										}else{
												echo $stop= date('jS F Y', strtotime("last day of -1 months"));
											} ?></center></td>
						<?php if(array_key_exists($facility_list['name'],$cd4_fcdrr_results)){ ?>
										<td><center><i class="fa fa-check-square-o fa-2x" style="color: green;"></i></center></td>
						<?php } else { ?><td><center><i class="fa fa-times fa-2x" style="color: red;"></i></center></td><?php } ?>

						<?php if(array_key_exists($facility_list['name'],$poc_results))
								{ 
									if($poc_results[$facility_list['name']]=="--")
									{
										echo '<td><center><i class="fa fa-times fa-2x" style="color: red;"></i></center></td>';
									}else
									{
										echo '<td><center><i class="fa fa-check-square-o fa-2x" style="color: green;"></i></center></td>';
									}

								}else { ?><td><center>N / A</center></td><?php } ?>
					<?php $i++; endforeach; ?>
					</tr>
			</tbody>
		</table>
</div>