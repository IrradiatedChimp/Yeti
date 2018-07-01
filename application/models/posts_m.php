<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

}

/* End of file posts_m.php */
/* Location: ./application/models/posts_m.php */
