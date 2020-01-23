    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/ekko-lightbox/dist/ekko-lightbox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/lightbox2/dist/css/lightbox.css">

<script type="text/javascript">
 $(document).ready(function(){

    function callData() {
        var dealer = 'Volkswagen of Beaumont';
        $.get('http://localhost/carshop/api/get?page=1&pagesize=5order=desc&dealer='+dealer, function(res){
            var result = JSON.parse(res);
            $("#content-div").html(result.data);        
        });


        $(document).on("click",".color-row",function() {
            var link = $(this).attr("link");
            window.open(link, "_blank"); 
        })
    }
    callData();
});


</script>

<style>
    .color-row { border-radius: 10px; cursor: pointer;}
</style>


<div class="page-header">
    <div class="page-header-title">
        <h4>List Cars</h4>
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
            <li class="breadcrumb-item"><a href="#!">List Cars</a>
            </li>
        </ul>
    </div>
</div>
           
            <!-- Page-header end -->
            <!-- Page-body start -->
<div class="page-body">
    <!-- DOM/Jquery table start -->

    <div class="card">
        <div class="card-block">
            <div class="table-responsive dt-responsive" id="content-div">
                
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->
</div>

  