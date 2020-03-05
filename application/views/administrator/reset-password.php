
<section class="login p-fixed d-flex text-center bg-primary common-img-bg">
<!-- Container-fluid starts -->
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">

    <!-- Authentication card start -->
    <div class="login-card card-block auth-body">

         
    	<div class="col-md-10">
        <div class="alert alert-success" role="alert">
          <?php 
            echo validation_errors(); 
            if($this->session->flashdata('message')) {
              echo $this->session->flashdata('message');
            }
          ?>
            
          </div>   
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
                
            </form>
      </div>
       
        <!-- end of form -->
    </div>
    <!-- Authentication card end -->
</div>
<!-- end of col-sm-12 -->
</div>
</div>
<!-- end of row -->

<!-- end of container-fluid -->
</section>    

