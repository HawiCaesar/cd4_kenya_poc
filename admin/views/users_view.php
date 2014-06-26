<div >
	<div class="section-title"><center><b><strong>User Details</strong></b></center></div>
	<div>
		<table id="data-table">
			<thead>
				<tr>
					<th rowspan = "2">#</th>
					<th rowspan = "2">Username</th>					
					<th rowspan = "2">Name</th>
					<th rowspan = "2">Phone Number</th>
					<th rowspan = "2">Email</th>
					<th rowspan = "2">Type</th>
					<th rowspan = "2">Status</th>
					<th colspan="4"><center>Actions</center></th>
				</tr>
				<tr>
					<th>Reset Password</th>
					<th>Activate</th>
					<th>Remove</th>
					<th>Edit Details</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					foreach ($users as $user) {
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $user['username'];?></td>
					<td><?php echo $user['name'];?></td>
					<td><?php echo $user['phone'];?></td>
					<td><?php echo $user['email'];?></td>	
					<td><?php echo $user['user_group'];?></td>					
					<td><?php echo $user['status_desc'];?></td>
					<td>
						<a title =" Reset User (<?php echo $user['username'];?>) Password" href="javascript:void(null);" style="border-radius:1px;" class="" onclick="reset_password(<?php echo $user['user_id'];?>)"> 
							<span style="font-size: 1.4em;color: #eb9316;" class="glyphicon glyphicon-pencil"></span>
						</a>
					</td>				
					<td>						
						<?php 
							$id = $user["user_id"];
							$status = $user["status_desc"];

							echo '<a title ="'.$status.'" href="javascript:void(null);" style="border-radius:1px;" class="" onclick="rollout_toggle('.$id.')">';
				
							if($user['status']==5){
								echo '<span style="font-size: 1.4em;color: #2d6ca2;" class="glyphicon glyphicon-minus-sign" ></span></a>';								
							}elseif($user['status']==1){
								echo '<span style="font-size: 1.4em;color: #3e8f3e;" class="glyphicon glyphicon-ok-sign"></span></a>';								
							}elseif($user['status']==4){
								echo '<span style="font-size: 1.4em;color: #c12e2a;" class="glyphicon glyphicon-remove-sign"></span></a>';								
							}else{
								echo '<span style="font-size: 1.4em;color: #eb9316;" class="glyphicon glyphicon-question-sign"></span></a>';																
							}						
							echo '</a>';
						?>
						
					</td>
					<td>
						<a title =" Remove User (<?php echo $user['username'];?>) " href="javascript:void(null);" style="border-radius:1px;" class="" onclick="remove_user(<?php echo $user['user_id'];?>)"> 
							<span style="font-size: 1.4em;color: #2d6ca2;" class="glyphicon glyphicon-minus-sign"></span>
						</a>
					</td>
					<td>
						<a title =" Edit User (<?php echo $user['username'];?>)" href="javascript:void(null);" style="border-radius:1px;" class="" onclick="edit_user(<?php echo $user['user_id'];?>)"> 
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
			<li id ="tabAdd" class="active"><a href="#tabs1-add" data-toggle="tab">Add User</a></li>
			<li id ="tabType"><a href="#tabs1-type" data-toggle="tab">User Types</a></li>
		</ul>
		<div class="tab-content">
<!-- Javascript for Add New-->

<script type="text/javascript">

 $(document).ready(function(){
 	$("#usercriteria").hide();
	$('#usertype').change(function(){
		
		$("#usercriteria").show();
		var val=$('#usertype').val();
		
		if(val==3){
			$('#partn').show();
			$('#subcounty').hide();
			$('#fac').hide();
			$('#county').hide();
			$('#admin').hide();
		}
		if(val==9){
			$('#county').show();
			$('#fac').hide();
			$('#partn').hide();
			$('#admin').hide();
		}
		if(val==6){
			$('#fac').show();
			$('#subcounty').hide();
			$('#county').hide();
			$('#partn').hide();
			$('#admin').hide();
		}
		if(val==2){
			$('#admin').show();
			$('#subcounty').hide();
			$('#fac').hide();
			$('#partn').hide();
			$('#county').hide();
		}
	});
	
 	
});

    </script>
			<!-- Add new -->
			<div class="tab-pane active" id="tabs1-add" >
				<?php 
				echo form_open('admin/users/save_user_details');
				?>					<table>
						<tr style="width:80%">
							<td style="width:50%" id="usergeneral">
								<div class="mycontainer" id="full">
									<div class="input-group" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">Name :</span>
										<input class="textfield form-control" type="text" name="name" required/>
									</div>         
									<div class="input-group" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">Username :</span>
										<input class="textfield form-control" type="text" name="username" required/>
									</div>
									<div class="input-group" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">Email :</span>
										<input class="textfield form-control" type="text" name="email" required/>
									</div>
									<div class="input-group" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">Phone :</span>
										<input class="textfield form-control" type="text" name="phone" required/>
									</div>
									<div class="input-group" id="usertype_div" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">User Type:</span>
										<select  class="textfield form-control" id="usertype" name="usertype" >
						                   <option selected="selected" value="0">*Select a User Type*</option>
						                   	<?php foreach ($usertype as $usertype)
																	{
																	 echo '<option value="'. $usertype['id'].'">'. $usertype['des'].'</option>';
																	
																	}?>            					
						                </select>
					                </div>
				                </div>
					        </td>
					       
					        <td name="usercriteria" id="usercriteria" style="width:80%">
								<div class="mycontainer" id="full">
								
					                <div class="input-group" id="fac" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">Facility :</span>
										<select  class="textfield form-control" name="fac" >
						                   	<option selected="selected" value="0">*Select a facility*</option>
						                   	<?php foreach ($fac as $facility)
																	{
																	 echo '<option value="'. $facility['id'].'">'. $facility['des'].'</option>';
																	
																	}?>          					
						                </select>
					                </div>
					          	            
					                <div class="input-group" id="partn" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">Partner Type:</span>
										<select  class="textfield form-control" name="partn">
						                   	<option selected="selected" value="0">*Select a user partner*</option> 
						                      <?php foreach ($partner as $partner)
																	{
																	 echo '<option value="'. $partner['ID'].'">'. $partner['des'].'</option>';
																	
																	}?>      					
						                </select>
					                </div>
					              
					                <div class="input-group" id="county" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">County:</span>
										<select  class="textfield form-control" name="county">
						                   	<option selected="selected" value="0">*Select a user county*</option> 
						                   	  <?php foreach ($county as $county)
																	{
																	 echo '<option value="'. $county['id'].'">'. $county['des'].'</option>';
																	
																	}?>                 					
						                </select>
					                </div>
					                <div class="input-group" id="admin" style="width: 100%;padding:4px;">
										<span class="input-group-addon" style="width: 40%;">Administrator:</span>
										<select  class="textfield form-control" name="admin">
						                   	<option selected="selected" value="0">*Select admin type*</option> 
						                   	<option value="1">Admin</option>
						                   	<option value="2">Super Admin</option>       					
						                </select>
					                </div>
					                
					                
									<div class="right" id="save" style="padding:7px;">
										<button name="viewData" type="submit"  class="btn btn-primary btn-minii"><i class="glyphicon glyphicon-save"></i>Save</button>
										<button name="reset" type="reset"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i>Discard</button>
									</div>
														
								</div>
							</td>
							
						</tr>
					</table>
				<?php echo form_close();?>
			</div>
			<!-- type -->
			<div class="tab-pane" id="tabs1-type" >
				<div class="mycontainer" style="float:left;">
					<form>	          
						<div class="input-group" style="width: 100%;padding:4px;">
							<span class="input-group-addon" style="width: 40%;">Description :</span>
							<input class="textfield form-control" type="text" />
						</div>									
						<div class="right" style="padding:7px;">
							<button name="viewData" type="button" onclick="viewData()" class="btn btn-primary btn-minii"><i class="glyphicon glyphicon-save"></i>Save</button>
							<button name="reset" type="reset"  class="btn btn-default btn-minii"><i class="glyphicon glyphicon-remove"></i> Discard</button>
						</div>						
					</form>
				</div>
				<div class="mycontainer" style="float:right;">
					<div class="section-title"><center><b><strong>User Types</strong></b></center></div>
					<table id="data-table">
						<thead>
							<tr>
								<th rowspan = "2">#</th>
								<th rowspan = "2">User Type</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>nos</td>
							    <td>user type</td>
						    </tr>	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>