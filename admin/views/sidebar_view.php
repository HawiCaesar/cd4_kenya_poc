<div>
	<div>
		<div class="section-title" ><center>
			Notifications 
			<div class="right">
			<i class="glyphicon glyphicon-exclamation-sign"></i>
			</div>
		</div>
		<div>
			<div class="notice">
				<a href="">
					<i class="glyphicon glyphicon-exclamation-sign"></i> 
					 Devices Awaiting Results Upload.
				</a>
			</div>
			<div class="notice">
				<a href="">
					<i class="glyphicon glyphicon-exclamation-sign"></i> 
					 Errors reported
				</a>
			</div>
			<?php if($number_of_deactivated_users!="none"){ ?>
			<div class="info" style="background: #5bc0de;border: 1px solid #009DCC;
									margin-bottom: 1em;
									padding: 0.6em 0.8em;">
					<?php if($title=="Deactivated Users"){ ?>
							<a href="<?php echo base_url();?>admin/users" style="color: #000;">
								<i class="glyphicon glyphicon-exclamation-sign"></i> 
								Back To Active Users
							</a>
					<?php }else{ ?>
						<a href="<?php echo base_url();?>admin/users/deactivated_users_page" style="color: #000;">
							<i class="glyphicon glyphicon-exclamation-sign"></i> 
							 View Deactivated Users (<?php echo $number_of_deactivated_users;?>)
						</a>
			</div>
			<?php } } ?>

		</div>
	</div>
	<div>
		<div class="section-title" ><center>
			Side Menu 
			<div class="right">
			<i class="glyphicon glyphicon-list"></i>
			</div>
		</div>
		<div>
			<div class="section-content">	
				<ul class="nice-list">
					<li><span class="quiet">1.</span> <a href="<?php echo base_url()?>user/profile">My Profile</a></li>
					<li><span class="quiet">2.</span> <a href="#SystemUploads" data-toggle="modal">Attempt a System Upload</a></li>
					<li><span class="quiet">3.</span> <a href="#flag" data-toggle="modal">flag Device as inactive</a></li>							
					<li><span class="quiet">4.</span> <a href="#changePassword" data-toggle="modal">Change Password</a></li>
				</ul>					
			</div>
		</div>
	</div>
	
</div>