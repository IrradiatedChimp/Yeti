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

class Install extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load in installation model.
        $this->load->model('install_m');

        // Load in required helpers.
        $this->load->helper(array('form', 'cookie', 'url'));

        // Load in required libraries.
        $this->load->library(array('form_validation', 'session', 'parser'));

        // Load language.
        $this->lang->load('install');
    }

    public function index()
    {
        $this->step1();
    }

    /**
    * Step 1 - Database Credentials
    */
    public function step1()
    {
        // Create a data object array.
        $data = (object)[];

        // Form Validation Setup
        $this->form_validation->set_rules('db_hostname', 'Hostname', 'required|trim');
        $this->form_validation->set_rules('db_username', 'Username', 'required|trim');
        $this->form_validation->set_rules('db_password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {

            // There has been an error with the validation, display the validation errors.
            $this->render('install/step1', $data);

        } else {

            // Grab input from the form and store in variables.
            $hostname = $this->input->post('db_hostname');
            $username = $this->input->post('db_username');
            $password = $this->input->post('db_password');

            // Replace the hostname in the database.php file.
            $find = "'hostname' =>";
            $replace = "\t" . "'hostname' => '" . $hostname . "'," . "\n";

            if ($this->install_m->editDatabaseConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = $this->lang->line('install_hostname_error');

                // Send the page and data to the renderer.
                $this->render('install/step1', $data);

                return;
            }

            // Replace the username in the database.php file.
            $find = "'username' =>";
            $replace = "\t" . "'username' => '" . $username . "'," . "\n";

            if ($this->install_m->editDatabaseConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = $this->lang->line('install_username_error');

                // Send the page and data to the renderer.
                $this->render('install/step1', $data);

                return;
            }

            // Replace the password in the database.php file.
            $find = "'password' =>";
            $replace = "\t" . "'password' => '" . $password . "'," . "\n";

            if ($this->install_m->editDatabaseConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = $this->lang->line('install_password_error');

                // Send the page and data to the renderer.
                $this->render('install/step1', $data);

                return;
            }

            // Test the database connection.
            if ($this->install_m->testDatabaseConnection($hostname, $username, $password) === true) {

                // Redirect to step 2 of the installer.
                redirect('install/step2');

            } else {

                // Connection to the database failed, show an error message and the form again.
                $data->error = $this->lang->line('install_database_test_error');

                // Reset the application/config/database.php config file back to default values.

                /* Hostname */
                $find = "'hostname' =>";
                $replace = "\t" . "'hostname' => 'localhost'," . "\n";
                $this->install_m->editDatabaseConfigFile($find, $replace);

                /* Username */
                $find = "'username' =>";
                $replace = "\t" . "'username' => ''," . "\n";
                $this->install_m->editDatabaseConfigFile($find, $replace);

                /* Password */
                $find = "'password' =>";
                $replace = "\t" . "'password' => ''," . "\n";
                $this->install_m->editDatabaseConfigFile($find, $replace);

                // Destroy the variables holding the connection information.
                unset($hostname, $username, $password);

                // Send the page and data to the renderer.
                $this->render('install/step1', $data);

            }
        }

    }

    public function step2()
    {
        // Create a data object array.
        $data = (object)[];

        // Form Validation Setup
        $this->form_validation->set_rules('database_name', 'Database Name', 'trim|required|alpha_numeric|max_length[64]');

        if ($this->form_validation->run() === false) {

            // There has been an error with the validation, display the validation errors.
            $this->render('install/step2', $data);

        } else {

            $database_name = $this->input->post('database_name');
            setcookie('db_name', $database_name);

            if ($this->install_m->createDatabase($database_name) === true) {

                // Everything is okay, move on to step 3.
                redirect('install/step3', $data);

            } else {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = $this->lang->line('install_database_error');

                // Send the page and data to the renderer.
                $this->render('install/step2', $data);
            }
        }
    }

    public function step3()
    {
        // Create a data object array.
        $data = (object)[];

        // Form Validation Setup
        $this->form_validation->set_rules('db_name_cookie', 'Database name', 'trim|required|alpha_dash|max_length[64]');

        if ($this->form_validation->run() === false) {

            // There has been an error with the validation, display the validation errors.
            $this->render('install/step3', $data);

        } else {

            $database_name = $_COOKIE['db_name'];

            if ($this->install_m->createTables($database_name) === true) {

                // Everything is okay, move on to step 4.
                redirect('install/step4', $data);

            } else {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = $this->lang->line('install_tables_error');

                // Send the page and data to the renderer.
                $this->render('install/step3', $data);

            }
        }
    }

    public function step4()
    {
        // Create a data object array.
        $data = (object)[];

        // Delete the cookie we created before.
		if (isset($_COOKIE['db_name'])) {
			// empty value and expiration one hour before
			setcookie('db_name', '', time() - 3600);
		}

        // Form Validation Setup
        $this->form_validation->set_rules('base_url', 'Base Url', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('forum_title', 'Forum Title', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('admin_username', 'Username', 'trim|required|alpha_numeric|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('admin_email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('admin_confirm_password', 'Password Confirmation', 'trim|required|min_length[6]|matches[admin_password]');

        if ($this->form_validation->run() === false) {

            // There has been an error with the validation, display the validation errors.
            $this->render('install/step4', $data);

        } else {

            // Load Ion Auth
            $this->load->library('ion_auth');

            // Setup variables from the form inputs.
            $base_url = $this->input->post('base_url');
            $forum_title = addslashes($this->input->post('forum_title'));
            $username = $this->input->post('admin_username');
            $email = $this->input->post('admin_email');
            $password = $this->input->post('admin_password');
            $group = array('1');

            // Create the admin user.
            if ($this->ion_auth->register($username, $password, $email, array('first_name' => 'Admin', 'last_name' => 'User'), $group) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $this->error = 'There was a problem trying to create the admin user. Please try again.';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);
            }

            // replace site title in the ion_auth.php config file
            $find    = '$config[\'site_title\'] =';
            $replace = '$config[\'site_title\'] = \'' . $forum_title . '\';' . "\n";

            if ($this->install_m->editIonAuthConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The site title in your Ion Auth config file cannot be replaced...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // replace admin email in the ion_auth.php config file
            $find    = '$config[\'admin_email\'] =';
            $replace = '$config[\'admin_email\'] = \'' . $email . '\';' . "\n";

            if ($this->install_m->editIonAuthConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The admin email in your Ion Auth config file cannot be replaced...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // Set the site email address.
            $find    = '$config[\'site_email\'] =';
            $replace = '$config[\'site_email\'] = \'' . $email . '\';' . "\n";

            if ($this->install_m->editForumConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The Forum email address in your forum config file cannot be updated...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // change session driver to session stored in database
            $find    = '$config[\'sess_driver\'] =';
            $replace = '$config[\'sess_driver\'] = \'' . 'database' . '\';' . "\n";

            if ($this->install_m->editMainConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The session driver on your main config file cannot be updated...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // change session path to session stored in database
            $find    = '$config[\'sess_save_path\'] =';
            $replace = '$config[\'sess_save_path\'] = \'' . 'ci_sessions' . '\';' . "\n";

            if ($this->install_m->editMainConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The session path on your main config file cannot be updated...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // replace base url in the config.php config file
            $find    = '$config[\'base_url\'] =';
            $replace = '$config[\'base_url\'] = \'' . $base_url . '\';' . "\n";

            if ($this->install_m->editMainConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The base url on your main config file cannot be replaced...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // replace site title in the forum.php config file
            $find    = '$config[\'forum_title\'] =';
            $replace = '$config[\'forum_title\'] = \'' . $forum_title . '\';' . "\n";

            if ($this->install_m->editForumConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The Forum title on your forum config file cannot be replaced...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // replace default route in the routes.php config file
            $find    = '$route[\'default_controller\'] =';
            $replace = '$route[\'default_controller\'] = \'' . 'forums' . '\';' . "\n";

            if ($this->install_m->editRoutesConfigFile($find, $replace) !== true) {

                // An error has occured, grab the message from the install_lang.php file.
                $data->error = 'The default route on your routes config file cannot be replaced...';

                // Send the page and data to the renderer.
                $this->render('install/step4', $data);

                return;
            }

            // forum settings ok, go to the final installation step
            redirect('install/step5', $data);
        }
    }

    public function step5()
    {
        // Create a data object array.
        $data = (object)[];

        // Send the page and data to the renderer.
        $this->render('install/step5', $data);
    }

    public function deleteFiles()
    {
        /* Uncomment for live removal, disabbled during development.
        if ($this->install_m->deleteInstallationFiles()) {
            redirect('/');
            return;
        } else {
            echo 'Unable to delete the installation files, please do it manually!';
        }
        */

        redirect('/');
    }

    public function render($page, $data = NULL, $layout = 'install')
    {
        $template_data = array(
            'content' => $this->parser->parse($page, $data, true),
        );

        $this->parser->parse('layouts/'.$layout, $template_data);
    }
}

/* End of file Install.php */
/* Location: ./application/controllers/Install.php */
