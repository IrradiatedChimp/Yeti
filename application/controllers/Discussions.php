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

class Discussions extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load required helpers.
        $this->load->helper('url', 'form');

        // Load libs
        $this->load->library(array('ion_auth', 'gravatar', 'form_validation'));
    }

    public function create()
    {
        // create the data object
        $data = new stdClass();

        // Form Validation Setup
        $this->form_validation->set_rules('title', 'Discussion Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === false)
        {
            // Get the categories from the database.
            $categories = $this->categories->getCategories();

            if ($categories) {
                foreach($categories as $category) {
                    $category->field = form_radio(array('name' => 'category[]', 'id' => $category->slug), $category->id, false, array('class' => 'is-checkradio has-background-color is-'.$category->class));
                    $category->label = form_label($category->name, $category->slug);
                }
            }

            $data->categories = $categories;

            $this->render('discussions/create', $data);
        } else {

                $title = $this->input->post('title');
                $content = $this->input->post('content');
                $category = implode(' ', $this->input->post('category'));

            if ($this->discussions->createDiscussion($title, $content, $category)) {
                $data->message = "Discussion created";
                redirect('/');
            } else {
                $data->error = "Failed to create the discussion";
                redirect('/');
            }

        }
    }

}

/* End of file Discussions.php */
/* Location: ./application/controllers/Discussions.php */
