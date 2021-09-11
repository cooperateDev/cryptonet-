<?php $this->load->view('include/header'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"  ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<?php setlocale(LC_MONETARY,"en_US"); ?>
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
	function custom_prc_format($n) {
        if ($n > 1) {
        $n_format = number_format($n, 2);
        } else if ($n > 0.1 && $n < 1) {
        $n_format = number_format($n, 3);
        } else if ($n > 0.01 && $n < 0.1) {
        $n_format = number_format($n, 4);
        } else if ($n > 0.001 && $n < 0.01) {
        $n_format = number_format($n, 6);
        } else if ($n > 0.0001 && $n < 0.001) {
        $n_format = number_format($n, 8);
        }
        else {
        $n_format = number_format($n, 10);
    }
			return $n_format;
		}
?>
                <div class="page-title py-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-left">
                                <h1><?php echo $coinData->data->name;?> Live Price Update & Market Capitalization</h1>
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
            $coin_code=$coinData->data->symbol;
			$coin_img=strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$coinData->data->name));
			$img_src=base_url().'assets/images/shortcoin/'.$coin_img.'.png';
			$file_path=FCPATH.'/assets/images/shortcoin/'.$coin_img.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
		?>	 
        <div class="container">
			<div class="media">
			  <img class="mr-3" src="<?php echo $img_src;?>">
			    <div class="align-self-center media-body">
				  <h2 class="font-weight-bold" style="margin-bottom:5px;"><?php echo $coinData->data->name;?> <span class="badge badge-secondary align-middle" style="margin-top:-0.3em;" id="bitcode"><?php echo $coin_code;?></span></h2>
 				  <h1 style="margin-bottom:0;"><span id="coin_price">$<?php echo custom_prc_format($coinData->data->priceUsd); ?></span> <small><span class="p-<?php echo $coinData->data->changePercent24Hr > 0 ? 'up':'down'?>"><i class="fa fa-caret-<?php echo $coinData->data->changePercent24Hr > 0 ? 'up':'down'?>"></i> <?php echo round($coinData->data->changePercent24Hr,2)?>%</span></small></h1>
				</div>
			</div>
				<div class="pt-3 pb-2">
					<h4><i class="fa fa-eye"></i> Market Overview</h4>
					<p><span class="font-weight-bold"><?php echo $coinData->data->name;?></span> current market price is <span class="font-weight-bold" id="price_coin">$<?php echo custom_prc_format($coinData->data->priceUsd);?></span> with a marketcap of <span class="font-weight-bold">$<?php echo custom_number_format($coinData->data->marketCapUsd);?></span>. The total available supply of <span class="font-weight-bold"><?php echo $coinData->data->name;?></span> is <span class="font-weight-bold"><?php echo custom_number_format($coinData->data->supply); ?> <?php echo $coin_code; ?></span> and secured <span class="font-weight-bold">Rank <?php if(isset($coinData->data->rank)) echo $coinData->data->rank; else echo '(Not Available)';?></span> in the cryptocurrency market. <span class="font-weight-bold"><?php echo $coin_code;?></span> price is <i class="fa fa-caret-<?php echo $coinData->data->changePercent24Hr > 0 ? 'up':'down'?>"></i><span class="font-weight-bold"><?php echo round($coinData->data->changePercent24Hr,2);?>%</span> <?php if($coinData->data->changePercent24Hr > 0) echo 'up'; else echo 'down';?> in last 24 hours.</p>
					<hr>
					<p>Live <span class="font-weight-bold"><?php echo $coinData->data->name;?></span> prices from all markets and <span class="font-weight-bold"><?php echo $coin_code;?></span> coin market Capitalization. Stay up to date with the latest <span class="font-weight-bold"><?php echo $coinData->data->name;?></span> price movements. Check our coin stats data and see when there is an opportunity to buy or sell <span class="font-weight-bold"><?php echo $coinData->data->name;?></span> at best price in the market.</p>
				</div>
		<div class="row">
			<div class="col-sm">
				<a target = '_blank' href="<?php echo $settingData[0]['buy_sell'] ?>" class="btn btn-dark btn-block mb-1"><i class="fa fa-cart-plus"></i> Buy / Sell <?php echo $coinData->data->name;?></a>
			</div>
			<div class="col-sm">
			<a target = '_blank' href="<?php echo $coinData->data->explorer; ?>" class="btn btn-warning btn-block"><i class="fa fa-search"></i> <?php echo $coinData->data->name;?> Explorer</a>
			</div>
		</div>
		<div class="pt-4 pb-3">
			<div class="card-deck">
				<div class="card text-white bg-success">
					<div class="card-body">
						<h5 class="card-title">Rank</h5>
						<p class="card-text text-white"><?php if(isset($coinData->data->rank)) echo $coinData->data->rank; else echo '(Not Available)';?></p>
					</div>
				</div>
			<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Market Cap</h5>
      				<p class="card-text">$<?php echo custom_number_format($coinData->data->marketCapUsd);?></p>
    			</div>
			</div>
      		<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Volume (24H)</h5>
      				<p class="card-text">$<?php echo custom_number_format($coinData->data->volumeUsd24Hr);?></p>
    			</div>
			</div>
      		<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Available Supply</h5>
      				<p class="card-text"><?php echo custom_number_format($coinData->data->supply); ?> <?php echo $coinData->data->symbol; ?></p>
    			</div>
			</div>
      		<div class="card bg-light">
				<div class="card-body">
      				<h5 class="card-title">Change (24H)</h5>
      				<p class="card-text"><i class="fa fa-caret-<?php echo $coinData->data->changePercent24Hr > 0 ? 'up':'down'?>"></i> <?php echo round($coinData->data->changePercent24Hr,2);?>% </p>
    			</div>
			</div>
			</div>
		</div>
		
		<!-- Calculator  -->
		 <h4 class="pt-3 pb-2"><i class="fa fa-calculator"></i> Cryptocurrency <?php echo $coinData->data->name;?> Calculator</h4>
		 <div class="container bg-donation pt-4 pb-3 px-4">
   
 <div class="row">
<div class="col-md-6 mb-3">
 <input type="number" class="form-control" id="from_ammount" placeholder="Enter Amount To Convert" value=10 />
 </div>
 <div class="col-md-6">
     <input type="text" class="form-control" id="from_crypto" value="<?php echo $coinData->data->name;?> (<?php echo $coin_code;?>)" disabled/>
     <input type="hidden" class="form-control" id="from_currency" value="<?php echo $coinData->data->priceUsd;?>" />
</div></div>
<div class="row">
<div class="col-md-6">
 <select class="form-control js-example-basic-single" id="to_currency" onchange=calculate();>
<?php foreach ($rateData->data as $res) { ?>
<option value="<?php echo $res->rateUsd; ?>" <?php if ($res->id == 'united-states-dollar') echo "Selected"; ?>><?php echo ucwords(str_replace('-',' ',$res->id)); ?> "<?php if(isset($res->currencySymbol)) echo $res->currencySymbol; else echo 'NA';?>" (<?php echo $res->symbol; ?>)</option>
 <?php } ?>
 </select>
 </div>
 </div>
<h5 class="pt-4 text-center"><div class="col-md-12"><div id="to_ammount"></div></div></h5>
<script type="text/javascript">
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
<script>
const from_currencyEl = document.getElementById('from_currency');
const from_cryptoEl = document.getElementById('from_crypto');
const from_ammountEl = document.getElementById('from_ammount');
const to_currencyEl = document.getElementById('to_currency');
const to_ammountEl = document.getElementById('to_ammount');

from_ammountEl.addEventListener('input', calculate);
to_ammountEl.addEventListener('input', calculate);

function calculate() {
 to_ammountEl.innerText = (from_ammountEl.value) + ' ' + (from_cryptoEl.value) + ' ' + '=' + ' ' + Number((from_ammountEl.value * from_currencyEl.value / to_currencyEl.value).toFixed(2)).toLocaleString() + ' ' + $('#to_currency option:selected').text();
}
calculate();
</script>
        </div>
        <div class="cta-box py-4 mb-3">
<p class="lead text-center mb-2">Want to convert more cryptocurrencies?</p>
   <div class="text-center mb-2"> <a href="<?php echo base_url(); ?>calculator" class="btn btn-outline-dark btn-sm"><i class="fa fa-calculator"></i> Use Crypto Calculator</a> </div>
   </div>
		<!-- Price Chart  -->
			<h4 class="pt-3 pb-2"><i class="fa fa-area-chart"></i> <?php echo $coinData->data->name;?> Historical Data Price Chart</h4>
			
  			<div class="coin-chart" data-coin-period="365day" data-coin-id="<?php echo $coinData->data->id; ?>" data-chart-color="
			<?php if($settingData[0]['site_layout']==1) echo '#FFBA00';else if($settingData[0]['site_layout']==2)   echo '#65bc7b';else if($settingData[0]['site_layout']==3)   echo '#cc0000';else if($settingData[0]['site_layout']==4)   echo '#4d39e9';else  echo '#4fb2aa'; ?>">
				<div class="cmc-wrp"  id="COIN-CHART-<?php echo $coinData->data->id; ?>" style="width:100%; height:100%;" >
				</div>
			</div>
        <!-- End Price Chart  -->
        
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
		</div>
        <!-- End Ad Code Bottom  -->
        
        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-left">
        <div class="pb-5">
            <h4 class="pt-3"><i class="fa fa-exchange"></i> <?php echo $coinData->data->name;?> Markets Exchange Data</h4>
            <p class="lead pb-3">Compare live prices of <?php echo $coinData->data->name;?> on top exchanges.</p>
        	<table id="coins-info-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
            <tr>
                <th>#</th>
                <th>Exchange</th>
                <th>Pair</th>
                <th>Price</th>
                <th>Volume (24H)</th>
                <th>Volume Total (%)</th>
            </tr>
			</thead>
		   </table>
        </div>
        </div></div></div>
		<!-- End Coin Data  -->

        <!-- Donation Box  -->
        <?php $this->load->view('include/donation'); ?>
        <!-- End Donation Box  -->

<!-- Chart Script  -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/amstock.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/none.js"></script>
<script>
(function($) {
    'use strict';
    /* Single Page chart js */
      $('.coin-chart').each(function(index)
        {
            var coinId=$(this).data("coin-id");
            var chart_color=$(this).data("chart-color");
            var coinperiod=$(this).data("coin-period");
            var priceData = [];
            var volData = [];
            var apiUrl = 'https://api.coincap.io/v2/assets/';
            var price_section =$('#coin_price').val();
            //$(this).find('.CCP').number(true); 
             $.ajax({
                    url: 'https://api.coincap.io/v2/assets/'+coinId+'/history?interval=d1',
                    method: 'GET',
                    beforeSend: function() {
                        $(this).closest('.cmc-preloader').show();
                    },
                    success: function(history) {
						
						//var hdata=JSON.parse(history.data);
					  
                     $.each(history.data, function(i, value) {
                          
                            priceData.push( {
                              "date":new Date(value.time),
                              "value":value.priceUsd,
                              //"volume":history.volume[i][1]
                            } ); 
                        });
                    
                    
                        setTimeout(function() {
							generateChartData(coinId,priceData,chart_color);
                            $(this).closest('.cmc-preloader').hide();
                        }, 500);
                    }
                });
        });
var generateChartData = function(coinId,coinData,color) {
var chart = AmCharts.makeChart('COIN-CHART-'+coinId, {
      "type": "stock",
      "theme": "light",
      "hideCredits":true,
      "categoryAxesSettings": {
        "minPeriod": "mm"
      },
      "dataSets": [ {
        "title":"USD",
        "color":color,
        "fieldMappings": [ {
          "fromField": "value",
          "toField": "value"
        }, {
          "fromField": "volume",
          "toField": "volume"
        } ],
        "dataProvider":coinData,
        "categoryField": "date"
      } ],
      "panels": [ {
        "showCategoryAxis": false,
        "title": "Price",
        "percentHeight": 70,
        "stockGraphs": [ {
          "id": "g1",
          "valueField": "value",
          "type": "smoothedLine",
          "lineThickness": 2,
          "bullet": "round",
           "comparable": true,
          "compareField": "value",
          "balloonText": "[[title]]:<b>[[value]]</b>",
          "compareGraphBalloonText": "[[title]]:<b>[[value]]</b>"
        } ],
        "stockLegend": {
          "periodValueTextComparing": "[[percents.value.close]]%",
          "periodValueTextRegular": "[[value.close]]"
        },
         "allLabels": [ {
          "x": 200,
          "y": 115,
          "text": "",
          "align": "center",
          "size": 16
        } ],
      "drawingIconsEnabled": true
      }, {
        "title": "Price",
        "percentHeight": 30,
        "stockGraphs": [ {
          "valueField": "volume",
          "type": "column",
           "showBalloon": false,
          "cornerRadiusTop": 2,
          "fillAlphas": 1
        } ],
        "stockLegend": {
          "periodValueTextRegular": "[[value.close]]"
        },
      } ],
      "chartScrollbarSettings": {
        "graph": "g1",
        "usePeriod": "10mm",
        "position": "bottom"
      },
      "chartCursorSettings": {
        "valueBalloonsEnabled": true,
        "fullWidth": true,
        "cursorAlpha": 0.1,
        "valueLineBalloonEnabled": true,
        "valueLineEnabled": true,
        "valueLineAlpha": 0.5
      },
     "periodSelector": {
        "position": "top",
        "periods": [
        {
          "period": "DD",
          "count": 1,
          "label": "1D"
        },
        {
          "period": "DD",
          "selected": true,
          "count":7,
          "label": "7D"
        },
         {
          "period": "MM",
         "count": 1,
          "label": "1M"
        }, 
      {
          "period": "MM",
          "count": 3,
          "label": "3M"
        },
          {
          "period": "MM",
          "count":6,
          "label": "6M"
        },
        {
          "period": "YY",
          "count": 1,
          "label": "1Y"
        }, {
          "period": "MAX",
          "label": "All"
        } ]
      },
      "export": {
        "enabled": true,
        "position": "top-right"
      }
    } );
    }
})($);
</script>

 <script type="text/javascript">
		$(document).ready(function() {
			$.noConflict();
			var table = $('#coins-info-table').dataTable({
				"oLanguage": {
				"sProcessing": "Loading Market Data..."
				},
			"bProcessing": true,
			"sAjaxSource": "<?php echo base_url()?>home/coinmdata?coin=<?php echo $coin?>",
			"bPaginate":true,
			"sPaginationType":"full_numbers",
			"iDisplayLength": 25,
			"aoColumns": [
			{ mData: 'Rank' },
			{ mData: 'Exchange' },
			{ mData: 'Trading Pairs' },
			{ mData: 'Price' },
			{ mData: 'Volume 24H' },
			{ mData: 'Volume Total' }
			
		]
		});
		} );
	</script>
<?php $this->load->view('include/footer'); ?>