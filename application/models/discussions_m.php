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
        $this->db->order_by('created_at', 'DESC');
        $this->db->order_by('is_sticky', 'DESC');

        $query = $this->db->get('discussions');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
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
