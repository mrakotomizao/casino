<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Optin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [];
        if($this->facebook->getUser()){
            try {
                $data['user_profile'] = $this->facebook
                    ->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }
        $this->load->view('optin', $data);
    }
/*    public function login_fb(){
        $fb = new Facebook();
        redirect($fb->login_url());

    }*/
}
