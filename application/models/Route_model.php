<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Route_model extends CI_Model{
	function __construct(){
		//call the model constructor
		parent::__construct();
	}
    
    function  getActiveParade($id=''){
        $this->db->where('date', strtotime(date('m/d/Y', strtotime('now'))));
        $this->db->order_by('name','asc');
        $query = $this->db->get('parade');
        return $query->result_array();
    }
    function  getParade($id){
        if($id){ 
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $Q = $this->db->get('parade');
        return $Q->result_array();
    }
    
    }
    
    function getRoute($route_id){
        $this->db->where('route_id', $route_id);
        $Q = $this->db->get('Routes');
        return $Q->result_array();
    }
    
    public function updateStatus($id, $status){

        
        $this->db->where('route_id', $this->session->userdata('parade_id'));
        $this->db->update('Routes', array('status' =>0));
        //Setting current location .
        $this->db->where('id', $id);
        $this->db->update('Routes', array('status' => 1));
        
        
    }
    
    public function currentLocation($route_id){
        $this->db->where('route_id', $route_id);
        $this->db->where('status', 1);
        $Q = $this->db->get('Routes');
        return $Q->row_array();
    }
}