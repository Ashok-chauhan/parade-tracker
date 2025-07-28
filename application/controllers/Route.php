<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Route extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->is_logged_in();
		$this->load->model('Route_model');
		$this->load->helper('url');
        date_default_timezone_set('America/Chicago'); 
    }
    
  function is_logged_in() {

  $is_logged_in = $this->session->userdata('is_logged_in');
  $admin = $this->session->userdata('type');
  if (!isset($is_logged_in) || $is_logged_in != true || $admin !='admin') {
   //echo 'You don\'t have permission to access this page.' . anchor('users/index', 'Log in');
      redirect('users/index');
   die();
   //$this->load->view('login_form');
  }
 }
 
 function index(){
     $this->session->unset_userdata('parade_id');
     $this->session->unset_userdata('parade_name');
     $data['parades'] = $this->Route_model->getActiveParade();
     $data['main'] = 'route/index';
     $this->load->view('template', $data);
     
 }
 
 function routes(){
     $data = array(
				'parade_id' => $this->uri->segment(3),
				'parade_name'	=> $this->uri->segment(4)
				);
     $this->session->set_userdata($data);
    if($this->session->has_userdata('parade_id')){
         $data['routes'] = $this->Route_model->getRoute($this->uri->segment(3));
         $data['name'] = $this->uri->segment(4);
         $data['main'] = 'route/routes';
         $this->load->view('template', $data);
     }else{
         redirect('route/index');
     }
 }
 
 public function status(){
        if($this->uri->segment(3)){
            $this->Route_model->updateStatus($this->uri->segment(3));
           
            
            //redirect('route/routeLocation/'.$this->session->userdata('parade_id').'/'.$this->session->userdata('parade_name'));
            redirect('route/route_location');
        }
    }
    
    function route_location(){
     if($this->session->has_userdata('parade_id')){
         $data['routes'] = $this->Route_model->getRoute($this->session->userdata('parade_id'));
         $data['name'] = $this->session->userdata('parade_name');
         $data['main'] = 'route/route_location';
         $this->load->view('template', $data);
     }else{
         redirect('route/index');
     }
 }
 
 
       
    
}