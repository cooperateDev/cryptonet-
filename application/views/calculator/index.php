<?php $this->load->view('include/header'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
        <h1>
          Cryptocurrency Calculator And Converter Tool
        </h1>
        <h6 class="pb-3">
           Crypto calculator helps you convert prices between two currencies in real time.
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
<!-- Calculator Start  -->
<div class="container">
 <div class="row">
<div class="col-md-6 mb-3">
 <input type="number" class="form-control" id="from_ammount" placeholder="Enter Amount To Convert" value=10 />
 </div></div>

 <div class="row">
 <div class="col-md-6">
 <select class="form-control js-example-basic-single" id="from_currency" onchange=calculate();>
 <?php foreach ($coinListtData->data as $res) { ?>
		<option value="<?php echo $res->priceUsd; ?>"><?php echo $res->name.' ('.$res->symbol.')'; ?></option>
 <?php } ?>
 </select>
</div>

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
const from_ammountEl = document.getElementById('from_ammount');
const to_currencyEl = document.getElementById('to_currency');
const to_ammountEl = document.getElementById('to_ammount');

from_ammountEl.addEventListener('input', calculate);
to_ammountEl.addEventListener('input', calculate);

function calculate() {
 to_ammountEl.innerText = (from_ammountEl.value) + ' ' + $('#from_currency option:selected').text() + ' ' + '=' + ' ' + Number((from_ammountEl.value * from_currencyEl.value / to_currencyEl.value).toFixed(2)).toLocaleString() + ' ' + $('#to_currency option:selected').text();
}
calculate();
</script>

        </div>        
<!-- Calculator End  -->
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
	
<?php $this->load->view('include/footer'); ?>