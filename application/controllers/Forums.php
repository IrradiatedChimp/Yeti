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

class Forums extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load the database.
        $this->load->database();

        // Load required helpers.
        $this->load->helper('url');

        // Load required models.
        $this->load->model('categories_m', 'categories');
        $this->load->model('discussions_m', 'discussions');
        $this->load->model('posts_m', 'posts');

        $this->load->library(array('ion_auth', 'gravatar'));
    }

    public function index($slug = false)
    {
        // create the data object
        $data = new stdClass();

        if (!$slug) {

            // Get the discussions from the database.
            $discussions = $this->discussions->getAllDiscussions();

            if ($discussions) {

                foreach($discussions as $discussion) {

                    $discussion->posts = $this->posts->getDiscussionPosts($discussion->id);
                    $discussion->count_posts = count($discussion->posts);

                    if($discussion->count_posts > 0) {

                        // The discussion has posts.
                        $discussion->latest_post = $this->posts->getDiscussionLatestPost($discussion->id);

                        // Get the user object.
                        $user = $this->ion_auth->user($discussion->latest_post->user_id)->row();

                        $discussion->latest_post->author = $user->username;
                        $discussion->permalink = site_url('discussion/view/'.$discussion->slug);
                        $discussion->latest_post->avatar = $this->gravatar->get($user->email);
                    }
                }

            }

            $data->discussions = $discussions;

            // Send the data to the page render.
            $this->render('forums/index', $data);

        } else {

            echo 'This would be the category page.';

        }
    }

}

/* End of file Forums.php */
/* Location: ./application/controllers/Forums.php */
