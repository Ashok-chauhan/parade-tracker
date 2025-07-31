<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Parade extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('Parade_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        date_default_timezone_set('America/Chicago');

    }

    function is_logged_in()
    {

        $is_logged_in = $this->session->userdata('is_logged_in');
        $admin = $this->session->userdata('type');
        //1 if (!isset($is_logged_in) || $is_logged_in != true || $admin !='admin') {
        if (!isset($is_logged_in) || $is_logged_in != true) {
            //echo 'You don\'t have permission to access this page.' . anchor('users/index', 'Log in');
            redirect('users/index');
            die();
            //$this->load->view('login_form');
        }
    }

    public function index()
    {

        $field = '';
        $order = '';
        $nameOrder = '';
        $dateOrder = '';

        switch ($this->uri->segment(3)) {
            case "pasc":
                $field = 'name';
                $order = 'asc';
                $nameOrder = 'pdesc';

                break;
            case "pdesc":
                $field = 'name';
                $order = 'desc';
                $nameOrder = 'pasc';

                break;
            case "dasc":
                $field = 'date';
                $order = 'asc';
                $dateOrder = 'ddesc';

                break;
            case "ddesc":
                $field = 'date';
                $order = 'desc';
                $dateOrder = 'dasc';

                break;
            default:
                $field = 'name';
                $order = 'asc';
                $nameOrder = 'pdesc';
                $dateOrder = 'dasc';
        }
        //$query = $this->db->get('parade');
        $data['nameOrder'] = $nameOrder;
        $data['dateOrder'] = $dateOrder;
        $data['parades'] = $this->Parade_model->getParades($field, $order);
        $data['main'] = 'parade/index';
        $this->load->view('template', $data);
    }

    public function edit()
    {
        //print_r($this->uri->segment(3));
        if ($this->uri->segment(3)) {
            $this->db->where('id', $this->uri->segment(3));
            $q = $this->db->get('parade');
            //$result = $q->row_array();
            //print '<pre>';
            //print_r($data);
            $data['main'] = 'parade/edit';
            $year = range(2018, 2030);
            $years = array();
            foreach ($year as $value) {
                $years[$value] = $value;
            }
            $month = range(1, 12);
            $months = array();
            foreach ($month as $monthValue) {
                $months[$monthValue] = $monthValue;
            }
            $hour = $months;
            $date = range(1, 31);
            $dates = array();
            foreach ($date as $dateValue) {
                $dates[$dateValue] = $dateValue;
            }
            $data['months'] = $months;
            $data['dates'] = $dates;
            $data['years'] = $years;
            $data['hour'] = $hour; //range(0,24);
            $data['minute'] = range(0, 59);
            $data['second'] = range(0, 60);

            $data['row'] = $q->row_array();
            $this->load->view('template', $data);

        }
    }



    function delete()
    {
        // $query = $this->db->query('DELETE FROM parade WHERE id='.$this->uri->segment(3));
        $this->db->where('id', $this->uri->segment(3));
        $this->db->delete('parade');
        redirect('parade/index');
    }

    public function save()
    {

        //field name,error message, validation rules.
        $this->form_validation->set_rules('name', 'Parade Name', 'trim|required');
        $this->form_validation->set_rules('route_id', 'Route id', 'is_natural_no_zero|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('parade/edit/' . $this->input->post('id'));

        } else {

            $result = $this->Parade_model->save();
            if ($result) {
                $this->session->set_flashdata('message', 'Data edited succesfully...');

            } else {
                $this->session->set_flashdata('message', 'No change in data.');

            }
            redirect('parade/index');
        }
    }

    public function createParade()
    {
        if ($this->input->post('name')) {
            $unixDate = mktime(0, 0, 0, $this->input->post('month'), $this->input->post('date'), $this->input->post('year'));
            $unixTime = mktime($this->input->post('hour'), $this->input->post('minute'), $this->input->post('second'), 0, 0, 0);
            $uploaddir = '/var/www/parade.whizti.com/assets/';
            //print $uploaddir;
            $imagefile = $uploaddir . basename($_FILES['userfile']['name']);
            //print '<li>'.$imagefile;
            //exit;
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $imagefile)) {
                // echo "File is valid, and was successfully uploaded.\n";
            } else {
                echo "Possible file upload attack!\n";
            }

            $data = array(
                'name' => $this->input->post('name'),
                'area' => $this->input->post('area'),
                'date' => $unixDate,
                'start_time' => $unixTime,
                'image' => basename($imagefile),
                'route_id' => $this->input->post('route_id'),
                'floats' => $this->input->post('floats'),
                'banner' => $this->input->post('banner'),
                'sponsor_ad' => $this->input->post('sponsor_ad')

            );
            if (date('h', $unixTime) >= 12) {
                $data['am_pm'] = 'pm';
            } else {
                $data['am_pm'] = $this->input->post('am_pm');
            }
            $this->db->insert('parade', $data);

            redirect('parade/index/');

        } else {
            // get Max route id 
            $maxRouteid = $this->Parade_model->getMaxRouteId();
            $data['next_route_id'] = $maxRouteid + 1;
            $year = range(2018, 2030);
            $years = array();
            foreach ($year as $value) {
                $years[$value] = $value;
            }
            $month = range(1, 12);
            $months = array();
            foreach ($month as $monthValue) {
                $months[$monthValue] = $monthValue;
            }
            $hour = $months;
            $date = range(1, 31);
            $dates = array();
            foreach ($date as $dateValue) {
                $dates[$dateValue] = $dateValue;
            }
            $data['months'] = $months;
            $data['dates'] = $dates;
            $data['years'] = $years;
            $data['hour'] = $hour; //range(0,24);
            $data['minute'] = range(0, 59);
            $data['second'] = range(0, 60);

            $data['main'] = 'parade/create';
            $this->load->view('template', $data);
        }
    }

    public function config()
    {
        $parade_id = filter_var($this->uri->segment(3), FILTER_VALIDATE_INT);
        $data['row'] = $this->Parade_model->getConfig($parade_id);

        if ($parade_id) {
            $data['parade_id'] = $parade_id;
        } else {
            $data['parade_id'] = $data['row']['parade_id'];
        }

        $data['parades'] = $this->Parade_model->api($id = '');
        $data['main'] = 'parade/config';
        $this->load->view('template', $data);
    }
    public function configSave()
    {

        if ($this->input->post('parade_id')) {

            $result = $this->Parade_model->updateConfig();
            if ($result) {
                $this->session->set_flashdata('message', 'Configuration edited succesfully...');
            } else {
                $this->session->set_flashdata('message', 'No change in Configuration...');
            }
            redirect('parade/config/' . $result);
        } else {

            $result = $this->Parade_model->saveConfig();
            if ($result) {
                $this->session->set_flashdata('message', 'Configured succesfully...');
            }

            redirect('parade/config/' . $result);
        }

    }
    /*
     * 
     * It was used for pagination
    private function getParade($limit=null, $offset=null){
        $this->db->select('*');
        $this->db->from('parade');
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
     * 
     */

    public function download()
    {
        $filename = $this->input->get('file');
        $file = 'assets/' . $filename;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
}