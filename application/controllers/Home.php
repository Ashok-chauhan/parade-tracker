<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('Home_model');
        $this->load->helper('url');
        date_default_timezone_set('America/Chicago');
    }

    function is_logged_in()
    {

        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            //echo 'You don\'t have permission to access this page.' . anchor('users/index', 'Log in');
            redirect('users/index');
            die();
            //$this->load->view('login_form');
        }
    }

    function index()
    {
        $data['parades'] = $this->Home_model->getTodaysParade();
        $data['main'] = 'home/index';

        $this->load->view('template', $data);

    }

    function routes()
    {
        $parade = $this->Home_model->paradeById($this->uri->segment(3));

        $data = array(
            'parade_id' => $parade->id,
            'parade_name' => $parade->name,
            'route_id' => $parade->route_id
        );
        $this->session->set_userdata($data);
        if ($this->session->has_userdata('parade_id')) {
            $location = $this->Home_model->getLocationByRouteId($parade->route_id);
            if ($location) {
                $data['location_name'] = $location->intersection;
            } else {
                $data['location_name'] = '';
            }
            $data['routes'] = $this->Home_model->getRoute($parade->route_id);
            $data['name'] = $parade->name;
            $data['main'] = 'home/routes';

            $this->load->view('template', $data);
        } else {
            print 'else';
            exit;
            redirect('home/index');
        }
    }

    function tail_routes()
    {
        $parade = $this->Home_model->paradeById($this->uri->segment(3));

        $data = array(
            'parade_id' => $parade->id,
            'parade_name' => $parade->name,
            'route_id' => $parade->route_id
        );
        $this->session->set_userdata($data);
        if ($this->session->has_userdata('parade_id')) {
            $location = $this->Home_model->tailLocationByRouteId($parade->route_id);
            if ($location) {
                $data['location_name'] = $location->intersection;
                $data['location_id'] = $location->id;
            } else {
                $data['location_name'] = '';
            }
            $data['routes'] = $this->Home_model->getRoute($parade->route_id);
            $data['name'] = $parade->name;
            $data['main'] = 'home/tail_routes';

            $this->load->view('template', $data);
        } else {
            print 'else';
            exit;
            redirect('home/index');
        }
    }

    public function stringer()
    {
        $parade = $this->Home_model->paradeById($this->uri->segment(3));

        $data = array(
            'parade_id' => $parade->id,
            'parade_name' => $parade->name,
            'route_id' => $parade->route_id
        );
        $this->session->set_userdata($data);
        $data['parade_id'] = $parade->id;
        $data['parade_name'] = $parade->name;
        $data['main'] = 'home/stringer';
        $this->load->view('template', $data);
    }

    public function status()
    {
        $tailid = $this->Home_model->tailLocationByRouteId($this->session->userdata('route_id'));
        if ($this->uri->segment(3) <= $tailid->id) {
            return redirect('home/route_location/f');
        }
        if ($this->uri->segment(3)) {

            $this->Home_model->updateStatus($this->uri->segment(3));
            $this->Home_model->updateLocationTable($this->uri->segment(3));
            //redirect('route/routeLocation/'.$this->session->userdata('parade_id').'/'.$this->session->userdata('parade_name'));
            redirect('home/route_location');
        }
    }

    function route_location()
    {
        if ($this->session->has_userdata('route_id')) {
            $location = $this->Home_model->getLocationByRouteId($this->session->userdata('route_id'));
            if ($location) {
                $data['location_id'] = $location->id;
                $data['location_name'] = $location->intersection;
            }
            $head = $this->uri->segment(3);
            $data['routes'] = $this->Home_model->getRoute($this->session->userdata('route_id'));
            $data['name'] = $this->session->userdata('parade_name');
            $data['main'] = 'home/route_location';
            $data['head'] = $head;
            $this->load->view('template', $data);
        } else {
            redirect('home/index');
        }
    }


    function tail_route_location()
    {
        if ($this->session->has_userdata('route_id')) {
            //getting tail location from tail_location table

            $tail_location = $this->Home_model->tailLocationByRouteId($this->session->userdata('route_id'));
            if ($tail_location) {
                $data['tail_location_id'] = $tail_location->id;
                $data['tail_location_name'] = $tail_location->intersection;
            }
            $tail = $this->uri->segment(3);
            $data['routes'] = $this->Home_model->getRoute($this->session->userdata('route_id'));
            $data['name'] = $this->session->userdata('parade_name');
            $data['tail'] = $tail;
            $data['main'] = 'home/tail_route_location';

            $this->load->view('template', $data);
        } else {
            redirect('home/index');
        }
    }


    public function tail_status()
    {
        if ($this->uri->segment(3)) {
            $result = $this->Home_model->updateTailLocationTable($this->uri->segment(3));
            redirect('home/tail_route_location/' . $result);
        }
    }

    function getroute()
    {

        if ($this->uri->segment(3)) {
            $data['main'] = 'home/edit';
            $data['page'] = $this->uri->segment(4);
            $data['row'] = $this->Home_model->getRoutLocationById($this->uri->segment(3));
            //print_r($data);exit;
            $this->load->view('template', $data);
        }

    }

    function getTailRoute()
    {

        if ($this->uri->segment(3)) {
            $data['main'] = 'home/editTail';
            $data['page'] = $this->uri->segment(4);
            $data['row'] = $this->Home_model->getTailRoutLocationById($this->uri->segment(3));
            $this->load->view('template', $data);
        }

    }



    function editlocation()
    {
        if ($this->input->post('id')) {
            $this->Home_model->updateLocation($this->input->post('id'), $this->input->post('intersection'));
            if ($this->input->post('page')) {
                redirect('home/routes/' . $this->session->userdata('parade_id'));
            } else {
                redirect('home/route_location');
            }
        }

    }

    function editTailLocation()
    {
        if ($this->input->post('id')) {
            $this->Home_model->updateTailLocation($this->input->post('id'), $this->input->post('intersection'));
            if ($this->input->post('page')) {
                redirect('home/tail_route_location/' . $this->session->userdata('parade_id'));
            } else {
                redirect('home/tail_route_location');
            }
        }

    }

    function resetTail()
    {
        $ro = $this->Home_model->resetTail($this->uri->segment(3));
        redirect('home/tail_route_location');

    }

    function resetHead()
    {
        $ro = $this->Home_model->resetHead($this->uri->segment(3));
        redirect('home/route_location');

    }



}