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

            // Add the data to the data object.
            $data['categories'] = $categories;

            // Send the data to the page renderer.
            $this->render('discussions/create', $data);

        } else {

                $title = $this->input->post('title');
                $content = nl2br($this->input->post('content'));
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

        // Setup the text for the hero.
        $text1 = '';
        $text2 = '';

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

                // Build the avatar.
                $post->avatar = img($this->gravatar->get($user->email));

                // Build the data blocks for the view.
                $block_data = array(
                    'avatar' => img($this->gravatar->get($user->email)),
                    'content' => $post->content,
                );

                // Send the data to the block template, return and add to posts array.
                $data['posts'][]['block'] = $this->parser->parse('discussions/blocks/post_block', $block_data, true);
            }

            // See if the discussion is a sticky discussion.
            if ($discussion->is_sticky) {
                $text1.= '<span class="icon has-text-success"><i class="fas fa-thumbtack"></i></span>&nbsp;';
            }

            // See if the discussion is locked.
            if ($discussion->is_closed) {
                $text1.= '<span class="icon has-text-danger"><i class="fas fa-lock"></i></span>&nbsp;';
            }

            // Create sidebar data to send the MY_Controller.
            $data['discussion_slug'] = $discussion->slug;
            $data['locked'] = $discussion->is_closed;

            // Create hero block data.
            $text1.= $discussion->title;
            $text2.= '<span class="tag is-'.$category->class.'"> '.anchor( site_url($category->slug), $category->name).' </span>';

            $hero_data = array(
                'text_1' => $text1,
                'text_2' => $text2,
            );

            // Send the data to the parser.
            $this->renderHero('discussions/discussion', $data, $hero_data);
        }
    }

    public function reply($discussion_slug)
    {
        // Create the data object.
        $data = new stdClass();

        // Grab the discussion id from the database.
        $discussion_id = $this->discussions->getIDFromSlug($discussion_slug);

        // Get the discussion from the database.
        $discussion = $this->discussions->getDiscussion($discussion_id);

        // Setup form validation rules.
        $this->form_validation->set_rules('content', 'Content', 'required|trim');

        // Check form validation.
        if ($this->form_validation->run() === false) {

            $data->discussion_id = $discussion_id;
            $data->discussion_title = $discussion->title;

            // Send the data to the page renderer.
            $this->render('discussions/reply', $data);

        } else {

            // Grab the data from the form.
            $content = nl2br($this->input->post('content'));

            // Grab the logged in user.
            $user = $this->ion_auth->user()->row();

            if ($this->posts->createPost($discussion_id, $user->id, $content)) {

                // Post has been saved, redirect with a message

                //*TODO - Add message system
                redirect( site_url('discussion/view/'.$discussion_slug));

            } else {
                redirect('discussion/reply/'.$discussion_slug);
            }

        }
    }

}

/* End of file Discussions.php */
/* Location: ./application/controllers/Discussions.php */
