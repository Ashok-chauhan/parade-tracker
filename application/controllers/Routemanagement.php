<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Routemanagement extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('Routemanagement_model');
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
        $this->session->unset_userdata('parade_id');
        $this->session->unset_userdata('parade_name');
        $data['parades'] = $this->Routemanagement_model->getAallParade();

        $data['main'] = 'routemanagement/index';
        //  print '<pre>';
        //  print_r($data);
        $this->load->view('template', $data);

    }
    function manage()
    {
        $this->session->unset_userdata('parade_id');
        $this->session->unset_userdata('parade_name');
        $data['parades'] = $this->Routemanagement_model->getAallParade();

        $data['main'] = 'routemanagement/manage';

        $this->load->view('template', $data);

    }

    function updateRouteOrder()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['order'])) {
            $order = $data['order']; // Array of item IDs
            $response = $this->Routemanagement_model->updateRouteOrder($order);
            echo json_encode($response);
        } else {
            echo json_encode([
                'error' => true,
                'result' => 'Error, something went wrong, try again.'
            ]);
        }
    }

    function routes()
    {
        // $route = json_decode($_POST);
        if ($_POST['route_id']) {
            $data = $this->Routemanagement_model->getRoute($_POST['route_id']);
            echo json_encode($data);
        } else {
            $data = ['error' => 'something went wrong'];
            echo json_encode($data);
        }
        // print_r($_POST['rotue_id']);
    }

    function copyRoute()
    {
        if ($_POST) {
            $from_route = $this->Routemanagement_model->copyRoute($_POST['toRoute'], $_POST['fromRoute']);
            echo json_encode($from_route);
        }
    }

    function getRoutbyId()
    {
        if ($_POST['id']) {
            $result = $this->Routemanagement_model->getRoutbyId($_POST['id']);
            echo json_encode($result);
            //echo json_encode(['data'=>'reslut']);
        }
    }

    function updateRoutebyId()
    {
        if ($_POST['id']) {
            $id = $_POST['id'];
            $data = [
                'intersection' => $_POST['intersection'],
                'latitude' => $_POST['latitude'],
                'longitude' => $_POST['longitude'],
            ];
            $response = $this->Routemanagement_model->updateRoutebyId($id, $data);
            echo json_encode($response);
        }

    }

    function deleteRoute()
    {
        if ($_POST['id']) {
            $id = $_POST['id'];
            $response = $this->Routemanagement_model->deleteRoute($id);
            echo json_encode($response);
        }
    }

    function addRoutebyId()
    {
        $route_id = $this->input->post('route_id');
        $order = $this->Routemanagement_model->maxRouteOrder($route_id);
        if ($order->route_order) {
            $routeOrder = $order->route_order + 10;
        } else {
            $routeOrder = 10;
        }
        $data = [
            'route_id' => $route_id,
            'intersection' => $this->input->post('intersection'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'route_order' => $routeOrder,
        ];
        $response = $this->Routemanagement_model->addRoutebyId($data);
        echo json_encode($response);
    }

}