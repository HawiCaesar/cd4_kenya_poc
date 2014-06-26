<div >
	<div class="section-title"><center><b><strong>Facility Details</strong></b></center></div>
	<div>
		<table id="data-table">
			<thead>
				<tr>
					<th rowspan = "2">#</th>
					<th rowspan = "2">Facility Name</th>					
					<th rowspan = "2">Sub-County</th>
					<th rowspan = "2">County</th>
					<th rowspan = "2">Partner</th>
					<th rowspan = "2"># equipment</th>
					<th rowspan = "2"># Users</th>
					<th colspan="2"><center>Actions</center></th>

				</tr>
				<tr>
					<th>Rollout</th>
					<th>Edit Details</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					foreach ($facilities as $facility) {
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $facility['facility'];?></td>
					<td><?php echo $facility['district'];?></td>
					<td><?php echo $facility['region'];?></td>
					<td><?php echo $facility['partner'];?></td>	
					<td><?php echo $facility['equipment_count'];?></td>					
					<td><?php echo $facility['users_count'];?></td>
					<td>
						
						<?php 
							$id = $facility["facility_id"];
							$rollout = $facility["facility_rollout_status"];

							echo '<a title ="'.$rollout.'" href="javascript:void(null);" style="border-radius:1px;" class="" onclick="rollout_toggle('.$id.')">';
							if($facility['rollout_id']==5){
								echo '<span style="font-size: 1.4em;color: #2d6ca2;" class="glyphicon glyphicon-minus-sign" ></span></a>';
							}elseif($facility['rollout_id']==1){								
								echo '<span style="font-size: 1.4em;color: #3e8f3e;" class="glyphicon glyphicon-ok-sign"></span></a>';								
							}elseif($facility['rollout_id']==4){
								echo '<span style="font-size: 1.4em;color: #c12e2a;" class="glyphicon glyphicon-remove-sign"></span></a>';
							}else{
								echo '<span style="font-size: 1.4em;color: #eb9316;" class="glyphicon glyphicon-question-sign"></span></a>';																
							}
							echo '</a>';
						?>
						
					</td>
					<td>
						<a title =" Edit Facility (<?php echo $facility['facility'];?>)" href="javascript:void(null);" style="border-radius:1px;" class="" onclick="edit_facility(<?php echo $facility['facility_id'];?>)"> 
							<span style="font-size: 1.3em;color:#2aabd2;" class="glyphicon glyphicon-pencil"></span>
						</a>
					</td>
				</tr>
				<?php
					$i++;
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<div>
	<div class="tabbable span12" style="margin-top:5px;">
		<ul class="nav nav-tabs">
			<li id ="tabAdd" class="active"><a href="#tabs1-add" data-toggle="tab">Add Facility</a></li>
			<li id ="tabDistrict"><a href="#tabs1-District" data-toggle="tab">Sub-County</a></li>
			<li id ="tabRegion"><a href="#tabs1-region" data-toggle="tab">County</a></li>
			<li id ="tabPartner"><a href="#tabs1-partner" data-toggle="tab">Partners</a></li>
		</ul>
		<div class="tab-content">

			<!-- Add new -->
			<div class="tab-pane active" id="tabs1-add" >
				<div class="mycontainer">
					<form>
						<div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Facility Name:</span>
							<input class="textfield form-control" type="text" />
						</div>	
		                <div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">County:</span>
							<select  class="textfield form-control" >
			                   	<option value="-1">*Select a County*</option>                   					
			                </select>
		                </div>
		                <div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Sub-County:</span>
							<select  class="textfield form-control" >
			                   	<option value="-1">*Select a Sub-County*</option>                   					
			                </select>
		                </div>														
						<div class="right" style="padding:7px;">
							<button name="viewData" type="button" onclick="viewData()" class="btn btn-primary btn-minii"><i class="glyphicon glyphicon-save"></i>Save</button>
							<button name="reset" type="reset"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i>Discard</button>
						</div>						
					</form>
				</div>
			</div>
			<!-- Sub County -->
			<div class="tab-pane" id="tabs1-District" >				
			</div>
			<!-- County-->
			<div class="tab-pane" id="tabs1-Region" >				
			</div>
			<!-- Partner -->
			<div class="tab-pane" id="tabs1-Partner" >				
			</div>
		</div>
	</div>
</div>