<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class categories_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

    public function getCategories()
    {
        $query = $this->db->get('categories');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getCategory($category_id)
    {

    }

}

/* End of file categories_m.php */
/* Location: ./application/models/categories_m.php */
