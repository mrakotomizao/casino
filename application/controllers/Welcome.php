<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
    }

    public function login()
    {
        $fb_data = $this->session->userdata('fb_data');

        $this->load->view('welcome_message', $fb_data);

    }

    public function logout()
    {

        // Logs off session from website
        $this->facebook->destroySession();
        // Make sure you destory website session as well.

        redirect('welcome/login');
    }

}