<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pointofinterest extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('Pointofinterest_model');
        $this->load->helper('url');
        date_default_timezone_set('America/Chicago');
    }

    function is_logged_in()
    {

        $is_logged_in = $this->session->userdata('is_logged_in');
        $admin = $this->session->userdata('type');
        if (!isset($is_logged_in) || $is_logged_in != true || $admin != 'user') {
            //echo 'You don\'t have permission to access this page.' . anchor('users/index', 'Log in');
            redirect('users/index');
            die();
            //$this->load->view('login_form');
        }
    }

    function index()
    {
        // $this->session->unset_userdata('parade_id');
        //$this->session->unset_userdata('parade_name');
        $data['parades'] = $this->Pointofinterest_model->getAallParade();

        $data['main'] = 'pointofinterest/index';
        //  print '<pre>';
        //  print_r($data);
        $this->load->view('template', $data);

    }
    function pointofinterest()
    {
        // if ($this->input->method(TRUE) === 'POST') {
        if ($this->input->post('parade_id') && !$this->input->post('pointid')) {
            $data = array(
                'parade_id' => $this->input->post('parade_id'),
                'name' => $this->input->post('name'),
                'lat' => $this->input->post('lat'),
                'lon' => $this->input->post('lon'),
                'category' => $this->input->post('category'),
                'image' => $this->input->post('image')
            );
            $response = $this->Pointofinterest_model->addPoint($data);
            echo json_encode($response);

        } elseif ($this->input->post('pointid')) {

            $dataToupdate = array(

                'name' => $this->input->post('name'),
                'lat' => $this->input->post('lat'),
                'lon' => $this->input->post('lon'),
                'category' => $this->input->post('category'),
                'image' => $this->input->post('image')
            );

            $response = $this->Pointofinterest_model->updatePointbyId($this->input->post('pointid'), $dataToupdate);
            echo json_encode($response);
            // echo json_encode(['done' => 'done']);

        }



    }
    function displayPoi()
    {
        if ($this->input->post('parade_id')) {
            $respData = $this->Pointofinterest_model->getPoi($this->input->post('parade_id'));
            echo json_encode($respData);

        }
    }

    function getPointById()
    {
        if ($this->input->post('id')) {
            $response = $this->Pointofinterest_model->getPointById($this->input->post('id'));
            echo json_encode($response);
        }
    }

    function deletePoint()
    {
        if ($_POST['id']) {
            $id = $_POST['id'];
            $response = $this->Pointofinterest_model->deletePoint($id);
            echo json_encode($response);
        }
    }

}
