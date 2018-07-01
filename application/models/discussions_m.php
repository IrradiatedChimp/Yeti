<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

}

/* End of file discussions_m.php */
/* Location: ./application/models/discussions_m.php */
