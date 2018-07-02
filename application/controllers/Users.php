<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load required libs.
        $this->load->library(array('form_validation', 'ion_auth'));

        // Load required helpers.
        $this->load->helper(array('url', 'form'));
    }

    public function log_in()
    {

    }

    public function log_out()
    {

    }

    public function sign_up()
    {

    }

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
