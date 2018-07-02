<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Name:    Yeti Forums
 * Author:  Chris Baines
 *          t3utonict3rror@gmail.com
 *
 * Created:  02.07.2018
 *
 * Requirements: PHP5 or above
 *
 * @package    Yeti Forums
 * @author     Chris Baines
 * @link       https://github.com/IrradiatedChimp/Yeti
 */

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
