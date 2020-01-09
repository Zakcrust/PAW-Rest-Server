<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Validation extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('APIModel');
    }

    function index_get()
    {
        $apikey = $this->get('api_key');
        $isApiKeyValid = $this->APIModel->checkAPIKey($apikey);
        if ($isApiKeyValid == NULL) {
            $this->response('ACCESS DENIED', 502);
            return;
        }

        $username = $this->get('username');
        if ($username == '') {
            $data = $this->db->get('user')->result();
        } else {
            $this->db->where('username', $username);
            $data = $this->db->get('user')->row();
        }
        if ($data)
            $this->response($data, 200);
        else
            $this->response(NULL, 200);
    }

}
