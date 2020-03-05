<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/pages/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/ekko-lightbox/dist/ekko-lightbox.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/lightbox2/dist/css/lightbox.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/css/style.css">

<div class="page-header">
    <div class="page-header-title">
        <h4>List Cars</h4>
    </div>
    
</div>
           
            <!-- Page-header end -->
            <!-- Page-body start -->
<div class="page-body">
    <!-- DOM/Jquery table start -->

    <div class="card">
        <div class="card-block">
            <div class="table-responsive dt-responsive">
                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Service Dealer</th>
                            <th>Service Title</th>
                            <th width="10px">Service URL</th>
                            <th>Service Date</th>
                            <th>Service Image</th>
                            <!-- <th>service Blurb</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($products as $post) : ?>
                     <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><a href="<?php echo base_url(); ?>administrator/cars/update/<?php echo $post['id']; ?>"><?php echo $post['dealer']; ?></a></td>
                            <td><?php echo $post['title']; ?></td>
                            <td><?php echo $post['url']; ?></td>
                            <td><?php echo date("M d,Y", strtotime($post['date'])); ?></td>
                            
                            <td><img src="<?php echo $post['image']; ?>" height="50px"></td>
                            <!-- <td><?php //echo $post['blurb']; ?></td> -->
                            <td>
                                <?php if($post['status'] == 1){ ?>
                               <a class="label label-inverse-primary enable" href='<?php echo base_url(); ?>users/enable/<?php echo $post['id']; ?>?table=<?php echo base64_encode('cars'); ?>'>Enabled</a>
                                <?php }else{ ?> 
                                <a class="label label-inverse-warning desable" href='<?php echo base_url(); ?>users/desable/<?php echo $post['id']; ?>?table=<?php echo base64_encode('cars'); ?>'>Disabled</a>
                                <?php } ?>
                                <a class="label label-inverse-info" href='<?php echo base_url(); ?>users/cars/update/<?php echo $post['id']; ?>'>Edit</a>
                                <a class="label label-inverse-danger delete" href='<?php echo base_url(); ?>administrator/delete/<?php echo $post['id']; ?>?table=<?php echo base64_encode('cars'); ?>'>Delete</a>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- <div class="paginate-link">
                        <?php //echo $this->pagination->create_links(); ?>
                    </div>  -->

                     </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->
</div>

  
<script type="text/javascript">
 $(document).ready(function(){
        $(".delete").click(function(e){
            if(!confirm('Are you sure you want delete this record ?')) {
                e.preventDefault();
            }
        });

    $('#dom-jqry').DataTable( {
        autoWidth: false, 
        columnDefs: [
            { width: '80px', targets: 0 }
        ],
        order: [[0, 'desc']]
        // fixedColumns: true
    });

});


</script>

 <script src="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/assets/pages/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>admintemplate/assets/pages/data-table/js/data-table-custom.js"></script>