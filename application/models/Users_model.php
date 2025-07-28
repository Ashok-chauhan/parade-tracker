<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model{
	function __construct(){
		//call the model constructor
		parent::__construct();
	}

	function validate()
	{
        
		$this->db->where('user', $this->input->post('user'));
		$this->db->where('password', sha1($this->input->post('password')));
		//$query1 = $this->db->get_compiled_select('users');
        $query = $this->db->get('users');
        		
		if($query->num_rows() == 1)
		{ 
            
			return true;
		}
		
	}

	function getuser()
	{
		$this->db->where('user', $this->input->post('user'));
		$this->db->where('password', sha1($this->input->post('password')));
		$query = $this->db->get('users');
        
		if($query)
		{ 
          return $query->row();
		}
		
		
	}
}