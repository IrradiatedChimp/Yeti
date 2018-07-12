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

        // Load required models.
        $this->load->model('categories_m', 'categories');
        $this->load->model('discussions_m', 'discussions');
        $this->load->model('posts_m', 'posts');
    }

    public function index($slug = false)
    {

        if (!$slug) {

            // Get the discussions from the database.
            $discussions = $this->discussions->getAllDiscussions();

            if ($discussions) {

                $data['has_discussions'] = TRUE;

                foreach($discussions as $discussion) {

                    // Get the post count.
                    $discussion->post_count = $this->posts->countDiscussionPosts($discussion->id);

                    if($discussion->post_count > 0) {

                        // The discussion has posts.
                        $discussion->latest_post = $this->posts->getDiscussionLatestPost($discussion->id);

                        // Get the user object.
                        $user = $this->ion_auth->user($discussion->user_id)->row();

                        // Build the data blocks for the view.
                        $block_data = array(
                            'last_reply_by' => anchor( site_url('users/'.$user->username), $user->username),
                            'last_reply_time' => $discussion->latest_post->created_at,
                            'permalink' => anchor( site_url('discussion/view/'.$discussion->slug), $discussion->title),
                            'content' => PREG_REPLACE('#<br\s*?/?>#i', "\n", $discussion->latest_post->content),
                            'is_sticky' => $discussion->is_sticky,
                            'avatar' => img($this->gravatar->get($user->email)),
                            'category' => '<span class="tag is-'.$discussion->category_class.'">'.$discussion->category_name.'</span>',
                            'post_count' => $this->posts->countDiscussionPosts($discussion->id),
                        );

                        // Build the content blocks and pre-populate the information.
                        if ($discussion->is_sticky == 1 && $discussion->is_closed == 1) {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_sticky_closed_block', $block_data, true);
                        } elseif ($discussion->is_sticky == 1) {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_sticky_block', $block_data, true);
                        } elseif ($discussion->is_closed == 1) {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_closed_block', $block_data, true);
                        } else {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_regular_block', $block_data, true);
                        }
                    }
                }
            }

            // Send the data to the page render.
            $this->render('forums/index', $data);

        } else {

            // Get the category ID.
            $category_id = $this->categories->getCategoryIDFromSlug($slug);

            // Get the category data.
            $category = $this->categories->getCategory($category_id);

            // Get the discussions from the database.
            $discussions = $this->discussions->getCategoryDiscussions($category_id);

            if ($discussions) {

                $data['has_discussions'] = TRUE;

                foreach ($discussions as $discussion) {

                    // Get the post count.
                    $discussion->post_count = $this->posts->countDiscussionPosts($discussion->id);

                    if ($discussion->post_count > 0) {

                        $discussion->latest_post = $this->posts->getDiscussionLatestPost($discussion->id);

                        // Get the user object.
                        $user = $this->ion_auth->user($discussion->user_id)->row();

                        // Build the data blocks for the view.
                        $block_data = array(
                            'last_reply_by' => anchor( site_url('users/'.$user->username), $user->username),
                            'last_reply_time' => $discussion->latest_post->created_at,
                            'permalink' => anchor( site_url('discussion/view/'.$discussion->slug), $discussion->title),
                            'content' => PREG_REPLACE('#<br\s*?/?>#i', "\n", $discussion->latest_post->content),
                            'is_sticky' => $discussion->is_sticky,
                            'avatar' => img($this->gravatar->get($user->email)),
                            'category' => '<span class="tag is-'.$discussion->category_class.'">'.$discussion->category_name.'</span>',
                            'post_count' => $this->posts->countDiscussionPosts($discussion->id),
                        );

                        // Build the content blocks and pre-populate the information.
                        if ($discussion->is_sticky == 1 && $discussion->is_closed == 1) {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_sticky_closed_block', $block_data, true);
                        } elseif ($discussion->is_sticky == 1) {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_sticky_block', $block_data, true);
                        } elseif ($discussion->is_closed == 1) {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_closed_block', $block_data, true);
                        } else {
                            $data['discussions'][]['block'] = $this->parser->parse('forums/blocks/discussion_regular_block', $block_data, true);
                        }
                    }
                }
            }

            // Add some data for the hero.
            $hero_data = array(
                'text_1' => $category->name,
                'text_2' => $category->description,
            );

            // Send the data to the page renderer.
            $this->render('forums/category_view', $data, 'default', true, $hero_data);

        }
    }
}

/* End of file Forums.php */
/* Location: ./application/controllers/Forums.php */
