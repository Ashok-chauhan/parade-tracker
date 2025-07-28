<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
    
    function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->helper('url');
        
        
		
	}
	 
	public function index(){
		
		$data['main']= 'users/index';
		$this->load->view('template', $data);
	}
    
    public function login(){
       
		
		$query = $this->users_model->validate();
		
		if($query) // if the user's credentials validated...
		{ 
            
			$udata = $this->users_model->getuser();
			
			$data = array(
				'user' => $this->input->post('user'),
				'uid'	=> $udata->id,
                'type'  => $udata->type,
				'is_logged_in' => true,
				);
            
			$this->session->set_userdata($data);
			if($this->session->userdata('type') === 'admin'){
				redirect('parade');
            }elseif ($this->session->userdata('type') === 'user') {
                redirect('home');
            }			
		}
		else // incorrect username or password
		{ 
			$this->index();
		}
	}
    
    function logout(){
		 $this->session->sess_destroy();
		// $this->index();
         redirect('home');
	 }


    
}