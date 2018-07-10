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
        // Check if the user is logged in first.
        if (!$this->ion_auth->logged_in()) {
            redirect('users/logIn');
        }

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

    public function view($discussion_slug)
    {
        // create the data object
        $data = new stdClass();
        $hero_data = new stdClass();

        if (!$discussion_slug) {
            redirect (site_url('/'));
        } else {

            // Get the discussion id
            $discussion_id = $this->discussions->getIDFromSlug($discussion_slug);

            // Fetch the discussion from the database.
            $discussion = $this->discussions->getDiscussion($discussion_id);

            // Get the category from the database.
            $category = $this->categories->getCategory($discussion->category_id);

            // Get the post for the discussion.
            $posts = $this->posts->getDiscussionPosts($discussion_id);

            foreach ($posts as $post) {

                // Get the user object.
                $user = $this->ion_auth->user($post->user_id)->row();

                $post->avatar = $this->gravatar->get($user->email);
            }

            // See if the discussion is a sticky discussion.
            if ($discussion->is_sticky) {
                $hero_data->sticky = '<span class="icon has-text-success"><i class="fas fa-thumbtack"></i></span>';
            } else {
                $hero_data->sticky = '';
            }

            // See if the discussion is locked.
            if ($discussion->is_closed) {
                $hero_data->locked = '<span class="icon has-text-danger"><i class="fas fa-lock"></i></span>';
            } else {
                $hero_data->locked = '';
            }

            $data->posts = $posts;
            $data->discussion_slug = $discussion->slug;
            $data->sticky = $discussion->is_sticky;
            $data->locked = $discussion->is_closed;
            $hero_data->discussion_title = $discussion->title;
            $hero_data->category = '<span class="tag is-'.$category->class.'"> '.anchor( site_url($category->slug), $category->name).' </span>';

            // Send the data to the parser.
            $this->renderHero('discussions/discussion', $data, $hero_data);
        }
    }

}

/* End of file Discussions.php */
/* Location: ./application/controllers/Discussions.php */
