<?php $this->load->view('include/header'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js" ></script>
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
          <?php echo $pageData[0]['home_title']?>
        </h1>
        <h6 class="pb-2">
          <?php echo $pageData[0]['description']?>
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
                <th>Price</th>
                <th>Market Cap</th>
                <th>Available Supply</th>
                <th>Volume (24H)</th>
                <th>Change (24H)</th>
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
				"sProcessing": "Loading Coins..."
				},
			"bProcessing": true,
			"sAjaxSource": "<?Php echo base_url()?>home/coindata",
			"bPaginate":true,
			"sPaginationType":"full_numbers",
			"iDisplayLength": 25,
			"aoColumns": [
			{ mData: '#' },
			{ mData: 'Name' },
			{ mData: 'Price' },
			{ mData: 'Market Cap' } ,
			{ mData: 'Available Supply' },
			{ mData: 'Volume 24(H)' },
		{ mData: 'Change 24(H)' }
		]
		});
		} );
	</script>

<script type="text/javascript">
		var formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'USD',
			minimumFractionDigits: 3,
		});
		const pricesWs=new WebSocket('wss://ws.coincap.io/prices?assets=ALL');
		pricesWs.onmessage=function(msg){
		var sdata=JSON.parse(msg.data);
		for(var indexkey in sdata){
			
			if(sdata.hasOwnProperty(indexkey)){
			var coin = 'BTC_' + indexkey;	
			var _coinTable = $('#coins-info-table');
            var row = _coinTable.find("tr#" + coin);
            price = _coinTable.find("tr#" + coin + " .price");
            _price = formatter.format(sdata[indexkey]);
            var c = _price.substr(_price.length-5);
            if(c=='00000')
			_price=_price.substr(0, _price.length-5);
             previous_price = $(price).data('usd');
              $(price).html(_price);
            _class = previous_price < _price  ? 'increment' : 'decrement';
            if (_price >= previous_price) {
                $(price).html(_price).removeClass().addClass(_class + ' price').data("usd", _price);
            } else {
                $(price).html(_price).removeClass().addClass(_class + ' price').data("usd", _price);
            }
             if (_price !== previous_price) {
                _class = previous_price < _price ? 'increment' : 'decrement';
                $(row).addClass(_class);
                setTimeout(function () {
                    $(row).removeClass('increment decrement');
                }, 300);
            }
             
            } 
             
		}}
		</script>
<?php $this->load->view('include/footer'); ?>
