<div >
	<div class="section-title"><center><b><strong>Deactivated User Details</strong></b></center></div>
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
					<th rowspan = "2">Previous Station</th>
					<th colspan="2"><center>Actions</center></th>
				</tr>
				<tr>
					<th>Reset Password</th>
					<th>Activate User</th>
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
							<a title =" Activate User (<?php echo $user['username'];?>) " href="#deactivate_user" data-toggle="modal" data-id="<?php echo $user['user_id']; ?>" data-name="<?php echo $user['name'] ?>" style="border-radius:1px;" class="add_active" > 
								<span style="font-size: 1.4em;color: #3e8f3e;" class="glyphicon glyphicon-ok-sign"></span>
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

	      			<b><div style="width:210px;float:left;">Are you sure you want to activate</div><div style="width:210px;float:left;" id="user_name"></div></b>
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
<script type="text/javascript">

 	$(document).on("click", ".add_active", function () { //pick value from the table and put in bootstrap modal
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
					url 		: '<?php echo base_url();?>admin/users/activate', // the url where we want to POST
					data 		: formData, // our data object
					success: function(result) {
	    				$('#response').append(result);
	    				setTimeout(function() { window.location=window.location;},2000);//refresh page after 2 seconds	
	    			}
				});

	});
</script>