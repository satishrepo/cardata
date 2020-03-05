<!-- jquery file upload Frame work -->
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/lightbox2/dist/css/lightbox.min.css">



<div class="page-header">
<div class="page-header-title">
    <h4>Dealers</h4>
</div>
<div class="page-header-breadcrumb">
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="index-2.html">
                <i class="icofont icofont-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Dealers</a></li>
        <li class="breadcrumb-item"><a href="#!">Update Dealers</a></li>
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
    <h5><?php echo $carData['id'] ? 'Dealers Update' : 'Dealers Add' ?></h5>
</div>
<div class="card-block">
    <div class="row">
        <div class="col-sm-12">
         <?php echo form_open_multipart("administrator/update_dealers/".$carData['id']); ?>
         <input class="form-control" value="<?php echo $carData['id']; ?>" name="id" type="hidden">
            <div class="product-edit">
                <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="">
                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" placeholder="name" type="text" value="<?php echo $carData['name']; ?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Code</label>
                        <input class="form-control" name="code" placeholder="code" type="text" value="<?php echo $carData['code']; ?>">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                     
                    </div>
                    <div class="col-sm-6">
                       <div class="checkbox-fade fade-in-primary checkbox">
                    <label>
                      <br>
                      <input <?php echo $carData['status'] == '1' ? "checked": '';?> type="checkbox" name="status" class="form-control" id="status_checkbox">
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
    
</div>


<script>
  $(function () {

    $("#status_checkbox").click(function() {
      var text = ($(this).is(":checked") ? 'Active' : 'Inactive')
      $("#status_text").text(text);
      // $(this).val(($(this).is(":checked") ? '1' : '0'))
      // alert($(this).val())
    });

  });
</script>