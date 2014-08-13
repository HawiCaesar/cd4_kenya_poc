<div class="section-title" ><center>Facilites Running Control Tests</center></div>

<?php if($check_value==1)
{
?>

<table id="data-table_quality">
	<thead>
		<tr>
			<th colspan = "2"><center>Period</center></th>
			<th rowspan = "2"><center>PIMA Device - Facility</center></th>
			<th rowspan = "2"><center>Has Run Control Tests?</center></th>
			<th rowspan = "2"><center>Total Control Tests Run</center></th>
			<th rowspan = "2"><center>Recommened Controls</center></th>
		</tr>
		<tr>
			<th><center>From</center></th>
			<th><center>To</center></th>
		</tr>
	</thead>
	<tbody>	
			<?php foreach($control_count_list as $count): ?>
			<tr>
				<td><center><?php echo date('d F Y',strtotime($count['result_date'])); ?></center></td>
				<td><center><?php echo date('d F Y'); ?></center></td>
				<td><center><?php echo $count['serial_num']." - ".$count['facility']; ?></center></td>
				<td><center><?php if(!$count['total_tests']==0){?><i class="fa fa-check-square-o fa-2x" style="color: green;"></i>
						<?php  }else{?><i class="fa fa-times fa-2x" style="color: red; "></i><?php }?>
					</center>
				</td>
				<td><center><?php echo $count['total_tests']; ?></center></td>
				<td><center>2</center></td>
			</tr>
			<?php endforeach ?>
	</tbody>
</table>

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
