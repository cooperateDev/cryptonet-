<!DOCTYPE>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $pageDescription;?>">
    <meta name="author" content="">
    <!-- google verify code if any -->
    <?php if(!empty($settingData[0]['google_verify']) && (strpos($settingData[0]['google_verify'], '<meta') !== false)) { 	echo $settingData[0]['google_verify']; } ?>
    <!-- bing verify code if any -->
	<?php if(!empty($settingData[0]['bing_verify'])  && (strpos($settingData[0]['bing_verify'], '<meta') !== false)) { 	echo $settingData[0]['bing_verify']; } ?>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>upload/<?php echo $settingData[0]['fevicon']?>">
    <title><?php echo $pageTitle;?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/front/bootstrap.min.css">
	<?php if($settingData[0]['site_layout']==1) { ?> 
        <link href="<?php echo base_url(); ?>assets/css/front/style-yellow.css" rel="stylesheet">
	<?php } else if($settingData[0]['site_layout']==2) { ?>
	    <link href="<?php echo base_url(); ?>assets/css/front/style-lightgreen.css" rel="stylesheet">
	<?php }  else if($settingData[0]['site_layout']==3) { ?>
	    <link href="<?php echo base_url(); ?>assets/css/front/style-red.css" rel="stylesheet">
	<?php }  else if($settingData[0]['site_layout']==4) { ?>
		<link href="<?php echo base_url(); ?>assets/css/front/style-navy.css" rel="stylesheet">
	<?php }  else { ?>
	    <link href="<?php echo base_url(); ?>assets/css/front/style-cyan.css" rel="stylesheet">
	<?php } ?>
    <script  type="text/javascript" src="<?php echo base_url(); ?>assets/js/front/jquery-1.12.4.js" > </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- google analytic code if any -->
<?php if(!empty($settingData[0]['google_analytic']) && (strpos($settingData[0]['google_analytic'], '<script>') !== false) && (strpos($settingData[0]['google_analytic'], '</script>') !== false)) { 	echo $settingData[0]['google_analytic'];  } ?>
<?php if(!empty($settingData[0]['custom_css'])) { 	echo '<style>'. $settingData[0]['custom_css'] .'</style>';  } ?>
</head>
<body class="">
	<?php if($settingData[0]['header_top']==1) { ?> 
	<div class="preheader">
	<div class="container">
	<div class="row ptop">
    <div class="col">
	<h6>Cryptocurrencies <small class="text-top-small"><?php echo $coinTotal;?></small> BTC Market Cap<small class="text-top-small"> <?php echo $btcCap;?></small></h6>
  </div>
    <div class="col text-right">
	<h6>Total Market Cap <small class="text-top-small"><?php echo $totalCap;?></small> Total Volume (24h)<small class="text-top-small"> <?php echo $totalvol;?></small></h6>
	</div>
</div></div></div>
	<?php } ?>
	<div class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg h2-nav">
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>upload/<?php echo $settingData[0]['logo']  ?>" alt="logo" /></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header1" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                       <span class="ti-menu">&#9776;</span>
                    </button>
                        <div class="collapse navbar-collapse" id="header1">
                            <ul class="navbar-nav ml-auto">
                             <!-- 	<li class="nav-item active"><a class="nav-link" href="<?php echo base_url(); ?>">Home</a></li> -->
                              	<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>">Coins</a></li>
                              	<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>exchanges">Exchanges</a></li>
								<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>top-gainer-coins">Top Gainers</a></li>	
                              	<!--<?php if($pageData[2]['active']==1) { ?>
                              	<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>pages/<?php echo $pageData[2]['seo_url']?>"><?php echo $pageData[2]['title']?></a></li>
                              	<?php } ?> -->
                              	 <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>top-loser-coins">Top Losers</a></li>
                              	 <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>calculator">Calculator</a></li>
                              	<?php if($pageData[3]['active']==1) { ?>
                              	<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>contact-us"><?php echo $pageData[2]['title']?></a></li>
                              	<?php } ?>
                                <li class="nav-item last"><a target = '_blank' class="btn btn-outline-info" href="<?php echo $settingData[0]['buy_sell'] ?>">BUY / SELL</a></li>
                            </ul>
                        </div>
            </nav>
        </div>
    </div>