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
        $this->db->from('categories');
        $this->db->where('id', $category_id);

        return $this->db->get()->row();
    }

}

/* End of file categories_m.php */
/* Location: ./application/models/categories_m.php */
