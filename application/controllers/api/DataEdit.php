<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class DataEdit extends REST_Controller
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

        $id = $this->get('id');
        $data = $this->db->get_where('atable', array('id' => $id))->row();

        $this->response($data, 200);
    }

    //Masukan function selanjutnya disini

    public function index_post()
    {

        $input = $this->input->post();

        $apikey = $input['api_key'];
        $isApiKeyValid = $this->APIModel->checkAPIKey($apikey);
        if ($isApiKeyValid == NULL) {
            var_dump($isApiKeyValid);
            $this->response('ACCESS DENIED', 502);
            return;
        }
        $data = array(
            'user_id'       =>  $input['user_id'],
            'random_text'   =>  $input['random_text']
        );
        $post = $this->db->insert('atable', $data);

        if ($post) {
            $this->response(['OK'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    public function index_put()
    {
        $input = $this->put();
        $apikey = $input['api_key'];

        $isApiKeyValid = $this->APIModel->checkAPIKey($apikey);
        if ($isApiKeyValid == NULL) {
            $this->response('ACCESS DENIED', 502);
            return;
        }

        $data = array (
                'id' => $input['id'],
                'user_id'       =>  $input['user_id'],
                'random_text'   =>  $input['random_text']
        );
        $this->db->where('id', $input['id']);
        $update = $this->db->update('atable', $data);

        if ($update) {
            $this->response(['OK'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
