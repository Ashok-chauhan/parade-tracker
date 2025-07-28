<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home_model extends CI_Model
{
    function __construct()
    {
        //call the model constructor
        parent::__construct();
    }



    function getTodaysParade()
    {

        $this->db->where('date', strtotime(date('m/d/Y', strtotime('now'))));
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('parade');
        //print_r($this->db->last_query()); 
        return $query->result_array();
    }
    function getRoute($route_id)
    {
        $this->db->where('route_id', $route_id);
        // 16/10/2018
        $this->db->order_by('route_order', 'asc');

        //
        $Q = $this->db->get('Routes');
        return $Q->result_array();
    }
    function paradeById($id)
    {

        $this->db->where('id', $id);
        $query = $this->db->get('parade');
        return $query->row();
    }

    public function updateStatus($id)
    {
        $this->db->where('route_id', $this->session->userdata('route_id'));
        $this->db->update('Routes', array('status' => 0));
        //Setting current location .
        $this->db->where('id', $id);
        $this->db->update('Routes', array('status' => 1));


    }



    public function getRoutLocationById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('location');
        return $query->row();
    }

    public function getTailRoutLocationById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tail_location');
        return $query->row();
    }

    public function updateLocation($id, $intersection)
    {
        //$this->db->where('id', $id);
        //$this->db->update('Routes', array('intersection'=>$intersection));

        $this->db->where('route_id', $this->session->userdata('route_id'));
        $this->db->where('id', $id);
        $this->db->update('location', array('intersection' => $intersection));
    }

    public function updateTailLocation($id, $intersection)
    {

        $this->db->where('route_id', $this->session->userdata('route_id'));
        $this->db->where('id', $id);
        $this->db->update('tail_location', array('intersection' => $intersection));
    }


    public function getLocationByRouteId($routeId)
    {
        $this->db->where('route_id', $routeId);
        $query = $this->db->get('location');
        return $query->row();

    }

    public function tailLocationByRouteId($routeId)
    {
        $this->db->where('route_id', $routeId);
        $query = $this->db->get('tail_location');
        return $query->row();

    }

    public function updateLocationTable($id)
    {
        $this->db->where('id', $id);
        $routeQuery = $this->db->get('Routes');
        $routeRow = $routeQuery->row_array();

        $this->db->where('route_id', $this->session->userdata('route_id'));
        $locationQuery = $this->db->get('location');
        if ($locationQuery->num_rows() == 1) {
            //update location table for single record.
            $locationRow = $locationQuery->row_array();
            $this->db->where('id', $locationRow['id']);
            $this->db->where('route_id', $this->session->userdata('route_id'));
            $this->db->update('location', $routeRow);
        } else {

            $this->db->insert('location', $routeRow);
        }

    }


    public function updateTailLocationTable($id)
    {
        $this->db->where('id', $id);
        $routeQuery = $this->db->get('Routes');
        $routeRow = $routeQuery->row_array();
        $currentLocationid = $this->currentLocation($this->session->userdata('route_id'));
        if ($currentLocationid >= $id) {

            $this->db->where('route_id', $this->session->userdata('route_id'));
            $locationQuery = $this->db->get('tail_location');
            if ($locationQuery->num_rows() == 1) {
                //update location table for single record.
                $locationRow = $locationQuery->row_array();
                $this->db->where('id', $locationRow['id']);
                $this->db->where('route_id', $this->session->userdata('route_id'));
                $this->db->update('tail_location', $routeRow);
                return $this->db->affected_rows();

            } else {

                $this->db->insert('tail_location', $routeRow);
                return $this->db->insert_id();
            }
        } else {

            return 'f';
        }
    }
    public function currentLocation($routeId)
    {
        $this->db->where('route_id', $routeId);
        $tailQuery = $this->db->get('location');
        $tail = $tailQuery->row_array();
        if ($tail) {
            return $tail['id'];
        } else {
            return null;
        }
    }

    public function resetTail($routeid)
    {
        $this->db->where('route_id', $routeid);
        $ro = $this->db->delete('tail_location');
        return $this->db->affected_rows();
    }


    public function resetHead($routeid)
    {
        $this->db->where('route_id', $routeid);
        $ro = $this->db->delete('location');
        // reset route status to 0
        $this->db->where('route_id', $routeid);
        $this->db->update('Routes', array('status' => 0));
        return $this->db->affected_rows();
    }
}

