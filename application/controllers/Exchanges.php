<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchanges extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('public/home_model');
        
    }
    
    /**
     * Index Page for this controller.
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     */
    
    public function index()
    {
		
        $url  = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
	    $api_results  = $this->request($url);
        $coinMarketData         = json_decode($api_results);
       
	   //loop listing into coin elements
        setlocale(LC_MONETARY, "en_US");
        foreach ($coinMarketData->data as $res) {
			
            $coinPrice[]           = rtrim(number_format($res->priceUsd,8), 00000);
            $coinName[]            = $res->name;
            $coinCode[]            = $res->symbol;
            $coinChange24[]        = $res->changePercent24Hr;
            $coinChange24Sort[]    = $res->changePercent24Hr;
            $coinChange24DesSort[] = $res->changePercent24Hr;
            $coinMkcap[]           = $res->marketCapUsd;
            $coinSupply[]          = $res->supply;
            $coinUsdVolume[]       = $res->volumeUsd24Hr;
            $coin_img = strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$res->name));
            $coinImg[]             = base_url() . 'assets/images/shortcoin/' . $coin_img . '.png';
			if($res->symbol=='BTC')
			$data['btcCap']='$'.$this->custom_number_format($res->marketCapUsd);
		    if($res->symbol=='ETH')
			$data['ethCap']='$'.$this->custom_number_format($res->marketCapUsd);
        }
        
        $data['coinPrice']     = $coinPrice;
        $data['coinName']      = $coinName;
        $data['coinCode']      = $coinCode;
        $data['coinChange24']  = $coinChange24;
        $data['coinMkcap']     = $coinMkcap;
        $data['coinSupply']    = $coinSupply;
        $data['coinUsdVolume'] = $coinUsdVolume;
        $data['coinImg']       = $coinImg;
        
        //sort coin elements and assign into variable for top gainer and top loser
        arsort($coinChange24DesSort);
        asort($coinChange24Sort);

        $data['coinChange24Sort']    = $coinChange24Sort;
        $data['coinChange24DesSort'] = $coinChange24DesSort;
        
        $data['donations']       = $this->home_model->list_data('donation');
        $data['settingData']     = $this->home_model->list_data('settings');
        $data['pageData']        = $this->home_model->list_data('cms');
        $data['ads']             = $this->home_model->list_data('ads');
        $data['call2Action']     = $this->home_model->list_data('call2action');
        
        $data['pageTitle']       = 'Top Cryptocurrency Exchanges List | '. $data['pageData'][0]['meta_title'] .'';
        $data['pageDescription'] = 'List of top crypto exchanges ranked by 24 hours trading volume. View cryptourrency exchanges market data, info, trading pairs and information.';
		
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));

        $this->load->view('exchanges/index', $data);
    }
    
   	public function exchangedata()
		{	
		
			$url  = 'https://api.coincap.io/v2/exchanges'; // path to your JSON file
			$api_results  = $this->request($url);
			$coinExchangesData         = json_decode($api_results);
     
		$no=1;
	   foreach($coinExchangesData->data as $res)
        {
            $ex_name=$res->exchangeId;
            $ex_code=strtoupper($res->name);
			$img_src=base_url().'assets/images/exchanges/'.$ex_code.'.png';
			$file_path=FCPATH.'assets/images/exchanges/'.$ex_code.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
          	$row = array();
			$row['Rank'] = $no++;
            $row['Name'] = '<img src="'.$img_src.'"><a href="'.base_url().'exchange/'.$ex_name.'"><span class="coin-name">'.$res->name.'</span></a>';
            $row['Trading Pairs'] = $res->tradingPairs;
            $row['Volume 24(H)'] = '$'.$this->custom_number_format($res->volumeUsd);
            $row['Volume Total'] =  round($res->percentTotalVolume,2).'%';
			$row['Exchange URL'] = '<a href="'.$res->exchangeUrl.'">'.$res->exchangeUrl.'</a>';
            $data[] = $row;
		}
		
		$results = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
		echo json_encode($results);
		exit;
    }
  
    /* function for exchange detail page */
    public function detail()
    {
		
		$exchange       = strtolower($this->uri->segment(2)); //
		if($exchange=='zg.com') $exchange='zg';
		if($exchange=='coinbasepro') $exchange='gdax';
		if($exchange=='binance.us') $exchange='binanceus';
		if($exchange=='liquid') $exchange='qryptos';
		if($exchange=='uniswapv2') $exchange='uniswap';
		if($exchange=='c-cex') $exchange='ccex';
        $url            = 'https://api.coincap.io/v2/exchanges/' . $exchange; // path to your JSON file
        $results        = $this->request($url); //call curl function for getting api results
        $url            = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
        $list_results   = $this->request($url); //call curl function for getting api results
        $coinMarketData = json_decode($list_results);
       
	    setlocale(LC_MONETARY, "en_US");
        //loop listing into coin elements
       foreach ($coinMarketData->data as $res) {
			
            $coinPrice[]           = rtrim(number_format($res->priceUsd,8), 00000);
            $coinName[]            = $res->name;
            $coinCode[]            = $res->symbol;
            $coinChange24[]        = $res->changePercent24Hr;
            $coinChange24Sort[]    = $res->changePercent24Hr;
            $coinChange24DesSort[] = $res->changePercent24Hr;
            $coinMkcap[]           = $res->marketCapUsd;
            $coinSupply[]          = $res->supply;
            $coinUsdVolume[]       = $res->volumeUsd24Hr;
            $coin_img = strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$res->name));
            $coinImg[]             = base_url() . 'assets/images/shortcoin/' . $coin_img . '.png';
			if($res->symbol=='BTC')
			$data['btcCap']='$'.$this->custom_number_format($res->marketCapUsd);
		    if($res->symbol=='ETH')
			$data['ethCap']='$'.$this->custom_number_format($res->marketCapUsd);
        }
        $data['coinPrice']     = $coinPrice;
        $data['coinName']      = $coinName;
        $data['coinCode']      = $coinCode;
        $data['coinChange24']  = $coinChange24;
        $data['coinMkcap']     = $coinMkcap;
        $data['coinSupply']    = $coinSupply;
        $data['coinUsdVolume'] = $coinUsdVolume;
        $data['coinImg']       = $coinImg;
        
        //sort coin elements and assign into variable for top gainer and top loser
        arsort($coinChange24DesSort);
        asort($coinChange24Sort);
		
        $data['coinChange24Sort']    = $coinChange24Sort;
        $data['coinChange24DesSort'] = $coinChange24DesSort;
        $data['coinData']              = json_decode($results);
        $data['settingData']           = $this->home_model->list_data('settings');
        $data['pageData']              = $this->home_model->list_data('cms');
        $data['donations']             = $this->home_model->list_data('donation');
        $data['ads']                   = $this->home_model->list_data('ads');
        $data['call2Action']           = $this->home_model->list_data('call2action');
		
		$data['exchangeData'] = json_decode($results);

        $data['pageTitle']             = $data['exchangeData']->data->name . ' Markets, Trade Volume, Pairs & Info';
        $data['pageDescription']       = 'Checkout ' . $data['exchangeData']->data->name . ' 24 hours trading volume & pairs info. Stay up to date with the latest ' . $data['exchangeData']->data->name . ' info. Stay up to date with the latest crypto trading price movements on ' . $data['exchangeData']->data->name. ' platform.';
		$data['exchange']       = $exchange;
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		$this->load->view('exchanges/exchange', $data);
    }
    
    /* End Added By Ravi */
    
    //exchange market data Added By Ravi
    public function exchangemdata()
		{	
		
			$exchange=$_GET['exchange'];
			$url  = 'https://api.coincap.io/v2/markets?exchangeId='.$exchange.'&limit=2000'; // path to your JSON file
			$api_results  = $this->request($url);
			$coinExchangesMData         = json_decode($api_results);
			
		
	   foreach($coinExchangesMData->data as $res)
        {
            $ex_nam=strtolower(str_replace('-',' ',$res->baseId));
            $ex_id=ucwords($ex_nam);
            $coin_code=strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$res->baseId));
			$img_src=base_url().'assets/images/shortcoin/'.$coin_code.'.png';
			$file_path=FCPATH.'assets/images/shortcoin/'.$coin_code.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
          	$row = array();
			$row['Rank'] = $res->rank;
            $row['Currency'] = '<img src="'.$img_src.'"><a href="'.base_url().'coin/'.$res->baseId.'"><span class="coin-name">'.$ex_id.'</span></a>';
            $row['Trading Pairs'] = $res->baseSymbol.'/'.$res->quoteSymbol;
            $row['Price'] = '$'.$this->custom_price_format($res->priceUsd);
            $row['Volume 24H'] = '$'.$this->custom_number_format($res->volumeUsd24Hr);
            $row['Volume Total'] =  round($res->percentExchangeVolume,2).'%';
			$row['Trades 24H'] = $res->tradesCount24Hr;
            $data[] = $row;
		}
		
		$results = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
		echo json_encode($results);
		exit;
    }
    
    //curl call function 
    public function request($url)
     {


        $curl = curl_init();

         curl_setopt_array($curl, array(
		 CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => false,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET",
          ));

        $response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

	if ($err) {
        return "cURL Error #:" . $err;
	} else {
       return $response;
      }

     }
   
	/* this function used to convert price to Trillion/Billion/Million/Thousand */
	public function custom_number_format($n, $precision = 2) {
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
	public function custom_price_format($n) {
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

}
