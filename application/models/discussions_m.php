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

class discussions_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

    public function getAllDiscussions()
    {
        // Setup the select.
        $this->db->select('
            discussions.id,
            discussions.title,
            discussions.slug,
            discussions.user_id,
            discussions.category_id,
            discussions.created_at,
            discussions.is_sticky,
            discussions.is_closed,
            categories.name as category_name,
            categories.slug as category_slug,
            categories.class as category_class,
        ');

        // Set the join.
        $this->db->join('categories', 'categories.id = discussions.category_id');

        // Setup ordering.
        $this->db->order_by('discussions.is_sticky', 'DESC');
        $this->db->order_by('discussions.created_at', 'DESC');

        $query = $this->db->get('discussions');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getCategoryDiscussions($category_id)
    {
        // Setup the select.
        $this->db->select('
            discussions.id,
            discussions.title,
            discussions.slug,
            discussions.user_id,
            discussions.category_id,
            discussions.created_at,
            discussions.is_sticky,
            discussions.is_closed,
            categories.name as category_name,
            categories.slug as category_slug,
            categories.class as category_class,
        ');

        // Set the join.
        $this->db->join('categories', 'categories.id = discussions.category_id');

        // Setup the ordering.
        $this->db->order_by('discussions.is_sticky', 'DESC');
        $this->db->order_by('discussions.created_at', 'DESC');

        // Setup some options.
        $options = array(
            'category_id' => $category_id,
        );

        // Run the query.
        $query = $this->db->get_where('discussions', $options);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getDiscussion($discussion_id)
    {
        $this->db->from('discussions');
        $this->db->where('id', $discussion_id);

        return $this->db->get()->row();
    }

    public function getIDFromSlug($discussion_slug)
    {
        $this->db->where('slug', $discussion_slug);
        $this->db->limit('1');

        return $this->db->get('discussions')->row('id');
    }

    public function createDiscussion($title, $content, $category)
    {
        // Get the user ID.
        $user = $this->ion_auth->user()->row();
        $user_id = $user->id;

        $data = array(
            'title' => $title,
            'slug' => strtolower(url_title($title)),
            'category_id' => $category,
            'created_at' => date('Y-m-j H:i:s'),
            'user_id' => $user_id,
        );

        if ($this->db->insert('discussions', $data)) {
            $discussion_id = $this->db->insert_id();

            return $this->posts->createPost($discussion_id, $user_id, $content);
        }
        return false;
    }

}

/* End of file discussions_m.php */
/* Location: ./application/models/discussions_m.php */
