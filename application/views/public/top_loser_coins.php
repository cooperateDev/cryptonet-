<?php $this->load->view('include/header'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js" ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/> 
<script type="text/javascript">
		$(document).ready(function() {
		$.noConflict();
		$('#coins-info-table').dataTable( {
          "order": [],
          "pageLength": 25,
          "bProcessing": true,
		 "bDeferRender": true,
          
		} );
		} );
	</script>
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
<!-- Page Title  -->
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-left">
        <h1>Top 50 Crypto Losers</h1>
      </div>
    </div>        
  </div>    
</div>
<!-- End Page Title  -->
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
    <div class="alert alert-danger" role="alert">Which crypto coins have lost the most in the last 24 hours? The cryptocurrency list below will be updated in real time and shows you the Top 50 crypto losers for today.</div>
	<div class="row justify-content-center">
		<div class="col-md-12 text-left">
		<div class="py-2">  
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
        <tbody>
			<?php
				$cnt=0;
				setlocale(LC_MONETARY,"en_US");
				if(count($coinMarketData)>0){
				foreach ($coinChange24Sort as $key => $value)
				{
                    if(!empty($value)) {
					if($cnt > 49) continue;
					$coin_name = (strlen($coinName[$key]) > 30) ? substr($coinName[$key],0,27).'...' : $coinName[$key];
					$coin_code=$coinCode[$key];
					$coin_imgcode=strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$coinName[$key]));
					$img_src=$coinImg[$key];
					$file_path=FCPATH.'/assets/images/shortcoin/'.$coin_imgcode.'.png';
				if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
					 ?>
				<tr id="BTC_<?php echo $coin_code;?>">
					<td><?php echo ++$cnt;?></td>
					<td><img src="<?php echo $img_src?>"><a href="<?php echo base_url() ?>coin/<?php echo strtolower(str_replace(' ','-',$coinName[$key])); ?>"><span class="coin-name"><?php echo $coin_name;?></span></a> <span class="badge badge-warning"><?php echo $coin_code;?></span></td>
					<td class="price">$<?php echo custom_prc_format($coinPrice[$key]);?></td>
					<td>$<?php echo custom_number_format($coinMkcap[$key]); ?></td>
					<td><?php echo custom_number_format($coinSupply[$key]); ?> <?php echo $coin_code; ?></td>
					<td>$<?php echo custom_number_format($coinUsdVolume[$key]); ?></td>
					<td class="coin-decrement"><i class="fa fa-caret-down"></i> <?php echo round($coinChange24[$key],2);?>%</td>
				</tr>	
			<?php
		}
		}
		}	
				?>
        </tbody>
    </table>      
		</div>  
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
<?php $this->load->view('include/footer'); ?>