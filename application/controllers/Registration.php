<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registration extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->is_logged_in();
		//$this->load->model('Parade_model');
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
   
  }
 }
 
	public function index(){
		//$query = $this->db->get('parade');
        //$data['parades'] = $query->result_array();
		$data['main']= 'registration/index';
		$this->load->view('template', $data);
	}
    public function register(){
        if($this->input->post('name') && $this->input->post('password')){
            $data = array(
                'user'     => $this->input->post('name'),
                'password' => sha1($this->input->post('password')),
                'status'   => 'active',
                'type'     => $this->input->post('type')
            );
            $this->db->insert('users', $data);
            $this->session->set_flashdata('message', 'Registered successfuly.');
            redirect('registration/registeredusers');
            
        }else{
            redirect('registration/index');
        }
    }
    public function registeredusers(){
         $this->db->where('id !=', 1);
         $query = $this->db->get('users');
        $userdata = $query->result_array();
        $data['main'] = 'registration/registeredusers';
        $data['users'] = $userdata;
        $this->load->view('template', $data);
        
    }
    public function userdelete(){
        if($this->uri->segment(3)){
            $this->db->where('id', $this->uri->segment(3));
            $this->db->delete('users');
            $this->session->set_flashdata('message', 'User Deleted...');
        }
        redirect('registration/registeredusers');
    }
  
}