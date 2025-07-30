<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Parade_model extends CI_Model
{
    function __construct()
    {
        //call the model constructor
        parent::__construct();
    }

    public function save()
    {

        $unixDate = mktime(0, 0, 0, $this->input->post('month'), $this->input->post('date'), $this->input->post('year'));
        $unixTime = mktime($this->input->post('hour'), $this->input->post('minute'), $this->input->post('second'), 0, 0, 0);


        $data = array(
            'name' => $this->input->post('name'),
            'area' => $this->input->post('area'),
            'date' => $unixDate,
            'start_time' => $unixTime,
            'route_id' => $this->input->post('route_id'),
            'lat' => $this->input->post('lat'),
            'lon' => $this->input->post('lon'),
            'floats' => $this->input->post('floats'),
            'banner' => $this->input->post('banner'),
            'sponsor_ad' => $this->input->post('sponsor_ad')
        );
        //if(date('h', $unixTime) >= 12){
        //      $data['am_pm']= 'pm';
        //}else{
        $data['am_pm'] = $this->input->post('am_pm');
        //}

        $uploaddir = '/var/www/parade.whizti.com/assets/';
        $imagefile = $uploaddir . basename($_FILES['userfile']['name']);
        //$kmlfile = $uploaddir . basename($_FILES['userfile']['name'][0]);

        if ($_FILES['userfile']['name']) {

            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $imagefile)) {
                // echo "File is valid, and was successfully uploaded.\n";
                $data['image'] = $_FILES['userfile']['name'];
            } else {
                // echo "Possible file upload attack!0\n";
            }
        }


        //setting status 0 (inactive) of route_id in Routes table when admin edit data/time.
        $this->db->where('route_id', $this->input->post('route_id'));
        $this->db->update('Routes', array('status' => '0'));
        // eof setting status   0 (inactive) for route id.    
        //Delete all the record (ususaly there are 1 records only) from location table of edited route id.
        $this->db->where('route_id', $this->input->post('route_id'));
        $this->db->delete('location');
        // eof deleting routes from location table.
        //Delete all the record (ususaly there are 1 records only) from tail_location table of edited route id.
        $this->db->where('route_id', $this->input->post('route_id'));
        $this->db->delete('tail_location');
        // eof deleting routes from location table.



        $this->db->where('id', $this->input->post('id'));
        $this->db->update('parade', $data);
        if ($this->db->affected_rows() == 1) {

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function saveConfig()
    {

        if ($this->input->post('parade')) {
            $data = array(
                'parade_id' => $this->input->post('parade'),
                'weather_url' => $this->input->post('weather_url'),
                'zipcode' => $this->input->post('zipcode'),
                'dfp_ad_unit' => $this->input->post('dfp_ad_unit'),
                'google_analytics' => $this->input->post('google_analytics'),
                'about_text' => $this->input->post('about_text'),
                'email' => $this->input->post('email'),
                'location_interval' => $this->input->post('location_interval'),
                'location_url' => $this->input->post('location_url'),
                'home_screen' => $this->input->post('home_screen'),
                'schedule_screen' => $this->input->post('schedule_screen'),
                'interstitial_ad' => $this->input->post('interstitial_ad'),
                'sponsor_ad' => $this->input->post('sponsor_ad'),
                'cox_ad' => $this->input->post('cox_ad')
            );

            $this->db->insert('config', $data);
            if ($this->db->affected_rows())
                return $this->input->post('parade');
        } elseif ($this->input->post('parade_id')) {
            $this->updateConfig();
        }
    }

    public function updateConfig()
    {

        if ($this->input->post('parade_id')) {

            $data = array(
                'parade_id' => $this->input->post('parade_id'),
                'weather_url' => $this->input->post('weather_url'),
                'zipcode' => $this->input->post('zipcode'),
                'dfp_ad_unit' => $this->input->post('dfp_ad_unit'),
                'google_analytics' => $this->input->post('google_analytics'),
                'about_text' => $this->input->post('about_text'),
                'email' => $this->input->post('email'),
                'location_interval' => $this->input->post('location_interval'),
                'location_url' => $this->input->post('location_url'),
                'home_screen' => $this->input->post('home_screen'),
                'schedule_screen' => $this->input->post('schedule_screen'),
                'interstitial_ad' => $this->input->post('interstitial_ad'),
                'sponsor_ad' => $this->input->post('sponsor_ad'),
                'cox_ad' => $this->input->post('cox_ad')

            );

            $this->db->where('parade_id', $this->input->post('parade_id'));
            $this->db->update('config', $data);
            if ($this->db->affected_rows() == 1) {

                return $this->input->post('parade_id');
            } else {
                return FALSE;
            }
        }
    }



    public function getConfig($parade_id = '')
    {
        if ($parade_id)
            $this->db->where('parade_id', $parade_id);
        $q = $this->db->get('config');
        return $q->row_array();
    }

    public function api($id)
    {
        if ($id)
            $this->db->where('id', $id);
        $q = $this->db->get('parade');

        return $q->result_array();
    }

    public function kmlData($route_id)
    {
        if ($route_id)
            $this->db->where('route_id', $route_id);
        $this->db->order_by('route_order', 'asc'); //added on 16/10/2018
        $q = $this->db->get('Routes');

        //return $q->result_array();
        return $q->result();
    }

    public function getParades($field, $order)
    {
        //$query = $this->db->query('SELECT * FROM parade  ORDER BY name ASC, date ASC, start_time DESC');
        $query = $this->db->query('SELECT * FROM parade  ORDER BY ' . $field . ' ' . $order);
        return $query->result_array();
    }

    public function getMaxRouteId()
    {
        $this->db->select_max('route_id');
        $query = $this->db->get('parade');
        $id = $query->row();
        return $id->route_id;
    }
}
