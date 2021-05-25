<?php
defined('BASEPATH') or exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }

    function index_post()
    {
        $data = array(
            'username'           => $this->post('username'),
            'password'    => $this->post('password')
        );
        $query = $this->db->query('SELECT * FROM USER WHERE USER_USERNAME="' . $this->post('username') . '"');
        if ($query->num_rows() > 0) {
            $data_user = $query->row();
            if (password_verify($this->post('password'), $data_user->USER_PASSWORD)) {
                $this->response(array('id' => $data_user->USER_ID));
            } else {
                $this->response(array('status' => 'fail', 502));
            }
        }
    }
}
