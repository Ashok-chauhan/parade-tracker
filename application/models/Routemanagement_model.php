<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Routemanagement_model extends CI_Model
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

    function getRoute($route_id)
    {
        $this->db->where('route_id', $route_id);
        $this->db->order_by('route_order', 'asc');

        $Q = $this->db->get('Routes');
        return $Q->result_array();
    }

    function copyRoute($toRoute, $fromRoute)
    {
        $this->db->trans_begin();
        $copyroute = $this->db->query('SELECT intersection, latitude, longitude, id from Routes WHERE route_id=' . $fromRoute);
        $this->db->query('DELETE FROM Routes WHERE route_id=' . $toRoute);
        foreach ($copyroute->result() as $row) {
            $routeOrder = $row->id . '0';
            $status = 0;
            $this->db->query("INSERT INTO Routes (intersection, latitude, longitude, route_id, route_order, status) VALUES('" . $row->intersection . "','" . $row->latitude . "','" . $row->longitude . "','" . $toRoute . "','" . $routeOrder . "','" . $status . "')");

        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resp = [
                'error' => true,
                'result' => 'Error, something went wrong, try again.'
            ];
        } else {
            $this->db->trans_commit();
            $resp = [
                'error' => false,
                'result' => 'Success, Route has been updated.'
            ];
        }
        return $resp;

    }

    public function updateStatus($id, $status)
    {


        $this->db->where('route_id', $this->session->userdata('parade_id'));
        $this->db->update('Routes', array('status' => 0));
        //Setting current location .
        $this->db->where('id', $id);
        $this->db->update('Routes', array('status' => 1));


    }

    public function getRoutbyId($id)
    {
        $this->db->where('id', $id);
        $Q = $this->db->get('Routes');
        return $Q->row();
    }

    public function updateRoutebyId($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('Routes', $data)) {
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

    public function maxRouteOrder($route_id)
    {
        $this->db->select_max('route_order');
        $this->db->where('route_id', $route_id);
        $q = $this->db->get('Routes');
        return $q->row();

    }
    public function addRoutebyId($data)
    {

        if ($this->db->insert('Routes', $data)) {
            $resp = [
                'error' => false,
                'result' => 'Route has been added sucessfully.'
            ];
        } else {
            $resp = [
                'error' => true,
                'result' => 'Error, something went wrong, try again.'
            ];
        }
        return $resp;

    }

    public function deleteRoute($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('Routes')) {
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

    public function updateRouteOrder($order)
    {

        $this->db->trans_begin();
        foreach ($order as $key => $id) {
            $route_order = $key . 1;
            $this->db->where('id', $id);
            $this->db->update('Routes', array('route_order' => $route_order));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resp = [
                'error' => true,
                'result' => 'Error, something went wrong, try again.'
            ];
        } else {
            $this->db->trans_commit();
            $resp = [
                'error' => false,
                'result' => 'Success, Point has been updated.'
            ];

        }
        return $resp;

    }
}