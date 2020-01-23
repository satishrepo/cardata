<!-- jquery file upload Frame work -->
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>admintemplate/bower_components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/lightbox2/dist/css/lightbox.min.css">



<div class="page-header">
    <div class="page-header-title">
        <h4>Cars</h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="index-2.html">
                    <i class="icofont icofont-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">Cars</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">Update Cars</a>
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
        <h5>Car Update</h5>
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
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                <input class="form-control" value="<?php echo $carData['dealer']; ?>" name="dealer" placeholder="Service Dealer" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-man-in-glasses"></i></span>
                                <input class="form-control" name="title" placeholder="tile" type="text" value="<?php echo $carData['title']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-ui-note"></i></span>
                                <input class="form-control" name="url" placeholder="URL" type="text" value="<?php echo $carData['url']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-cur-dollar"></i></span>
                                <input class="form-control" name="date" placeholder="Date" type="text" value="<?php echo $carData['date']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-numbered"></i></span>
                                <img src="<?php echo $carData['image']?>" height="100px">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-align-left"></i></span>
                                <!-- <input class="form-control" name="blurb" placeholder="Blurb" type="text" value="<?php //echo $carData['blurb']; ?>"> -->
                                <textarea name="blurb" cols="65" rows="5"><?php echo $carData['blurb']; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-clip"></i></span>
                                    <input name="userfile" class="form-control" type="file">
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-2">
                            <div class="input-group">
                               <img src="<?php //echo site_url();?>assets/images/products/<?php //echo $carData['image']; ?>" width="50px">
                            </div>
                        </div> -->
                        <div class="col-sm-6">
                           <div class="checkbox-fade fade-in-primary checkbox">
                        <label>
                            <input value="1"  <?php echo $carData['status'] == '1' ? "checked": '';?> type="checkbox" name="status" class="form-control">
                            <span class="cr"><i class="cr-icon icofont icofont-verification-check txt-primary"></i></span>
                           Change Status
                        </label>
                        </div>
                        </div>
                    </div>
                     
                     <div class="form-group">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update
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
 



