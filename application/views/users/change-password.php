
<!-- Page header end -->
<!-- Page body start -->
<div class="page-body">
<div class="row">
    <div class="col-sm-12">
        <!-- Product edit card start -->
        <div class="card">
           <?php 
            echo validation_errors(); 
            if ($this->session->flashdata('success') != ''): 
              echo $this->session->flashdata('success'); 
            endif;
           ?>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-12">
                            <div class="col-sm-8">
               <?php echo form_open_multipart('users/change-password'); ?>
                    
                    <!-- <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" disabled="" value="<?php //echo $this->session->userdata('email'); ?>" class="form-control">
                        </div>
                        <div id="password_error" style="font-size:12px;"></div>  
                    </div> -->

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Current Password</label>
                        <div class="col-sm-8">
                            <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password">
                        </div>
                        <div id="password_error" style="font-size:12px;"></div>  
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">New Password</label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" name="new_password" id="new_password" class="form-control" placeholder="New Password">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Confirm New Password</label>
                        <div class="col-sm-8">
                            <input type="password" id="confirm_new_password" onkeyup="checkPass(); return false;" name="confirm_new_password" class="form-control" placeholder="Confirm New Password">
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <textarea id="description" style="visibility: hidden;"></textarea>
                    
                </form>
               </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product edit card end -->
    
</div>
        <!-- Basic Form Inputs card end -->


<script type="text/javascript">
function checkPass()
{ 
    //Store the password field objects into variables ...
    var new_password = document.getElementById('new_password');
    var pass2 = document.getElementById('confirm_new_password');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "rgb(46,204,113)";
    var badColor = "rgb(231,76,60)";
    if(new_password.value == confirm_new_password.value){
        confirm_new_password.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
    }else{
        confirm_new_password.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
} 
 
</script>  
           