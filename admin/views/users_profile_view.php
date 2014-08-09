
	<div class="section-title" ><center>Edit Profile</center></div>	
	<div class="mycontainer" style="width:400px;">
		<?php
			echo form_open(base_url().'admin/users/update_profile',"id='profile'");

			$username = array(
						'name'	=>	"user_name",
						'id'	=>	"user_name",
						'class'	=>	"textfield form-control",
						'value'	=>	"",
						'readonly'	=>	"readonly"
				);
			$name = array(
						'name'	=>	"name",
						'id'	=>	"name",
						'class'	=>	"textfield form-control",
						'value'	=>	""
				);
			$phone = array(
						'name'	=>	"phone",
						'id'	=>	"phone",
						'class'	=>	"textfield form-control",
						'value'	=>	""
				);
			$email = array(
						'name'	=>	"email",
						'id'	=>	"email",
						'class'	=>	"textfield form-control",
						'value'	=>	""
				);
			$submit = array(
						'name'	=>	"submit",
						'id'	=>	"submit",
						'class'	=>	"textfield form-control"
				);
		?>
			<input value="" id="user_id" name="user_id" type="hidden" />
			<div class="input-group" style="width: 100%;padding:4px;">
				<span class="input-group-addon" style="width: 40%;">Username:</span>
				<?php echo form_input($username);?>
	        </div>				
			<div class="input-group" style="width: 100%;padding:4px;">
				<span class="input-group-addon" style="width: 40%;">Full Names :</span>			
				<?php echo form_input($name);?>
	        </div>	
	        <?php 
				echo form_error('name', '<div class="error" style="margin:3px;border-radius:2px;">', '</div>');
			?>
	        <div class="input-group" style="width: 100%;padding:4px;">
				<span class="input-group-addon" style="width: 40%;">Phone :</span>			
				<?php echo form_input($phone );?>
	        </div>
	        <?php 
				echo form_error('phone', '<div class="error" style="margin:3px;border-radius:2px;">', '</div>');
			?>
	        <div class="input-group" style="width: 100%;padding:4px;">
				<span class="input-group-addon" style="width: 40%;">E-mail :</span>			
				<?php echo form_input($email);?>
	        </div>
	        <?php 
				echo form_error('email', '<div class="error" style="margin:3px;border-radius:2px;">', '</div>');
			?>
	        <div class="right" style="padding:7px;">    
	        	<button name="viewData" class="btn btn-primary btn-mini"><i class="glyphicon glyphicon-save"></i>Save Changes</button>								
	        </div>
	    <?php
	    	echo form_close();
	    ?>
	</div>
