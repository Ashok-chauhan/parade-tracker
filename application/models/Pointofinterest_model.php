<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pointofinterest_model extends CI_Model
{
    function __construct()
    {
        //call the model constructor
        parent::__construct();
    }

    function getAallParade()
    {
        $query = $this->db->get('parade');
        //return $query->result_array();
        return $query->result();
    }
    function getParade($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->where('status', 1);
            $Q = $this->db->get('parade');
            return $Q->result_array();
        }

    }

    function getPoi($parade_id)
    {
        $this->db->where('parade_id', $parade_id);
        // $this->db->order_by('route_order', 'asc');

        $Q = $this->db->get('pointof_interest');
        return $Q->result_array();
    }

    public function getPointbyId($id)
    {
        $this->db->where('id', $id);
        $Q = $this->db->get('pointof_interest');
        return $Q->row();
    }

    public function updatePointbyId($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('pointof_interest', $data)) {
            $resp = [
                'error' => false,
                'result' => 'Route has been updated sucessfully.'
            ];
        } else {
            $resp = [
                'error' => true,
                'result' => 'Error, something went wrong, try again.'
            ];
        }
        return $resp;
    }


    public function addPoint($data)
    {

        if ($this->db->insert('pointof_interest', $data)) {
            $resp = [
                'error' => false,
                'result' => 'Point has been added sucessfully.'
            ];
        } else {
            $resp = [
                'error' => true,
                'result' => 'Error, something went wrong, try again.'
            ];
        }
        return $resp;

    }

    public function deletePoint($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('pointof_interest')) {
            $resp = [
                'error' => false,
                'result' => 'Route has been Deleted sucessfully.'
            ];

        } else {
            $resp = [
                'error' => true,
                'result' => 'Error, something went wrong, try again.'
            ];
        }
        return $resp;
    }


}