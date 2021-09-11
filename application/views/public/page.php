<?php $this->load->view('include/header'); ?>
<!-- Page Title  -->
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-left">
        <h1>
          <?php echo $results[0]['title'];?>
        </h1>
      </div>
    </div>        
  </div>    
</div>
<!-- End Page Title  -->
<!-- Page Content  -->
<div class="container">
  <div class="py-5">
    <?php echo $results[0]['description'];?>
  </div>
</div>
<!-- End Page Content  -->
<?php $this->load->view('include/footer'); ?>