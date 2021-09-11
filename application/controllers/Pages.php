<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('public/home_model');
        //$this->load->library(array('session', 'form_validation'));
    }
    
    /**
     * Display method for this controller.
     * it will display page according to page name
     * like about us, privacy policy etc
    
     */
    
    public function display()
    {
        $seourl                 = $this->uri->segment(2); //get seourl which identify page name
        $url  = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
	   $api_results  = $this->request($url);
       $coinMarketData         = json_decode($api_results);
        $data['coinMarketData'] = $coinMarketData;
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
        $data['pageData']            = $this->home_model->list_data('cms');
        $data['results']             = $this->home_model->page_display_data('cms', $seourl);
        $data['settingData']         = $this->home_model->list_data('settings');
        $data['donations']           = $this->home_model->list_data('donation');
        $data['call2Action']         = $this->home_model->list_data('call2action');
        $data['pageTitle']           = $data['results'][0]['meta_title'];
        $data['pageDescription']     = $data['results'][0]['meta_description'];
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		//end
        $this->load->view('public/page', $data);
    }
    
    /**
     * Contact method for this controller.
     * it will display contact page
     */
    
    
    public function contact()
    {
        $seourl                 = $this->uri->segment(1);
        $url  = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
	   $api_results  = $this->request($url);
       $coinMarketData         = json_decode($api_results);
        $data['coinMarketData'] = $coinMarketData;
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
        $data['pageData']            = $this->home_model->list_data('cms');
        $data['settingData']         = $this->home_model->list_data('settings');
        $data['donations']           = $this->home_model->list_data('donation');
        $data['call2Action']         = $this->home_model->list_data('call2action');
        $data['results']             = $this->home_model->page_data('cms', 4);
        $data['pageTitle']           = $data['results'][0]['meta_title'];
        $data['pageDescription']     = $data['results'][0]['meta_description'];
		//global data 
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		//end
        if ($this->input->post()) {
            //set validation rules
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            //$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_rules('consent_check', 'Consent checkbox', 'required');
            
            //run validation on post data
            if ($this->form_validation->run() == FALSE) { //validation fails
                
                $this->load->view('public/contact', $data);
            } else {
                
                //insert the contact form data into database
                $data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'message' => $this->input->post('message'),
                    'created_date' => date('Y-m-d H:i:s')
                );
                $data = $this->security->xss_clean($data);
                if ($this->db->insert('contact', $data)) {
                    
                    // success
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">We received your message! Will get back to you shortly!!!</div>');
                    redirect('contact-us');
                } else {
                    
                    // error
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
                    redirect('contact-us');
                }
            }
            
        }
        else
        $this->load->view('public/contact', $data);
    }
    
    /**
     * Top gainer coin method for this controller.
     * it have logic for top 5 gainer coin of last 24 hrs
     */
    
    
    public function top_gainer_coins()
    {
        $url  = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
	   $api_results  = $this->request($url);
       $coinMarketData         = json_decode($api_results);
        $data['coinMarketData'] = $coinMarketData;
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
        $data['pageTitle']       = 'Top 50 Crypto Gainers - '.$data['pageData'][0]['meta_title'];
        $data['pageDescription'] = 'Checkout top 50 crypto gainers stats data to see an opportunity to buy or sell coin at best price in the cryptocurrency market.';
		//global data 
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		//end
        $this->load->view('public/top_gainer_coins', $data);
    }
    
    /**
     * Top loser coin method for this controller.
     * it have logic for top 5 loser coin of last 24 hrs
     */
    public function top_loser_coins()
    {
        $url  = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
	   $api_results  = $this->request($url);
       $coinMarketData         = json_decode($api_results);
        $data['coinMarketData'] = $coinMarketData;
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

        $data['pageTitle']       = 'Top 50 Crypto Losers - '.$data['pageData'][0]['meta_title'];
        $data['pageDescription'] = 'Checkout top 50 crypto losers stats data to see an opportunity to buy or sell coin at best price in the cryptocurrency market.';
		//global data 
		$data['totalCap']='$'.$this->custom_number_format(array_sum($coinMkcap));
		$data['coinTotal']=count($coinMarketData->data);
		$data['totalvol']='$'.$this->custom_number_format(array_sum($coinUsdVolume));
		//end
        $this->load->view('public/top_loser_coins', $data);
    }
    
     //curl call function 
    public function request($url)
     {


         $curl = curl_init();

         curl_setopt_array($curl, array(
             CURLOPT_RETURNTRANSFER => 1,
             CURLOPT_URL => $url,
             CURLOPT_USERAGENT => 'Agent'
         ));

         return curl_exec($curl);

         curl_close($curl);

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
}