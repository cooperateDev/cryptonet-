<?php $this->load->view('include/header'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"  ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/>
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
        <h1>
          Top Cryptocurrency Exchanges List Ranked By 24H Trading Volume
        </h1>
        <h6 class="pb-3">
          List of top crypto exchanges platform. The exchange rank is based on 24 hours trading volume. View live cryptourrency exchanges rank, markets data, 24h volume, total volume, trading pairs and info.
        </h6>
                <div class="pb-3">
        <a target = '_blank' href="<?php echo $settingData[0]['buy_sell'] ?>" class="btn btn-outline-dark btn-lg">
            Start Crypto Trading
        </a>
        </div>
      </div>
    </div>        
  </div>    
</div>
<!-- Ad Code Top  -->
  <div class="py-4">
  <?php if($ads[0]['pref']==0 || $ads[0]['pref']==2) { ?>
  <div class="container">
    <div class="row justify-content-center">
       <?php echo  $ads[0]['header_ads']?>
    </div>    
  </div>
  <?php } ?>
  </div>
<!-- End Ad Code Top  -->
<!-- Data Table  -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-left">
			<table id="coins-info-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Pairs</th>
                <th>Volume 24(H)</th>
                <th>Volume (%)</th>
				<th>Official Website</th>
            </tr>
			</thead>
		   </table>        
        </div>        
    </div>    
</div>
<!-- End Data Table  -->
<!-- Ad Code Bottom  -->
	<div class="py-4">
	<?php if($ads[0]['pref']==1 || $ads[0]['pref']==2) { ?>
		<div class="container">
			<div class="row justify-content-center">
				<?php echo  $ads[0]['footer_ads']?>
			</div>    
		</div>
	<?php } ?>
	</div>
<!-- End Ad Code Bottom  -->      
<!-- Donation Box  -->
<?php $this->load->view('include/donation'); ?>
<!-- End Donation Box  -->
       <script type="text/javascript">
		$(document).ready(function() {
			$.noConflict();
			var table = $('#coins-info-table').dataTable({
				"oLanguage": {
				"sProcessing": "Loading Exchanges..."
				},
			"bProcessing": true,
			"sAjaxSource": "<?Php echo base_url()?>exchanges/exchangedata",
			"bPaginate":true,
			"sPaginationType":"full_numbers",
			"iDisplayLength": 25,
			"aoColumns": [
			{ mData: 'Rank' },
			{ mData: 'Name' },
			{ mData: 'Trading Pairs' },
			{ mData: 'Volume 24(H)' },
			{ mData: 'Volume Total' },
			{ mData: 'Exchange URL' }
		]
		});
		} );
	</script>
	
<?php $this->load->view('include/footer'); ?>
