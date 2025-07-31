<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Api_model extends CI_Model
{
    function __construct()
    {
        //call the model constructor
        parent::__construct();
    }


    public function getConfig($parade_id = '')
    {
        if ($parade_id)
            $this->db->where('parade_id', $parade_id);
        $q = $this->db->get('config');
        return $q->row_array();
    }


    function api()
    {
        $TODAY = strtotime(date('m/d/Y', strtotime('now')));
        /*
        $this->db->where('date', strtotime(date('m/d/Y', strtotime('now'))));
       // $this->db->order_by('name','asc');
        $query = $this->db->get('parade');
         * 
         */
        $query = $this->db->query('SELECT * FROM parade WHERE date >=' . $TODAY . ' ORDER BY date ASC, start_time DESC');

        return $query->result_array();
    }

    public function currentLocation($route_id)
    {
        $this->db->where('route_id', $route_id);
        $this->db->where('status', 1);
        //$Q = $this->db->get('Routes');
        $Q = $this->db->get('location');
        return $Q->row_array();
    }

    public function tailLocation($route_id)
    {
        $this->db->where('route_id', $route_id);
        //$this->db->where('status', 1);
        $Q = $this->db->get('tail_location');
        return $Q->row_array();
    }

    function getParade($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            //$this->db->where('status', 1);
            $Q = $this->db->get('parade');
            return $Q->result_array();
        }
    }

    private function getRouteByCoordinate($latitude, $longitude, $route_id)
    {
        $this->db->where('route_id', $route_id);
        $this->db->where('latitude', $latitude);
        $this->db->where('longitude', $longitude);
        $q = $this->db->get('Routes');
        return $q->row_array();

    }


    public function updateLocationTable($latitude, $longitude, $route_id, $intersection = '')
    {

        $routeRow = $this->getRouteByCoordinate($latitude, $longitude, $route_id);
        if ($routeRow) {
            $status = $this->updateStatus($routeRow['id'], $route_id);
            $routeRow['status'] = 1;

        } else {
            $routeRow = [
                'intersection' => $intersection,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'status' => 1
            ];
        }


        $this->db->where('route_id', $route_id);
        $locationQuery = $this->db->get('location');
        if ($locationQuery->num_rows() == 1) {

            //update location table for single record.
            $locationRow = $locationQuery->row_array();
            $this->db->where('id', $locationRow['id']);
            $this->db->where('route_id', $route_id);
            $this->db->update('location', $routeRow);
            return $this->db->affected_rows();
        } else {

            $this->db->insert('location', $routeRow);
            return $this->db->insert_id();
        }

    }

    public function updateTailLocationTable($latitude, $longitude, $route_id, $intersection = '')
    {

        $routeRow = $this->getRouteByCoordinate($latitude, $longitude, $route_id);
        if (!$routeRow) {
            $routeRow = [
                'intersection' => $intersection,
                'latitude' => $latitude,
                'longitude' => $longitude,

            ];
        }

        $this->db->where('route_id', $route_id);
        $locationQuery = $this->db->get('tail_location');
        if ($locationQuery->num_rows() == 1) {
            //update location table for single record.
            $locationRow = $locationQuery->row_array();
            $this->db->where('id', $locationRow['id']);
            $this->db->where('route_id', $route_id);
            $this->db->update('tail_location', $routeRow);
            return $this->db->affected_rows();

        } else {

            $this->db->insert('tail_location', $routeRow);
            return $this->db->insert_id();
        }

    }

    public function updateStatus($id, $route_id)
    {
        $this->db->where('route_id', $route_id);
        $this->db->update('Routes', array('status' => 0));
        //Setting current location .
        $this->db->where('id', $id);
        $this->db->update('Routes', array('status' => 1));


    }

    public function get_user_by_user($user)
    {
        $query = $this->db->get_where('users', ['user' => $user]);
        return $query->row_array();
    }

    public function passwordVerify($user, $password)
    {


        $this->db->where('user', $user);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {

            return true;
        }


    }


    public function getPoi($parade_id)
    {
        $this->db->where('parade_id', $parade_id);
        $this->db->select('id, name, lat, lon, category, image');
        $Q = $this->db->get('pointof_interest');
        return $Q->result_array();
    }

    public function getFirstCoordinate($route_id)
    {
        $this->db->where('route_id', $route_id);
        $this->db->select('latitude, longitude');
        $this->db->order_by('route_order', 'ASC');
        $this->db->limit(1);
        $q = $this->db->get('Routes');
        return $q->row_array();

    }
}

