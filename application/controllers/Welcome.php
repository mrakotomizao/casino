<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $user = $this->facebook->getUser();
        var_dump($_SESSION);

        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
            $this->facebook->destroySession();
        }

        if ($user) {
            $data['logout_url'] = site_url('welcome/logout'); // Logs off application

        } else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url(),
                'scope' => array("email") // permissions here
            ));
        }
        $this->load->view('welcome_message', $data);

    }

    public function logout()
    {

        // Logs off session from website
        $this->facebook->destroySession();
        // Make sure you destory website session as well.

        redirect('welcome/login');
    }

}