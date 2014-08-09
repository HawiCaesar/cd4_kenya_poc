<div >
	<div class="section-title"><center><b><strong>Active User Details</strong></b></center></div>
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
					<th rowspan = "2">Station</th>
					<th colspan="4"><center>Actions</center></th>
				</tr>
				<tr>
					<th>Reset Password</th>
					<th>Deactivate User</th>
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
					<td><?php echo $user['Stationed At'];?></td>			
					<td>
						<center>
							<a title =" Reset User (<?php echo $user['username'];?>) Password" href="#user_password" data-toggle="modal" data-id="<?php echo $user['user_id']; ?>" data-name="<?php echo $user['name'] ?>" style="border-radius:1px;" class="rpassword"> 
								<span style="font-size: 1.4em;color: #eb9316;" class="glyphicon glyphicon-pencil"></span>
							</a>
						</center>
					</td>				
					<td>
						<center>
							<a title =" Deactivate User (<?php echo $user['username'];?>) " href="#deactivate_user" data-toggle="modal" data-id="<?php echo $user['user_id']; ?>" data-name="<?php echo $user['name'] ?>" style="border-radius:1px;" class="remove_active" > 
								<span style="font-size: 1.4em;color: red;" class="glyphicon glyphicon-remove-sign"></span>
							</a>
						</center>
					</td>
					<td>
						<center>
							<a title =" Edit User (<?php echo $user['username'];?>)" href="#specific_profile" data-toggle="modal" data-id="<?php echo $user['user_id']; ?>" data-user_name="<?php echo $user['username'] ?>" data-name="<?php echo $user['name'] ?>" data-phone="<?php echo $user['phone'] ?>" data-email="<?php echo $user['email'] ?>" style="border-radius:1px;" class="edit_user"> 
								<span style="font-size: 1.3em;color:#2aabd2;" class="glyphicon glyphicon-pencil"></span>
							</a>
						</center>
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

<!-- deactivate user modal -->
	<div class="modal fade" id="deactivate_user" >
	  	<div class="modal-dialog" style="width:37%;margin-bottom:2px;">
	    	<div class="modal-content" >
	      		<div class="modal-header">
	        		<h4>Deactivate User<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h4>
	      		</div>
	      		<div class="modal-body" style="padding-bottom:0px;">

	      			<b><div style="width:210px;float:left;">Are you sure you want to deactivate</div><div style="width:210px;float:left;" id="user_name"></div></b>
	      			<br /><br />	
	      			<form action="" method="POST" id="deactivate_form" >
	      				<input type="hidden" name="users_name" id="users_name" value="" />
	      				<input type="hidden" name="user_id" id="user_id" value="" /><br />
	      				<button class="btn btn-primary" ><i class="glyphicon glyphicon-save"></i>Confim</button>
	      				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>Close</button>
	      			</form>
	      			<br /> 
	      			<div id="response"></div>   			
	      		</div>		      		
	      		<div class="modal-footer" style="height:11px;padding-top:11px;">
	      			<?php echo $this->config->item("copyrights");?>
	      		</div> 
	   		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<!-- END deactivate user modal -->

<!-- reset user modal -->
	<div class="modal fade" id="user_password" >
	  	<div class="modal-dialog" style="width:37%;margin-bottom:2px;">
	    	<div class="modal-content" >
	      		<div class="modal-header">
	        		<h4>Reset User Password<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h4>
	      		</div>
	      		<div class="modal-body" style="padding-bottom:0px;">

	      			<b><div style="width:290px;float:left; ">Are you sure you want to reset the password for </div><div style="width:150px;float:left;" id="user_name_p"></div></b>
	      			<br /><br />		
	      			<form action="" method="POST" id="reset_form" >
	      				<input type="hidden" name="users_name" id="users_name" value="" />
	      				<input type="hidden" name="user_id" id="user_id" value="" /><br />
	      				<button class="btn btn-primary" ><i class="glyphicon glyphicon-save"></i>Confim</button>
	      				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>Close</button>
	      			</form>
	      			<br /> 
	      			<div id="response_password"></div>
	      		</div>		      		
	      		<div class="modal-footer" style="height:11px;padding-top:11px;">
	      			<?php echo $this->config->item("copyrights");?>
	      		</div> 
	   		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<!-- END reset user modal -->

<!-- user profile modal -->
	<div class="modal fade" id="specific_profile" >
	  	<div class="modal-dialog" style="width:37%;margin-bottom:2px;;">
	    	<div class="modal-content" >
	      		<div class="modal-header">
	        		<h4>Update User Profile<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h4>
	      			<div id="response_update"></div>
	      		</div>
	      		<div class="modal-body" style="padding-bottom:0px;">

	      			<?php $this->load->view('admin/users_profile_view');?>
	      		</div>
	      				      		
	      		<div class="modal-footer" style="height:11px;padding-top:11px;">
	      			<?php echo $this->config->item("copyrights");?>
	      		</div> 
	   		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<!-- END user  profile modal -->

<div>
	<div class="tabbable span12" style="margin-top:5px;">
		<ul class="nav nav-tabs">
			<li id ="tabAdd" class="active"><a href="#tabs1-add" data-toggle="tab">Add User</a></li>
			<li id ="tabType"><a href="#tabs1-type" data-toggle="tab">User Types</a></li>
		</ul>
		<div class="tab-content">
<!-- Javascript for Add New-->

<script type="text/javascript">

 $(document).on("click", ".remove_active", function () { //pick value from the table and put in bootstrap modal
	     var id = $(this).data('id');
	     var name=$(this).data('name');

	     $(".modal-body #user_id").val( id );
	     $(".modal-body #users_name").val( name );
	     document.getElementById('user_name').innerHTML=name + " ?";
	});

	$(document).on("click", ".rpassword", function () { //pick value from the table and put in bootstrap modal
	     var id = $(this).data('id');
	     var name=$(this).data('name');

	     $(".modal-body #user_id").val( id );
	     $(".modal-body #users_name").val( name );
	     document.getElementById('user_name_p').innerHTML=name + " ?";
	});

	$(document).on("click", ".edit_user", function () { //pick value from the table and put in bootstrap modal
	     var id = $(this).data('id');
	     var name =$(this).data('name');
	     var user_name=$(this).data('user_name');
	     var phone=$(this).data('phone');
	     var email=$(this).data('email');

	     $(".modal-body #user_id").val( id );
	     $(".modal-body #name").val( name );
	     $(".modal-body #user_name").val( user_name );
	     $(".modal-body #phone").val( phone );
	     $(".modal-body #email").val( email );

	});

	$('#reset_form').submit(function(event){ //reset password javascript, ajax
		event.preventDefault();

		var formData = {
			'user_id' : $('input[name=user_id]').val(),
			'users_name': $('input[name=users_name]').val()
		};

		$.ajax({
					type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url 		: '<?php echo base_url();?>admin/users/reset_password', // the url where we want to POST
					data 		: formData, // our data object
					success: function(result) {
	    				$('#response_password').append(result);
	    				setTimeout(function() { window.location=window.location;},2000);//refresh page after 2 seconds	
	    			}
				});

	});

	$('#deactivate_form').submit(function(event){ //deactivate user javascript, ajax
		event.preventDefault();

		var formData = {
			'user_id' : $('input[name=user_id]').val(),
			'users_name': $('input[name=users_name]').val()
		};

		$.ajax({
					type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url 		: '<?php echo base_url();?>admin/users/deactivate', // the url where we want to POST
					data 		: formData, // our data object
					success: function(result) {
	    				$('#response').append(result);
	    				setTimeout(function() { window.location=window.location;},2000);//refresh page after 2 seconds	
	    			}
				});

	});
	$('#profile').submit(function(event){// update user profile javascipt, ajax
		event.preventDefault();

		var formData = {
			'user_id' : $('input[name=user_id]').val(),
			'name': $('input[name=name]').val(),
			'phone': $('input[name=phone]').val(),
			'email': $('input[name=email]').val()
		};

		$.ajax({
					type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url 		: '<?php echo base_url();?>admin/users/update_profile', // the url where we want to POST
					data 		: formData, // our data object
					success: function(result) {
	    				$('#response_update').append(result);
	    				setTimeout(function() { window.location=window.location;},2000);//refresh page after 2 seconds	
	    			}
				});

	});

    </script>
			<!-- Add new user -->
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

<div>
</div>