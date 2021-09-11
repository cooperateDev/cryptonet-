<!-- footer -->
<!-- Call-to-Action  -->
<?php
	function custom_price_format($n) {
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
        $n_format = number_format($n, 8);
    }
			return $n_format;
		}
?>
<div class="cta-box py-4">
  <div class="container">
    <div class="d-flex">
      <div class="cta-text">
        <?php echo $call2Action[0]['description'] ?>
      </div>
      <div class="btn-cta">
        <a target = '_blank' href="<?php echo $call2Action[0]['link'] ?>" class="btn btn-outline-dark btn-md">
          <?php echo $call2Action[0]['title'] ?>
        </a>
      </div>
    </div>
  </div>
</div>
<!-- End Call-to-Action  -->
<div class="footer py-5">
    <div class="container">
        <div class="row">
			<div class="col-sm">
				<h5>Top 5 Gainer Coins</h5>
					<?php $i=0; foreach ($coinChange24DesSort as $key => $value)
                        {
							if($i>4)   continue; ?>
                        <ul>
							<li><span class="coin-code"><a href="<?php echo base_url() ?>coin/<?php echo strtolower(str_replace(' ','-',$coinName[$key])); ?>"><?php echo $coinCode[$key];?></a></span>$<?php echo custom_price_format(str_replace(',','',$coinPrice[$key])); ?> <span class="change-g"><?php echo round($coinChange24[$key],2);?>%</span></li>
						</ul>
                    <?php ++$i;} ?>
			</div>
			<div class="col-sm">
				<h5>Top 5 Rank Coins</h5>
					<?php for($i=0;$i<5;$i++) { ?>
                      <ul>
						<li><span class="coin-code"><a href="<?php echo base_url() ?>coin/<?php echo strtolower(str_replace(' ','-',$coinName[$i])); ?>"><?php echo $coinCode[$i];?></a></span>$<?php echo custom_price_format(str_replace(',','',$coinPrice[$i])); ?>
                      <span <?php if($coinChange24[$i] > 0) echo 'class="change-g"'; else echo 'class="change-l"';  ?>> <?php echo round($coinChange24[$i],2);?>%</span></li>
					  </ul>
                    <?php } ?>
			</div>
			<div class="col-sm">
				<h5>Top 5 Loser Coins</h5>
					<?php 
                         $i=0;
                          foreach ($coinChange24Sort as $key => $value)
								{
								    
                                    if(!empty($value)) {
									if($i>4)   continue; ?>
                         
                        <ul>
							<li><span class="coin-code"><a href="<?php echo base_url() ?>coin/<?php echo strtolower(str_replace(' ','-',$coinName[$key])); ?>"><?php echo $coinCode[$key];?> </a></span>$<?php echo custom_price_format(str_replace(',','',$coinPrice[$key])); ?> <span class="change-l"><?php echo round($coinChange24[$key],2);?>%</span></li>
						</ul>
                    <?php ++$i;}} ?>
			</div>
		</div>
                <div class="copyright-nav">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <?php echo $settingData[0]['copyright'] ?>
                                <div class="f-nav ml-auto">
                                    <?php if($pageData[1]['active'] ==1) {?>
                                    <a href="<?php echo base_url(); ?>pages/<?php echo $pageData[1]['seo_url']?>" class="p-10 p-l-0"><?php echo $pageData[1]['title']?></a> -&nbsp;  
                                    <?php } ?>
									<?php if($pageData[3]['active'] ==1) {?>
                                    <a href="<?php echo base_url(); ?>pages/<?php echo $pageData[3]['seo_url']?>" class="p-10"><?php echo $pageData[3]['title']?></a> -  
                                    <?php } ?>
                                    <?php if($pageData[4]['active'] ==1) {?>
                                    <a href="<?php echo base_url(); ?>pages/<?php echo $pageData[4]['seo_url']?>" class="p-10"> <?php echo $pageData[4]['title']?></a> -  
                                    <?php } ?>
                                    <?php if($pageData[5]['active'] ==1) {?>
                                    <a href="<?php echo base_url(); ?>pages/<?php echo $pageData[5]['seo_url']?>" class="p-10"> <?php echo $pageData[5]['title']?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
<!-- End footer -->
<!-- Footer Ticker -->
<?php if($settingData[0]['ticker']==1) { ?> 
<div class="ticker-bottom">
	<div class="ticker">

		
	<?php 
	for($j=0;$j<25;$j++)
				{ 	
				    $coin_imgcode=strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$coinName[$j]));
					$img_src=$coinImg[$j];
					$file_path=FCPATH.'/assets/images/shortcoin/'.$coin_imgcode.'.png';
					if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
	?>
<div class="ticker__item"><img src="<?php echo $img_src?>" /> <span><a href="<?php echo base_url() ?>coin/<?php echo strtolower(str_replace(' ','-',$coinName[$j])); ?>"><?php echo $coinCode[$j];?></a></span> <div class="cmlp-price">$<?php echo custom_price_format(str_replace(',','',$coinPrice[$j])); ?></div> <span><i class="fa fa-caret-<?php echo $coinChange24[$j] > 0 ? 'up':'down'?>"></i> <?php echo round($coinChange24[$j],2);?>%</span></div>
	<?php } ?>
	</div>
</div>
<?php } ?>
<!-- End Footer Ticker -->
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/front/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/front/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" crossorigin="anonymous" ></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<?php if($settingData[0]['header_gdpr'] ==1) {?>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#ffffff",
      "text": "#18191a"
    },
    "button": {
      "background": "#ffc107",
      "text": "#18191a"
    }
  },
  "position": "top",
  "static": true,
  "content": {
    "message": "Our website uses cookies to make your browsing experience better. By using our site you agree to our use of cookies.",
    "dismiss": "I CONSENT",
    "link": "Learn More",
    "href": "<?php echo base_url(); ?>pages/privacy-policy"
  }
})});
</script>
<?php } ?>
</body>
