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

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load the database.
        $this->load->database();

        // Load required helpers.
        $this->load->helper(array('url', 'html'));

        // Load libs
        $this->load->library(array('ion_auth', 'gravatar', 'parser'));

        // Load Models
        $this->load->model('categories_m', 'categories');
        $this->load->model('discussions_m', 'discussions');
        $this->load->model('posts_m', 'posts');
    }

    public function render($page, $data = null, $layout = 'default', $with_hero = false, $hero_data = null)
    {
        $header = array(
            'title' => 'Yeti Forums',
        );

        $navigation = array(

        );

        // Grab the categories from the database.
        $categories = $this->categories->getCategories();

        if ($categories) {
            foreach($categories as $category) {
                $category->permalink = site_url($category->slug);
            }
        }

        $sidebar = array(
            'categories' => $categories,
            'start_a_discussion' => anchor(site_url('discussion/create'), 'Start a Discussion', array('class' => 'button is-info is-block')),
        );

        $footer = array(

        );

        if ($with_hero)
        {
            $hero = $this->parser->parse('hero', $hero_data, true);
        } else {
            $hero = null;
        }

        $template_data = array(
            'header' => $this->parser->parse('header', $header, true),
            'navigation' => $this->parser->parse('navigation', $navigation, true),
            'hero' => $hero,
            'sidebar' => $this->parser->parse('sidebar_left', $sidebar, true),
            'content' => $this->parser->parse($page, $data, true),
            'footer' => $this->parser->parse('footer', $footer, true),
        );

        $this->parser->parse('layouts/'.$layout, $template_data);
    }

    public function renderHero($page, $data = null, $hero_data = null, $layout = 'default_hero')
    {
        $header = array(
            'title' => 'Yeti Forums',
        );

        $navigation = array(

        );

        $sidebar = array(
            'reply_to_discussion' => anchor(site_url('discussion/reply/'.$data['discussion_slug'].''), 'Reply to Discussion', array('class' => 'button is-info is-block')),
            'locked' => $data['locked'],
        );

        $footer = array(

        );

        $template_data = array(
            'header' => $this->parser->parse('header', $header, true),
            'navigation' => $this->parser->parse('navigation', $navigation, true),
            'hero' => $this->parser->parse('hero', $hero_data, true),
            'sidebar' => $this->parser->parse('sidebar_right', $sidebar, true),
            'content' => $this->parser->parse($page, $data, true),
            'footer' => $this->parser->parse('footer', $footer, true),
        );

        $this->parser->parse('layouts/'.$layout, $template_data);
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */
