<!-- jquery file upload Frame work -->
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />



<div class="page-header">
<div class="page-header-title">
<h4>Import CSV</h4>
</div>
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="index-2.html">
<i class="icofont icofont-home"></i>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Import</a>
</li>
<li class="breadcrumb-item"><a href="#!">CSV</a>
</li>
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
<h5>Import From CSV</h5>
</div>
<div class="card-block">
<div class="row">
<div class="col-sm-12">
<?php echo form_open_multipart('administrator/import'); ?>
<div class="product-edit">
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="">
            
            <!-- <div class="row">
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icofont icofont-all-caps"></i></span>
                        <input class="form-control" name="size" placeholder="Size" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icofont icofont-underline"></i></span>
                        <input class="form-control" name="tag" placeholder="Product Tag" type="text">
                    </div>
                </div>
            </div>
            -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icofont icofont-clip"></i></span>
                        <input name="userfile" class="form-control" type="file">
                   </div>
                </div>
                <!--
                <div class="col-sm-6">
                   <div class="checkbox-fade fade-in-primary checkbox">
                        <label>
                            <input value="1" type="checkbox" name="status" class="form-control" checked="">
                            <span class="cr"><i class="cr-icon icofont icofont-verification-check txt-primary"></i></span>
                            Change Status Of The Product
                        </label>
                    </div>
                </div>
                -->
            </div>
             

            

             <div class="form-group">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit
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




