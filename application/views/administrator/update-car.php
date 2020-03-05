<!-- jquery file upload Frame work -->
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/lightbox2/dist/css/lightbox.min.css">



<div class="page-header">
<div class="page-header-title">
    <h4>Model</h4>
</div>
<div class="page-header-breadcrumb">
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="index-2.html">
                <i class="icofont icofont-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Model</a></li>
        <li class="breadcrumb-item"><a href="#!">Update Model</a></li>
    </ul>
</div>
</div>
<!-- Page header end -->
<!-- Page body start -->
<div class="page-body">
<div class="row">
    <div class="col-sm-12">
        <!-- Product edit card start -->
<div class="card">
<div class="card-header">
    <h5><?php echo $carData['id'] ? 'Model Update' : 'Model Add' ?></h5>
</div>
<div class="card-block">
    <div class="row">
        <div class="col-sm-12">
         <?php echo form_open_multipart("administrator/update_cars/".$carData['id']); ?>
         <input class="form-control" value="<?php echo $carData['id']; ?>" name="id" type="hidden">
            <div class="product-edit">
                <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="">
                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label>Dealer</label>
                          <!-- <span class="form-group-addon"><i class="icofont icofont-ui-user"></i></span> -->
                        <!-- <input class="form-control" value="<?php //echo $carData['dealer']; ?>" name="dealer" placeholder="Service Dealer" type="text"> -->

                        <select name="dealer" class="form-control" style="height:34px!important">
                          <?php 
                          foreach($dealers as $dlr)
                          {
                            echo "<option value='".$dlr['id']."' ".($carData['dealer'] == $dlr['id'] ? 'selected' : '')." >".$dlr['name']."</option>";
                          }
                          ?>
                        </select>

                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                          <!-- <span class="form-group-addon"><i class="icofont icofont-man-in-glasses"></i></span> -->
                          <label>Title</label>
                          <input class="form-control" name="title" placeholder="title" type="text" value="<?php echo $carData['title']; ?>">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                          <!-- <span class="form-group-addon"><i class="icofont icofont-ui-note"></i></span> -->
                          <label>URL</label>
                          <input class="form-control" name="url" placeholder="URL" type="text" value="<?php echo $carData['url']; ?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <!-- <span class="form-group-addon"><i class="icofont icofont-cur-dollar"></i></span> -->
                            <!-- <input class="form-control" name="date" placeholder="Date" type="text" value="<?php //echo $carData['date']; ?>"> -->

                            <label>Date</label>
                            <div class='input-group date' id='datetimepicker1'>
                              <input type='text' class="form-control" value="<?php echo $carData['date']; ?>" name="date" />
                              <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <!-- <span class="form-group-addon"><i class="icofont icofont-cur-dollar"></i></span> -->
                        <label>Image Url</label>
                        <input class="form-control" name="image" placeholder="Image" type="text" value="<?php echo $carData['image']; ?>" id="image">
                        <br/>
                        <span class="form-group-addon"><i class="icofont icofont-numbered"></i></span>
                        <img src="<?php echo $carData['image']?>" height="100px" id="image_preview" alt="<?php echo $carData['image']?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Blurb</label>
                            <textarea name="blurb" cols="65" rows="5"><?php echo $carData['blurb']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Category</label>
                         <select name="category" class="form-control" style="height:34px!important">
                          <?php 
                          foreach($category as $dlr)
                          {
                            echo "<option value='".$dlr['id']."' ".($carData['category'] == $dlr['id'] ? 'selected' : '')." >".$dlr['name']."</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="checkbox-fade fade-in-primary checkbox">
                    <label>
                      <br>
                      <input value="1"  <?php echo $carData['status'] == '1' ? "checked": '';?> type="checkbox" name="status" class="form-control" id="status_checkbox">
                      <span class="cr"><i class="cr-icon icofont icofont-verification-check txt-primary"></i></span>
                     <span id="status_text"><?php echo $carData['status'] == '1' ? "Active": 'Inactive';?></span>
                    </label>
                    </div>
                    </div>
                </div>
                 
                 <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <?php echo $carData['id'] ? 'Update' : 'Add' ?>
                    </button>
                </div>

            </div>
        </div>
       
    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
        <!-- Product edit card end -->
    
</div>
        <!-- Basic Form Inputs card end -->


<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


<script>
  $(function () {

    $("#status_checkbox").click(function() {
      var text = ($(this).is(":checked") ? 'Active' : 'Inactive')
      $("#status_text").text(text);
    });

    $("#image").blur(function() {
      var text = $(this).val();
      $("#image_preview").attr("src", text);
    });

    $('#datetimepicker1').datetimepicker({
      format: 'YYYY/MM/DD' //;// 'DD/MM/YYYY'
    });
  });
</script>
