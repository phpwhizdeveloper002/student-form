<?php 

class Register extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_data($data) {
        // Debugging - Print data
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();


        if (!empty($data) && is_array($data)) {
            $this->db->insert('users', $data);
            
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        }

        return false;
    }
}

