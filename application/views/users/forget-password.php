
<?php echo form_open('users/forget_password_mail'); ?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
	   <h1 class="text-center">Forget Password</h1>	
	   
	   <?php 
			echo validation_errors(); 
			if($this->session->flashdata('message')) :
				echo '<div class="alert alert-success">
			    <button type="button" class="close" data-dismiss="alert">&times;</button>';
				echo $this->session->flashdata('message');
				echo '</div>';
			endif;
			?>
	  
	   <div class="form-group">
	   	<!--  <label>Username</label> -->
	   	 <input type="text" name="email" class="form-control" placeholder="Enter Email" required autofocus>
	   </div>
	   <div class="form-group">
	   	 <a href="<?php echo base_url()?>users/login">Login</a>
	   	 
	   </div>
	   <button type="submit" class="btn btn-primary btn-block">Submit</button>
	</div>
</div>
<?php echo form_close() ?>

