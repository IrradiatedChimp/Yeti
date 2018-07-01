<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('parser');
    }

    public function render($page, $data = NULL, $layout = 'default')
    {
        // Load models
        $this->load->model('categories_m', 'categories');

        $header = array(
            'title' => 'Yeti Forums',
        );

        $navigation = array(

        );

        // Grab the categories from the database.
        $categories = $this->categories->getCategories();

        foreach($categories as $category) {
            $category->permalink = site_url($category->slug);
        }

        $sidebar = array(
            'categories' => $categories,
            'start_a_discussion' => anchor(site_url('discussion/create'), 'Start a Discussion', array('class' => 'button is-info is-block')),
        );

        $footer = array(

        );

        $template_data = array(
            'header' => $this->parser->parse('header', $header, true),
            'navigation' => $this->parser->parse('navigation', $navigation, true),
            'sidebar' => $this->parser->parse('sidebar', $sidebar, true),
            'content' => $this->parser->parse($page, $data, true),
            'footer' => $this->parser->parse('footer', $footer, true),
        );

        $this->parser->parse('layouts/'.$layout, $template_data);
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */
