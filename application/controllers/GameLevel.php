<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class GameLevel extends REST_Controller {

function __construct($config = 'rest') {
parent::__construct($config);
$this->load->database();
}

//Menampilkan data game_level
function index_get() {
$id = $this->get('id');
if ($id == '') {
$kontak = $this->db->get('game_level')->result();
} else {
$this->db->where('id', $id);
$kontak = $this->db->get('game_level')->result();
}
$this->response($kontak, 200);
}

//Masukan function selanjutnya disini
}

function index_post()
{
    $data = array(
        'id'           => $this->post('id'),
        'nama'          => $this->post('nama'),
        'nomor'    => $this->post('nomor')
    );
    $insert = $this->db->insert('telepon', $data);
    if ($insert) {
        $this->response($data, 200);
    } else {
        $this->response(array('status' => 'fail', 502));
    }
}

?>