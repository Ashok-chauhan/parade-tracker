<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
    var $protocol = '';
    
    function __construct(){
		parent::__construct();
       // $this->is_logged_in();
		$this->load->model('Parade_model');
        $this->load->model('Route_model');
		//$this->load->helper('url');
		$this->protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        date_default_timezone_set('America/Chicago');
	}
    
    public function parade(){
//         if(isset($_GET['parade_id'])){
//           $parade_id = filter_var($_GET['parade_id'], FILTER_VALIDATE_INT);
//        }else{
//            $parade_id='';
//        }

        $parade_id = filter_var($this->uri->segment(3), FILTER_VALIDATE_INT);
        $data = $this->Parade_model->api($parade_id);
        $configData = $this->Parade_model->getConfig($parade_id);
        if(!$configData)            $configData = $this->Parade_model->getConfig();
        $config = array();
        $config['weather_url'] = $configData['weather_url'];
        $config['zipcode'] = $configData['zipcode'];
        $config['banner_ad'] = $configData['dfp_ad_unit'];
        $config['googleAnalyticsNewApID'] = $configData['google_analytics'];
        $config['about_text'] = $configData['about_text'];
        $config['paradecurrentlocation_interval'] = $configData['location_interval'];
        $config['paradecurrentlocation_url'] = $configData['location_url'];
        $config['home_screen_ad'] = $configData['home_screen'];
        $config['schedule_screen_ad'] = $configData['schedule_screen'];
        $config['contact_email'] = 'web@wdsu.com';
        
        

        $parade = array();
        //print '<pre>';
        //print_r($data);
        if($data){
           
            foreach ($data as $key => $value){
                //print_r($value);
                $parade[$key]['id'] = (int)$value['id'];
                $parade[$key]['name'] = $value['name'];
                $parade[$key]['area'] = $value['area'];
                $parade[$key]['date'] = date('m/d/Y',$value['date']);
                $parade[$key]['start_time'] = date('H:i ',$value['start_time']).$value['am_pm'];
                $parade[$key]['image'] = $this->protocol.'://'.$_SERVER['HTTP_HOST'].'/parade/assets/'.$value['image'];
               
                if($parade_id){
                $parade[$key]['kml'] = $this->protocol.'://'.$_SERVER['HTTP_HOST'].'/parade/kml/kmlfile/'.$value['route_id'].'/'.$this->uri->segment(4);
                }else{
                   $parade[$key]['kml'] = $this->protocol.'://'.$_SERVER['HTTP_HOST'].'/parade/kml/kmlfile/'.$value['route_id'];
                }
                $parade[$key]['floats'] = (int)$value['floats'];
                $parade[$key]['banner_ad'] = $value['banner'];
                //$parade[$key]['floats'] = '5';
            }
            
        }
      
        
       //$parade['parades'] = $parade;
        $response['parades'] = $parade;
        $response['config'] = $config;
       header('Content-type: application/json; charset=UTF-8');
		header('Content-Language: en');
		echo json_encode($response);
		
        exit;
        
    }
    
    public function coordinate(){
     $activeParade = $this->Route_model->getParade($this->uri->segment(3));
     $response = array();
          
     //if( $this->uri->segment(3)=== $activeParade[0]['id'] ){
     if( isset($activeParade[0]) ){
     
         $currentLocation = $this->Route_model->currentLocation($activeParade[0]['route_id']);
        
         $response['lat']       = $currentLocation['latitude'];
         $response['lon']       = $currentLocation['longitude'];
         $response['label']     = $currentLocation['intersection'];
         $response['parade_id'] = $this->uri->segment(3);
         $response['route_id']  = $currentLocation['route_id'];
         $response['status']    = (isset($currentLocation['status']))? 'active' : 'inactive' ;
     }else{
         return FALSE;
     }
     
    	header('Content-type: application/json; charset=UTF-8');
		header('Content-Language: en');
		echo json_encode($response);
        exit;
    
 }
 
 public function activeparades(){
     $data = $this->Route_model->getActiveParade();
      if($data){
           
            foreach ($data as $key => $value){
                
                $parade[$key]['id'] = (int)$value['id'];
                $parade[$key]['name'] = $value['name'];
                $parade[$key]['date'] = date('m/d/Y',$value['date']);
                $parade[$key]['start_time'] = date('H:i ',$value['start_time']).$value['am_pm'];
                $parade[$key]['status'] = $value['status'];
                $parade[$key]['image'] = $this->protocol.'://'.$_SERVER['HTTP_HOST'].'/parade/assets/'.$value['image'];
               
            }
            
        }
              
        header('Content-type: application/json; charset=UTF-8');
        header('Content-Language: en');
		echo json_encode($parade);
	    exit;
 }
}
        