<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
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
        $data['pageTitle']       = $data['pageData'][0]['meta_title'];
        $data['pageDescription'] = $data['pageData'][0]['meta_description'];
		
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		$data['coinTotal']=count($coinMarketData->data);
		
        $this->load->view('home', $data);
    }
    
    /* function for coin detail page */
    public function coin()
    {
        $coin           = $this->uri->segment(2); //get coin name from url
        $url            = 'https://api.coincap.io/v2/assets/' . $coin; // path to your JSON file
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
            $coinMaxSupply[]       = $res->maxSupply;
            $coinUsdVolume[]       = $res->volumeUsd24Hr;
            $coinexplorer[]       = $res->explorer;
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
        $data['coinMaxSupply'] = $coinMaxSupply;
        $data['coinUsdVolume'] = $coinUsdVolume;
        $data['coinexplorer'] = $coinexplorer;
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
        //history data of last 7 days
        $url                           = 'https://api.coincap.io/v2/assets/'.$coin.'/history?interval=d1'; // path to your JSON file
        $results                       = $this->request($url); // put the contents of the file into a variable
        $data['coinHistoryMarketData'] = json_decode($results);
        
        $data['pageTitle']             = $data['coinData']->data->name . ' (' . $data['coinData']->data->symbol . ') Live Price, MarketCap & Info';
        $data['pageDescription']       = 'Live ' . $data['coinData']->data->name . ' prices, market Capitalization, historical data chart, volume & supply. Stay up to date with the latest ' . $data['coinData']->data->name . ' info & markets data. Check our coins stats data to see when there is an opportunity to buy or sell ' . $data['coinData']->data->symbol. ' at best price.';
		$data['coin']       = $coin;
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		
		$rates_url  = 'https://api.coincap.io/v2/rates'; // path to your JSON file
	    $rates_results  = $this->request($rates_url);
        $data['rateData']         = json_decode($rates_results);
        $data['coinListtData'] =$coinMarketData;
		$this->load->view('coin', $data);
    }
    
    //exchange coin market data Added By Ravi
    public function coinmdata()
		{	
		
			$coin=$_GET['coin'];
			$url  = 'https://api.coincap.io/v2/assets/'.$coin.'/markets?limit=2000'; // path to your JSON file
			$api_results  = $this->request($url);
			$coinExchangeMarketData         = json_decode($api_results);
			$no=1;
		
	   foreach($coinExchangeMarketData->data as $res)
        {
            $ex_name=strtolower(str_replace([' ','(',')'],'',$res->exchangeId));
            $ex_code=strtoupper($res->exchangeId);
			$img_src=base_url().'assets/images/exchanges/'.$ex_code.'.png';
			$file_path=FCPATH.'assets/images/exchanges/'.$ex_code.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
          	$row = array();
			$row['Rank'] = $no++;
            $row['Exchange'] = '<img src="'.$img_src.'"><a href="'.base_url().'exchange/'.$ex_name.'"><span class="coin-name">'.$res->exchangeId.'</span></a>';
            $row['Trading Pairs'] = $res->baseSymbol.'/'.$res->quoteSymbol;
            $row['Price'] = '$'.$this->custom_price_format($res->priceUsd);
            $row['Volume 24H'] = '$'.$this->custom_number_format($res->volumeUsd24Hr);
            $row['Volume Total'] =  round($res->volumePercent,2).'%';
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
     
     /* this function used to get all coin list data from API*/
     public function coindata()
	{
		$url = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
		$results = $this->request($url); //call curl function for getting api results
		$coinMarketData = json_decode($results); 
		$no=1;
		foreach($coinMarketData->data as $res)
        {
            $coin_display_name = (strlen($res->name) > 30) ? substr($res->name,0,27).'...' : $res->name;    			
			$coin_name=$res->id;
			$coin_code=strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$res->name));
			$img_src=base_url().'assets/images/shortcoin/'.$coin_code.'.png';
			$file_path=FCPATH.'assets/images/shortcoin/'.$coin_code.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/shortcoin/default.png';
			$row = array();
			$row['#'] = $no++;
            $row['Name'] = '<img src="'.$img_src.'"><a href="'.base_url().'coin/'.$coin_name.'"><span class="coin-name">'.$coin_display_name.'</span></a> <span class="badge badge-warning">'.$res->symbol.'</span>';
			$row['Price'] = '<span class="price">$'.$this->custom_price_format($res->priceUsd).'</span>';
            $row['Market Cap'] = '$'.$this->custom_number_format($res->marketCapUsd);
            $row['Available Supply'] = $this->custom_number_format($res->supply).' '.$res->symbol ;
            $row['Volume 24(H)'] = '$'.$this->custom_number_format($res->volumeUsd24Hr);
			if($res->changePercent24Hr>0)
            $row['Change 24(H)'] = '<span class="p-up"><i class="fa fa-caret-up"></i> '.round($res->changePercent24Hr,2).'%</span>';
			else
			$row['Change 24(H)'] = '<span class="p-down"><i class="fa fa-caret-down"></i> '.round($res->changePercent24Hr,2).'%</span>';	
           // $row['DT_RowId'] = "BTC_".$res->symbol;
		    $row['DT_RowId'] = "BTC_".strtolower($res->name);
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