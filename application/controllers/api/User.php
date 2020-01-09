<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('APIModel');
    }

    function index_get() {

        $apikey = $this->get('api_key');
        $isApiKeyValid = $this->APIModel->checkAPIKey($apikey);
        if ($isApiKeyValid == NULL) {
            $this->response('ACCESS DENIED', 502);
            return;
        }

        $id = $this->get('id');
        $this->get();
        if ($id == '') {
            $data = $this->db->get('user')->result();
        } else {
            $this->db->where('id', $id);
            $data = $this->db->get('user')->result();
        }
        if($data) 
            $this->response($data, 200);
        else
            $this->response(array('status' => 'fail', 502));
    }

    //Masukan function selanjutnya disini
    
    public function index_post()
    {

        $input = $this->post();
        $apikey = $input['api_key'];

        $isApiKeyValid = $this->APIModel->checkAPIKey($apikey);
        if ($isApiKeyValid == NULL) {
            $this->response('ACCESS DENIED', 502);
            return;
        }

        $DEFAULT_IMAGE = "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";
        $input['photo'] = $DEFAULT_IMAGE;
        
        $data = array(
            'username'  => $input['username'],
            'password'  => $input['password'],
            'name'      => $input['name'],
            'photo'     => $input['photo'],
        );
        $post = $this->db->insert('user',$data);
        if ($post) 
        {
            $this->response(['OK'], 200);
        } else 
        {
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
                'id'                => $input['id'],
                'username'          => $input['username'],
                'password'          => $input['password'],
                'name'              => $input['name'],
                'photo'             => $input['photo']
        );
        $this->db->where('id',$input['id']);
        $update = $this->db->update('user', $data);
        if($update)
        {
            $this->response(['OK'], 200);
        }   
        else
        {
            $this->response(array('status' => 'fail', 502));
        }
    }

    public function index_delete()
    {
        $apikey = $this->get('api_key');
        $isApiKeyValid = $this->APIModel->checkAPIKey($apikey);
        if ($isApiKeyValid == NULL) {
            $this->response('ACCESS DENIED', 502);
            return;
        }
        $id = $this->delete('id');
        if ($id == '') {
            $delete = $this->db->truncate('user');    
        } else {
            $this->db->where('id', $id);
            $delete = $this->db->delete('user');
        }
        if($delete)
        {
            $this->response(['OK'], 200);
        }
        else
        {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
