<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class Api extends CI_Controller
{
    var $protocol = '';

    function __construct()
    {
        parent::__construct();
        // $this->is_logged_in();
        $this->load->model('Api_model');
        $this->protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        date_default_timezone_set('America/Chicago');
        $this->output->set_content_type('application/json');
        //date_default_timezone_set('UTC');

    }

    public function parade()
    {


        $parade_id = filter_var($this->uri->segment(3), FILTER_VALIDATE_INT);
        $data = $this->Api_model->api();
        $configData = $this->Api_model->getConfig($parade_id);
        if (!$configData)
            $configData = $this->Api_model->getConfig();
        $config = array();
        $config['weather_url'] = $configData['weather_url'];
        $config['zipcode'] = $configData['zipcode'];
        $config['banner_ad'] = $configData['dfp_ad_unit'];
        $config['googleAnalyticsNewApID'] = $configData['google_analytics'];
        $config['googleAnalyticsNewAppID'] = $configData['google_analytics']; //for ios .
        $config['about_text'] = $configData['about_text'];
        $config['paradecurrentlocation_interval'] = $configData['location_interval'];
        $config['paradecurrentlocation_url'] = $configData['location_url'];
        $config['home_screen_ad'] = $configData['home_screen'];
        $config['schedule_screen_ad'] = $configData['schedule_screen'];
        $config['sponsor_ad'] = $configData['sponsor_ad'];
        $config['interstitial_ad'] = $configData['interstitial_ad'];
        $config['cox_ad'] = $configData['cox_ad'];
        $config['contact_email'] = $configData['email']; // 'web@wdsu.com';



        $parade = array();
        $poi = array();
        //print '<pre>';
        //print_r($data);
        if ($data) {

            foreach ($data as $key => $value) {
                //print_r($value);
                $parade[$key]['id'] = (int) $value['id'];
                $parade[$key]['name'] = $value['name'];
                $parade[$key]['area'] = $value['area'];
                $parade[$key]['date'] = date('m/d/Y', $value['date']);
                $parade[$key]['start_time'] = date('H:i ', $value['start_time']) . $value['am_pm'];
                //$parade[$key]['start_time'] = date('H:i A',$value['start_time']);
                $parade[$key]['image'] = $this->protocol . '://' . $_SERVER['HTTP_HOST'] . '/assets/' . $value['image'];

                if ($parade_id) {
                    $parade[$key]['kml'] = $this->protocol . '://' . $_SERVER['HTTP_HOST'] . '/kml/kmlfile/' . $value['route_id'] . '/' . $this->uri->segment(4);
                } else {
                    $parade[$key]['kml'] = $this->protocol . '://' . $_SERVER['HTTP_HOST'] . '/kml/kmlfile/' . $value['route_id'];
                }
                $parade[$key]['floats'] = (int) $value['floats'];
                $parade[$key]['banner_ad'] = $value['banner'];
                $parade[$key]['sponsor_ad'] = $value['sponsor_ad'];
                $firstCoordinate = $this->Api_model->getFirstCoordinate($value['route_id']);
                $parade[$key]['lat'] = $firstCoordinate['latitude'];
                $parade[$key]['lon'] = $firstCoordinate['longitude'];
                $points = $this->Api_model->getPoi($value['id']);
                foreach ($points as $point) {
                    $parade[$key]['points_of_interest'][] = $point;
                }
            }

        }


        //$parade['parades'] = $parade;
        $response['parades'] = $parade;
        $response['config'] = $config;
        //snding response.
        $this->_sendResponse(200, 'application/json', json_encode($response));
        //  $this->_sendResponse(403, 'application/json',  '');


    }

    public function coordinate()
    {

        $activeParade = $this->Api_model->getParade($this->uri->segment(3));
        $response = array();

        //if( $this->uri->segment(3)=== $activeParade[0]['id'] ){
        if (isset($activeParade[0])) {

            $currentLocation = $this->Api_model->currentLocation($activeParade[0]['route_id']);
            $tailLocation = $this->Api_model->tailLocation($activeParade[0]['route_id']);

            $response['lat'] = $currentLocation['latitude'];
            $response['lon'] = $currentLocation['longitude'];
            $response['label'] = $currentLocation['intersection'];
            $response['parade_id'] = $this->uri->segment(3);
            $response['route_id'] = $currentLocation['route_id'];
            $response['tail-lat'] = $tailLocation['latitude'];
            $response['tail-lon'] = $tailLocation['longitude'];
            $response['tail-label'] = $tailLocation['intersection'];
            $response['status'] = (isset($currentLocation['status'])) ? 'active' : 'inactive';
        } else {
            return FALSE;
        }
        //sending response.
        $this->_sendResponse(200, 'application/json', json_encode($response));

    }

    public function updateCurrentLocation()
    {
        if (!$this->check_auth()) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode(['error' => true, 'message' => 'Invalid credentials']));
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $jsonData = file_get_contents("php://input");
            // Decode JSON into a PHP associative array
            $data = json_decode($jsonData, true);
            $parade = $this->Api_model->getParade($data['parade_id']);
            $route_id = $parade[0]['route_id'];
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
            $intersection = $data['intersection'];
            if ($data['location'] == 'head') {
                $headResponse = $this->Api_model->updateLocationTable($latitude, $longitude, $route_id, $intersection);
                if ($headResponse) {
                    $resp = [
                        'error' => false,
                        'message' => 'Head location updated.'
                    ];
                } else {
                    $resp = [
                        'error' => true,
                        'message' => 'Head location already set.'
                    ];
                }
                echo json_encode($resp);
            } else if ($data['location'] == 'tail') {
                $tailResponse = $this->Api_model->updateTailLocationTable($latitude, $longitude, $route_id, $intersection);
                if ($tailResponse) {
                    $resp = [
                        'error' => false,
                        'message' => 'Tail location updated.'
                    ];
                } else {
                    $resp = [
                        'error' => true,
                        'message' => 'Tail location already set.'
                    ];
                }
                echo json_encode($resp);
            } else {
                $resp = [
                    'error' => true,
                    'message' => 'Nothing to update.'
                ];
                echo json_encode($resp);
            }

        }

    }


    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['user']) || !isset($data['password'])) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(['error' => true, 'message' => 'User and password required']));
            }

            $user = $this->Api_model->get_user_by_user($data['user']);
            if ($user['type'] == 'admin') {
                return $this->output
                    ->set_status_header(401)
                    ->set_output(json_encode(['error' => true, 'message' => 'You are not authorized!.']));

            }

            if ($user && $this->Api_model->passwordVerify($data['user'], $user['password'])) {
                $this->session->set_userdata([
                    'user_id' => $user['id'],
                    'user' => $user['user'],
                    'logged_in' => true
                ]);

                return $this->output
                    ->set_output(json_encode([
                        'message' => 'Login successful',
                        'user_id' => $user['id'],
                        'user' => $user['user']
                    ]));
            }

            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode(['message' => 'Invalid credentials']));
        }
    }

    public function logout()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->session->sess_destroy();

            return $this->output
                ->set_output(json_encode(['message' => 'Logout successful']));
        }
    }

    public function check_auth()
    {
        if ($this->session->userdata('logged_in')) {
            return true;
        }

        return false;
    }

    //////////////////////////////// SERVER RESPONSE CODES //////////////////////////////////////////
    protected function _sendResponse($status = 200, $content_type = 'application/json', $body = '')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type . '; charset=UTF-8');
        header('Content-Language: en');
        header('Content-Length: ' . strlen($body));
        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
            exit;
        }


    }


    protected function _getStatusCodeMessage($status)
    {

        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }




}