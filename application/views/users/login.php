
<?php echo form_open('users/login'); ?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
	   <h1 class="text-center"><?= $title ?></h1>	
	   <div class="alert alert-success" role="alert">
	   	<?php
	   	echo validation_errors();
	   	if($this->session->flashdata('message')):
            echo $this->session->flashdata('message');
        endif;
        ?>
	   </div>
	   <div class="form-group">
	   	<!--  <label>Username</label> -->
	   	 <input type="text" name="email" class="form-control" placeholder="Enter Email" required autofocus>
	   </div>
	   <div class="form-group">
	   	 <!-- <label>Password</label> -->
	   	 <input type="password" class="form-control" name="password" placeholder="Enter Password" required autofocus>
	   </div>
	   <div class="form-group">
	   	 <a href="<?php echo base_url()?>users/forget-password">Forgot Password</a>
	   	 
	   </div>
	   <button type="submit" class="btn btn-primary btn-block">Login</button>
	</div>
</div>
<?php echo form_close() ?>
