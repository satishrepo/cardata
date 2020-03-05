
  <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
<!-- Container-fluid starts -->
<div class="container-fluid">
  <div class="row">
      <div class="col-sm-12">

          <!-- Authentication card start -->
          <div class="login-card card-block auth-body">

                  <div class="text-center">
                      <!-- <img src="<?php //echo base_url(); ?>admintemplate/assets/images/auth/logo.png" alt="logo.png"> -->
                  </div>
                    	<div class="col-md-10">
                        <p class="text-left txt-primary" style="color: black;">
                          <?php 
                            echo validation_errors(); 
                            if($this->session->flashdata('message')) {
                              echo $this->session->flashdata('message');
                            }
                          ?>
                            
                          </p>   
                      </div>
                  <div class="auth-box">
                  <?php echo form_open('administrator/update_password'); ?>
                    <div class="input-group">
                      <input type="hidden" name="temp_pass" class="form-control" 
                      value="<?php echo $temp_pass;?>">
                      <span class="md-line"></span>
                    </div>

                    <div class="input-group">
                      <input type="password" name="password" class="form-control" placeholder="New Password">
                      <span class="md-line"></span>
                    </div>

                    <div class="input-group">
                      <input type="password" name="cpassword" class="form-control" placeholder="Confirm Password">
                      <span class="md-line"></span>
                    </div>
                     
                    
                      <div class="row m-t-30">
                          <div class="col-md-12">
                              <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Submit</button>
                          </div>
                      </div>
                      <hr/>
                      <!-- <div class="row">
                          <div class="col-md-10">
                              <p class="text-inverse text-left m-b-0">Thank you and enjoy our website.</p>
                              <p class="text-inverse text-left"><b>Your Autentification Team</b></p>
                          </div>
                          <div class="col-md-2">
                              <img src="<?php //echo base_url(); ?>admintemplate/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
                          </div>
                      </div> -->
                  </form>
                  </div>
             
              <!-- end of form -->
          </div>
          <!-- Authentication card end -->
      </div>
      <!-- end of col-sm-12 -->
  </div>
  <!-- end of row -->

<!-- end of container-fluid -->
</section>    

