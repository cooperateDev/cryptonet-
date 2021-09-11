<?php $this->load->view('include/header'); ?>
<?php setlocale(LC_MONETARY,"en_US"); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"  ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/>
<?php
	function custom_number_format($n, $precision = 2) {
        if ($n < 100000) {
        // Default
         $n_format = number_format($n);
        } else if ($n < 9000000) {
        // Thousand
        $n_format = number_format($n / 1000, $precision). 'K';
        } else if ($n < 900000000) {
        // Million
        $n_format = number_format($n / 1000000, $precision). 'M';
        } else if ($n < 900000000000) {
        // Billion
        $n_format = number_format($n / 1000000000, $precision). 'B';
        } else {
        // Trillion
        $n_format = number_format($n / 1000000000000, $precision). 'T';
    }
			return $n_format;
		}
?>
                <div class="page-title py-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-left">
                                <h1><?php echo $exchangeData->data->name;?> Exchange & Trading Pairs Info</h1>
                                     
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
        <!-- Coin Data  -->
        <?php
			$ex_code=strtoupper($exchangeData->data->name);
			$img_src=base_url().'assets/images/exchanges/'.$ex_code.'.png';
			$file_path=FCPATH.'assets/images/exchanges/'.$ex_code.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
		?>	 
    
        <div class="container">
			<div class="media">
			  <img class="mr-3" src="<?php echo $img_src;?>">
			    <div class="align-self-center media-body">
				  <h2 class="font-weight-bold" style="margin-bottom:0px;"><?php echo $coinData->data->name;?></h2>
 				  <h1 style="margin-bottom:0;"><span id="coin_price">$<?php echo rtrim(number_format($exchangeData->data->volumeUsd,2),00000);?></span> <small class="text-muted">(24H Trading Volume)</small></h1>
				</div>
			</div>

        <div class="pt-3 pb-2">
					<h4><i class="fa fa-eye"></i> Exchange Overview</h4>
					<p><span class="font-weight-bold"><?php echo $exchangeData->data->name;?></span> exchange 24 hours trading volume is <span class="font-weight-bold" id="price_coin">$<?php echo custom_number_format($exchangeData->data->volumeUsd);?></span> with a total volume of <span class="font-weight-bold"><?php echo round ($exchangeData->data->percentTotalVolume,4);?>%</span>. The total number of trading pairs on <span class="font-weight-bold"><?php echo $exchangeData->data->name;?></span> exchange is <span class="font-weight-bold"><?php echo $exchangeData->data->tradingPairs; ?></span> and secured <span class="font-weight-bold">Rank <?php if(isset($exchangeData->data->rank)) echo $exchangeData->data->rank; else echo '(Not Available)';?></span> in the cryptocurrency exchange market.</p>
					<hr>
					<p>Live <span class="font-weight-bold"><?php echo $exchangeData->data->name;?></span> exchange markets data. Stay up to date with the latest crypto trading price movements on <span class="font-weight-bold"><?php echo $exchangeData->data->name;?></span> exchange. Check our exchange market data and see when there is an opportunity to buy or sell <span class="font-weight-bold">cryptocurrency</span> at best price in the market.</p>
				</div>
			
		<div class="row">
			<div class="col-sm">
				<a target = '_blank' href="<?php echo $exchangeData->data->exchangeUrl; ?>" class="btn btn-dark btn-block mb-1"><i class="fa fa-link"></i> Official <?php echo $exchangeData->data->name;?> Website</a>
			</div>
			<div class="col-sm">
			<a target = '_blank' href="<?php echo $settingData[0]['buy_sell'] ?>" class="btn btn-warning btn-block"><i class="fa fa-cart-plus"></i> Start Crypto Trading</a>
			</div>
		</div>
		
		<div class="pt-4 pb-3">
			<div class="card-deck">
				<div class="card text-white bg-success">
					<div class="card-body">
						<h5 class="card-title">Rank</h5>
						<p class="card-text text-white"><?php if(isset($exchangeData->data->rank)) echo $exchangeData->data->rank; else echo '(Not Available)';?></p>
					</div>
				</div>
			<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Exchange Name</h5>
      				<p class="card-text"><?php echo $exchangeData->data->name; ?></p>
    			</div>
			</div>
			<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Trading Pairs</h5>
      				<p class="card-text"><?php echo $exchangeData->data->tradingPairs;?></p>
    			</div>
			</div>
      		<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Volume (24H)</h5>
      				<p class="card-text">$<?php echo custom_number_format($exchangeData->data->volumeUsd);?></p>
    			</div>
			</div>
			      		<div class="card bg-light">
				<div class="card-body">
      				<h5 class="card-title">Volume Total (%)</h5>
      				<p class="card-text"><?php echo round ($exchangeData->data->percentTotalVolume,4);?>%</p>
    			</div>
			</div>

			</div>
		</div>

		<!-- Ad Code Bottom  -->
		<div class="pt-2 pb-4">
		<?php if($ads[0]['pref']==1 || $ads[0]['pref']==2) { ?>
            <div class="container">
               	<div class="row justify-content-center">
					<?php echo  $ads[0]['footer_ads']?>
                </div>    
			</div>
		<?php } ?>
		</div>
		</div>
        <!-- End Ad Code Bottom  -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-left">
        		<div class="pb-5">
        		    <h4 class="py-3"><i class="fa fa-exchange"></i> <?php echo $exchangeData->data->name; ?> Trading Pairs Info</h4>
		<!-- End Coin Data  -->
		<table id="coins-info-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
            <tr>
                <th>Rank</th>
                <th>Currency</th>
                <th>Pair</th>
                <th>Price</th>
                <th>Volume (24H)</th>
                <th>Volume Total (%)</th>
				<th>Trades (24H)</th>
            </tr>
			</thead>
		   </table>        
</div>
</div></div></div>
        <!-- Donation Box  -->
        <?php $this->load->view('include/donation'); ?>
        <!-- End Donation Box  -->


  <script type="text/javascript">
		$(document).ready(function() {
			$.noConflict();
			var table = $('#coins-info-table').dataTable({
				"oLanguage": {
				"sProcessing": "Loading Market Data..."
				},
			"bProcessing": true,
			"sAjaxSource": "<?php echo base_url()?>exchanges/exchangemdata?exchange=<?php echo $exchange?>",
			
			"bPaginate":true,
			"sPaginationType":"full_numbers",
			"iDisplayLength": 25,
			"aoColumns": [
			{ mData: 'Rank' },
			{ mData: 'Currency' },
			{ mData: 'Trading Pairs' },
			{ mData: 'Price' },
			{ mData: 'Volume 24H' },
			{ mData: 'Volume Total' },
			{ mData: 'Trades 24H' }
		]
		});
		} );
	</script>
<?php $this->load->view('include/footer'); ?>