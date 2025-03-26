<?php 

class Student_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // public function getStudentResults()
    // {
    //     $this->db->order_by('id', 'DESC');
    //     $query = $this->db->get('students');
    //     return $query->result_array();
    // }

    public function getStudentResults()
    {
        $this->db->select('*');
        $this->db->group_by('sid');  // Group by the 'sid' to get unique records
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('students');
        return $query->result_array();
    }


    public function insert_data($data) {

        if (!empty($data) && is_array($data)) {
            $this->db->insert('students', $data);
            
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        }

        return false;
    }
}

