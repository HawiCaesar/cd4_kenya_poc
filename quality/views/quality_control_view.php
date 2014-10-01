<div class="section-title" ><center>Facilites Running Control Tests - 
<?php if($this->session->userdata('quality_filter_desc'))
		{
			echo $this->session->userdata('quality_filter_desc');
		}
		else
		{
			echo "This Week";
		}

 ?>
</center></div>
<?php $this->load->view('quality/quality_filter_view'); ?>
<?php if($check_value==1)//check if there are any controls 
{

	$expected_array=array(); //set an expected array

	foreach ($control_count_list as $value) {
		 $r[$value['facility']]=$value['facility'];
		 $r[$value['serial_num']]=$value['serial_num'];
		 $r[]=$value['total_tests'];
	}

	foreach($expected_count_lists as $key => $value2) //loop through expected to see if facility exists
	{
		if(array_key_exists($value2['facility'], $r))
		{

			$expected_array[$value2['facility']]=$value2['no_days_with_tests']; //fetch the working days 
		}
		else
		{
			$expected_array[$value2['facility']]="-";
		}

	}
?>
<div id="one" style="position:relative;height:870px;">
	<table id="data-table_quality" style="height:100px;">
		<thead>
			<tr>
				<th colspan = "2"><center>Period</center></th>
				<th rowspan = "2"><center>PIMA Device - Facility</center></th>
				<th rowspan = "2"><center>Actual Control Tests Run</center></th>
				<th rowspan = "2"><center>Working Days</center></th>
				<th rowspan = "2"><center>Expected Controls To Be Run</center></th>
			</tr>
			<tr>
				<th><center>From</center></th>
				<th><center>To</center></th>
			</tr>
		</thead>
		<tbody>	
				<?php $i=0; foreach($control_count_list as $count): ?>
				<tr>
					<td><center><?php if($this->session->userdata('quality_date_filter_start'))
										{
											echo date('jS F Y',strtotime($this->session->userdata('quality_date_filter_start')));
										}else { echo date('jS F Y',strtotime('last monday'));} ?></center></td>
					<td><center><?php if($this->session->userdata('quality_date_filter_stop'))
										{
											echo date('jS F Y',strtotime($this->session->userdata('quality_date_filter_stop')));
										}else{ echo date('jS F Y',strtotime('this friday'));} ?></center></td>

					<td><center><?php echo $count['serial_num'].' - '.$count['facility']; ?></center></td>
					<td><center><?php echo $count['total_tests']; ?>
					<?php if(array_key_exists($count['facility'], $expected_array)) //check if facility exists in expected array
		 					{
		 						print '<td><center>'.$expected_array[$count['facility']].'</center></td>';
		 						print '<td><center>'.($expected_array[$count['facility']]*2).'</center></td>';
		 					}else
		 					{
		 						echo "<td><center>-</center></td>";
		 						echo "<td><center>-</center></td>";
		 					}
 					?>
					 
				</tr>
				<?php endforeach ?>
		</tbody>
	</table>
</div>

<?php }else if($check_value==0)
{
	?><p><center><div class="notice" style="width:500px;"><b>No Control Tests Have Been Run 
		<?php
		$user_filter_used = $this->session -> userdata("user_filter_used");
			if($user_filter_used==0)
			{
				echo " yet";		
			}else
			{
				$user_filter = $this->session -> userdata("user_filter");
				foreach ($user_filter as $filter) {
						echo "for ".$filter["user_filter_name"];
					}
			}
		?></b></div></center></p>
	<?php
}
