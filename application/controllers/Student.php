<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('Student_model');
        
	}

	public function index()
	{
		$this->load->view('student_list');
	}

    public function store() {
        header('Content-Type: application/json');
        log_message('debug', 'POST Data: ' . json_encode($this->input->post()));
    
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('name', 'Student Name', 'required|trim');
        $this->form_validation->set_rules('sid', 'SID', 'required|numeric|exact_length[12]');
        $this->form_validation->set_rules('sam', 'Semester', 'required|in_list[1,2,3]');
        $this->form_validation->set_rules('sub1', 'Subject 1', 'required|numeric');
        $this->form_validation->set_rules('sub2', 'Subject 2', 'required|numeric');
        $this->form_validation->set_rules('sub3', 'Subject 3', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors(); // Get errors as a string
    
            // Store errors in session
            $this->session->set_flashdata('error_message', $errors);
    
            echo json_encode(['errors' => true]); // Return error response
            return;
        }
    
        $formData = $this->input->post();
        $formData['created_at'] = date('Y-m-d H:i:s');

        // total of subject
        $sub1 = isset($formData['sub1']) ? (float)$formData['sub1'] : 0;
        $sub2 = isset($formData['sub2']) ? (float)$formData['sub2'] : 0;
        $sub3 = isset($formData['sub3']) ? (float)$formData['sub3'] : 0;

        // Calculate the total
        $formData['total'] = $sub1 + $sub2 + $sub3;
        $formData['percentage'] = ($formData['total'] / 300) * 100;

        // grade here.
        if ($formData['percentage'] >= 70) {
            $formData['grade'] = 'O';
        } elseif ($formData['percentage'] >= 60) {
            $formData['grade'] = 'A';
        } elseif ($formData['percentage'] >= 50) {
            $formData['grade'] = 'B';
        } elseif ($formData['percentage'] >= 40) {
            $formData['grade'] = 'C';
        } else {
            $formData['grade'] = 'F';
        }

        $query = $this->db->get_where('students', ['sid' => $formData['sid'], 'sam' => $formData['sam']]);
        $is_exist = $query->row_array();

        if($is_exist){
            echo json_encode(['exist' => 'This semaster is complete please select other semaster!']);
            exit;
        }

        $inserted = $this->Student_model->insert_data($formData);
    
        if ($inserted) {
            echo json_encode(['message' => 'Form submitted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit form!']);
        }
    }

    public function fetchData()
    {
        $data = $this->Student_model->getStudentResults();

        echo json_encode($data);
    }

    public function getStudentData(){
        header('Content-Type: application/json');
        $studentId = $this->input->get('studentId'); 

        $query = $this->db->get_where('students', ['id' => $studentId]);
        $studentData = $query->row_array();

        if ($studentData) {
            echo json_encode(['success' => true, 'data' => $studentData]);
        } else {
            // Return failure response
            echo json_encode(['success' => false]);
        }
    }

    public function getStudentYearlyData() {
        header('Content-Type: application/json');
        $studentSid = $this->input->get('studentSid'); 

        $query = $this->db->get_where('students', ['sid' => $studentSid]);
        $studentData = $query->result_array();

        $totalPercentage = 0;
        $totalStudents = count($studentData);

        // foreach ($studentData as $student) {
        //     $totalPercentage += $student['percentage']; 
        // }

        foreach ($studentData as $student) {
            if ($student['grade'] === 'F') {
                // If the grade is 'F', set averagePercentage to 0 and break the loop
                $averagePercentage = 0;
                break;
            } else {
                $totalPercentage += $student['percentage'];
            }
        }

        $averagePercentage = $totalStudents > 0 ? $totalPercentage / $totalStudents : 0;

        // echo "<pre>";
        // print_r($studentData);
        // echo "</pre>";
        // die();

        if ($studentData) {
            echo json_encode(['success' => true, 'data' => $studentData, 'yearlyAvgPercentages' => $averagePercentage]);
        } else {
            // Return failure response
            echo json_encode(['success' => false]);
        }
    }
}
