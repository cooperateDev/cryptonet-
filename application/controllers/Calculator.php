<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller
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
        
        $data['pageTitle']       = 'Cryptocurrency Calculator | '. $data['pageData'][0]['meta_title'] .'';
        $data['pageDescription'] = 'Crypto calculator helps you convert prices between two currencies in real time.';
		
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		
		$rates_url  = 'https://api.coincap.io/v2/rates'; // path to your JSON file
	    $rates_results  = $this->request($rates_url);
        $data['rateData']         = json_decode($rates_results);
		$data['coinListtData'] =$coinMarketData;
        $this->load->view('calculator/index', $data);
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
