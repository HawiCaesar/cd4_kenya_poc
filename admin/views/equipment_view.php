<div >
	<div class="section-title" ><center><b><strong>Equipment Details</strong></b></center></div>
	<div>
		<table id="data-table">
			<thead>
				<tr>
					<th rowspan = "2">#</th>
					<th rowspan = "2">Facility Name</th>
					<th rowspan = "2" >Equipment</th>
					<th rowspan = "2" >Equipment Serial</th>
					<th rowspan = "2">Date Added</th>
					<th rowspan = "2">Date Removed</th>					
					<th rowspan = "2">Deactivation Reason</th>
					<th colspan="2"><center>Actions</center></th>

				</tr>
				<tr>
					<th nowrap>Status</th>
					<th>Edit Details</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					foreach ($equipments as $equipment) {
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $equipment['facility'];?></td>
					<td>
						<?php
							if($equipment['equipment']=="Alere PIMA"){
						?>
						<a title =" view Equipment (<?php echo $equipment['facility'];?>'s')  PIMA Details" href="javascript:void(null);" style="border-radius:1px; " class="" onclick="edit_facility(<?php echo $equipment['facility_id'];?>)"> 
							<span style="" class="glyphicon glyphicon-list-alt">
							</span>
							<?php echo $equipment['equipment'];?>
						</a>
						<?php 
							}
						?>
					</td>
					<td><?php echo $equipment['serial'];?></td>
					<td><?php echo $equipment['date_added'];?></td>
					<td><?php echo $equipment['date_removed'];?></td>
					<td><?php echo $equipment['deactivation_reason'];?></td>
					<td>
						
						<?php 
							$id = $equipment["facility_equipment_id"];
							$status = $equipment["equipment_status"];

							echo '<a title ="'.$status.'" href="javascript:void(null);" style="border-radius:1px;" class="" onclick="rollout_toggle('.$id.')">';
						
							if($equipment['equipment_status']==5){
								echo '<span style="font-size: 1.4em;color: #2d6ca2;" class="glyphicon glyphicon-minus-sign" ></span></a>';								
							}elseif($equipment['equipment_status']==1){
								echo '<span style="font-size: 1.4em;color: #3e8f3e;" class="glyphicon glyphicon-ok-sign"></span></a>';								
							}elseif($equipment['equipment_status']==4){
								echo '<span style="font-size: 1.4em;color: #c12e2a;" class="glyphicon glyphicon-remove-sign"></span></a>';								
							}else{
								echo '<span style="font-size: 1.4em;color: #eb9316;" class="glyphicon glyphicon-question-sign"></span></a>';														
							}
							echo '</a>';
						?>
						
					</td>
					<td>
						<a title =" Edit Equipment (<?php echo $equipment['facility'];?>)" href="javascript:void(null);" style="border-radius:1px;" class="" onclick="edit_equipment(<?php echo $equipment['facility_id'];?>)"> 
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
			<li id ="tabAddCat"><a href="#tabs1-add_category" data-toggle="tab">Add Equipment Category</a></li>
			<li id ="tabAddEquip" ><a href="#tabs1-add_equip" data-toggle="tab">Add Equipment</a></li>
			<li id ="tabAddFacEquip" class="active"><a href="#tabs1-add_fac_equip" data-toggle="tab">Allocate Equipment</a></li>
		</ul>
		<div class="tab-content">
			<!-- Add new -->
			<div class="tab-pane active" id="tabs1-add_fac_equip">
				<div class="mycontainer">
					<?php echo form_open('admin/equipment/save_fac_equip');?>
						<div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Equipment Category:</span>
							<select required id="cat" name="cat" class="textfield form-control" >
			                   	<option  value="" required >*Select an Equipment Category*</option> 
			                   	<?php
			                   		foreach($equipment_category as $cat){
			                   	?>   
			                   	<option value= "<?php echo $cat["id"] ?>" ><?php echo $cat["description"] ?></option>
			                   	<?php
			                   		}
			                   	?>               					
			                </select>
		                </div>					
						<div id="equipmentdiv" class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Equipment Type:</span>
							<select required id="equipment" name = "equipment" class="textfield form-control" >
			                   	<option value="">*Select an Equipment*</option>                   					
			                </select>
		                </div>
		               
		                <div id="facility" class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Select Facility:</span>
							<select  required id="fac" name="fac"  class="textfield form-control" >
			                   	<option value="">*Select a Facility*</option> 
			                   	<?php
			                   		foreach($facilities as $fac){
			                   	?>   
			                   	<option value= "<?php echo $fac["facility_id"] ?>" ><?php echo $fac["facility"] ?></option>
			                   	<?php
			                   	}
			                   	?>                  					
			                </select>
		                </div>		
		                <div id="equipmentserial" class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Equipment Serial:</span>
							<input required id="equipserial" name="equipserial" class="textfield form-control" type="text" />
						</div>	
						<div id="printerserial" class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Printer Serial:</span>
							<input required id="prtserial" name="prtserial" class="textfield form-control" type="text" />
						</div>									
						<div class="right" style="padding:7px;">
							<button name="save" type="submmit" onclick="viewData()" class="btn btn-primary btn-minii"><i class="glyphicon glyphicon-save"></i>Save</button>
							<button name="reset" type="reset"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i>Discard</button>
						</div>						
					</form>
				</div>
			</div>
			<div class="tab-pane" id="tabs1-add_equip">
				<div class="mycontainer" style="float:left;">					
					<?php echo form_open('admin/equipment/save_equip');?>				
						<div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Type:</span>
							<select required name="cat1" class="textfield form-control" >
			                   	<option  value="">*Select an Equipment Category*</option>   
			                   	<?php
			                   		foreach($equipment_category as $cat){
			                   	?>   
			                   	<option value= "<?php echo $cat["id"] ?>" ><?php echo $cat["description"] ?></option>
			                   	<?php
			                   		}
			                   	?>                					
			                </select>
		                </div>	          
						<div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Description :</span>
							<input  name="eq1" class="textfield form-control" type="text" />
						</div>									
						<div class="right" style="padding:7px;">
							<button name="saveeq" type="submit" onclick="viewData()" class="btn btn-primary btn-minii"><i class="glyphicon glyphicon-save"></i>Save</button>
							<button name="reset" type="reset"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i>Discard</button>
						</div>						
					</form>
				</div>
				<div class="mycontainer" style="float:right;">
					<table id="data-table_dev">
						<thead>
							<tr>
								<th>#</th>
								<th>Description</th>
								<th>Category</th>
							</tr>
						</thead>
						<tbody>	
							<?php 
								$i=1;
								foreach ($equipment_1 as $eq) {
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $eq['description'];?></td>
								<td><?php echo $eq['category_desc'];?></td>
							</tr>
							<?php 
									$i++;
								}
							?>						
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="tabs1-add_category">
				<div class="mycontainer" style="float:left;">
					<?php echo form_open('admin/equipment/save_cat');?>	          
						<div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Description :</span>
							<input  name="cat2" class="textfield form-control" type="text" />
						</div>									
						<div class="right" style="padding:7px;">
							<button name="savecat" type="submit" onclick="viewData()" class="btn btn-primary btn-minii"><i class="glyphicon glyphicon-save"></i>Save</button>
							<button name="reset" type="reset"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i>Discard</button>
						</div>						
					</form>
				</div>
				<div class="mycontainer" style="float:right;">
					<table id="data-table_cat">
						<thead>
							<tr>
								<th>#</th>
								<th>Category</th>
							</tr>
						</thead>
						<tbody>	
							<?php 
								$i=1;
								foreach ($equipment_category as $cat) {
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $cat['description'];?></td>
							</tr>
							<?php 
									$i++;
								}
							?>						
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("equipment_footer_view");?>