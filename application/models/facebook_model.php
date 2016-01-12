<?php
class Facebook_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $config = array(
            'appId'  => '465732286935321',
            'secret' => '5d257a6a5f959a91257983f139d7705b',
            'fileUpload' => true, // Indicates if the CURL based @ syntax for file uploads is enabled.
        );

        $this->load->library('Facebook', $config);

        $user = $this->facebook->getUser();

        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.
        $profile = null;
        if($user)
        {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $profile = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }

        $fb_data = array(
            'user_profile' => $profile,
            'uid' => $user,
            'loginUrl' => $this->facebook->getLoginUrl(
                array(
                    'scope' => 'email', // app permissions
                    'redirect_uri' => site_url() // URL where you want to redirect your users after a successful login
                )
            ),
            'logoutUrl' => $this->facebook->getLogoutUrl(),
        );

        $this->session->set_userdata('fb_data', $fb_data);
    }
}
