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

class posts_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

    public function getDiscussionPosts($discussion_id)
    {
        $this->db->from('posts');
        $this->db->where('discussion_id', $discussion_id);

        return $this->db->get()->result();
    }

    public function getDiscussionLatestPost($discussion_id)
    {
        $this->db->from('posts');
        $this->db->where('discussion_id', $discussion_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function createPost($discussion_id, $user_id, $content)
    {
        $data = array(
            'discussion_id' => $discussion_id,
            'user_id' => $user_id,
            'content' => $content,
            'created_at' => date('Y-m-j H:i:s'),
        );

        return $this->db->insert('posts', $data);
    }

    public function countDiscussionPosts($discussion_id)
    {
        $options = array(
            'discussion_id' => $discussion_id,
        );

        $query = $this->db->get_where('posts', $options);

        return $query->num_rows();
    }

}

/* End of file posts_m.php */
/* Location: ./application/models/posts_m.php */
