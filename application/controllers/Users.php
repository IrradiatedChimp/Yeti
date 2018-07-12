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

class Users extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
    }

    public function logIn()
    {

        // create the data object
        $data = array();

        // Form Validation setup.
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === false) {

            // Send the data to the page render.
            $this->render('users/log_in', $data, 'login_register');

        } else {

            // check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/', 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('users/log_in', 'refresh');
			}
        }

    }

    public function logout()
    {
        // log the user out
		$logout = $this->ion_auth->logout();

		// redirect.
		redirect('/', 'refresh');
    }

    public function signUp()
    {

    }

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
