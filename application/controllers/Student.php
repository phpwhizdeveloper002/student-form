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

    public function list()
	{
		$this->load->view('demo_list');
	}

    // public function saveStudent() {
    //     header('Content-Type: application/json');
    //     log_message('debug', 'POST Data: ' . json_encode($this->input->post()));
    
    //     if (!$this->input->is_ajax_request()) {
    //         echo json_encode(['success' => false, 'message' => 'Invalid request']);
    //         return;
    //     }

    //     $this->load->library('form_validation');

    //     // Set validation rules
    //     $this->form_validation->set_rules('name', 'Student Name', 'required|trim');
    //     $this->form_validation->set_rules('sid', 'SID', 'required|numeric|exact_length[12]');
    //     $this->form_validation->set_rules('sam', 'Semester', 'required|in_list[1,2,3]');
    //     $this->form_validation->set_rules('sub1', 'Subject 1', 'required|numeric');
    //     $this->form_validation->set_rules('sub2', 'Subject 2', 'required|numeric');
    //     $this->form_validation->set_rules('sub3', 'Subject 3', 'required|numeric');

    //     if ($this->form_validation->run() == FALSE) {
    //         $errors = validation_errors(); // Get errors as a string
    
    //         // Store errors in session
    //         $this->session->set_flashdata('error_message', $errors);
    
    //         echo json_encode(['errors' => true]); // Return error response
    //         return;
    //     }
    
    //     $formData = $this->input->post();

    //     if(!empty($formData)){

    //         $formData['created_at'] = date('Y-m-d H:i:s');

    //         // total of subject
    //         $sub1 = isset($formData['sub1']) ? (float)$formData['sub1'] : 0;
    //         $sub2 = isset($formData['sub2']) ? (float)$formData['sub2'] : 0;
    //         $sub3 = isset($formData['sub3']) ? (float)$formData['sub3'] : 0;

    //         // Calculate the total
    //         $formData['total'] = $sub1 + $sub2 + $sub3;
            
    //         if(!empty($formData['total'])){
    //             $formData['percentage'] = ($formData['total'] / 300) * 100;
    //         }

    //         // grade here.
    //         if(!empty($formData['percentage'])){
    //             if ($formData['percentage'] >= 70) {
    //                 $formData['grade'] = 'O';
    //             } elseif ($formData['percentage'] >= 60) {
    //                 $formData['grade'] = 'A';
    //             } elseif ($formData['percentage'] >= 50) {
    //                 $formData['grade'] = 'B';
    //             } elseif ($formData['percentage'] >= 40) {
    //                 $formData['grade'] = 'C';
    //             } else {
    //                 $formData['grade'] = 'F';
    //             }
    //         }
            

    //         $where = ['sid' => $formData['sid'], 'sam' => $formData['sam']];
    //         $is_exist = $this->Student_model->CheckSemester($where);

    //         if($is_exist){
    //             echo json_encode(['exist' => 'This semaster is complete please select other semaster!']);
    //             exit;
    //         }

    //         $inserted = $this->Student_model->insert_data($formData);
        
    //         if ($inserted) {
    //             echo json_encode(['message' => 'Form submitted successfully!']);
    //         } else {
    //             echo json_encode(['success' => false, 'message' => 'Failed to submit form!']);
    //         }
    //     }
        
    // }

    public function saveStudent() {
        // header('Content-Type: application/json');
        // $formData = $this->input->post();
    
        echo "<pre>";
        print_r($this->input->post());
        echo "</pre>";
        die();
    }
    

    public function fetchData()
    {
        $data = $this->Student_model->getStudentResults();

        echo json_encode($data);
    }


    public function showStudentData() {
        $data['studentData'] = $this->Student_model->getStudentResults();

        echo $this->load->view('show_student_data', $data, true);
    }
    

    public function getStudentData(){
        header('Content-Type: application/json');
        $studentId = $this->input->get('studentId'); 

        if(!empty($studentId)) {
            $where =  ['id' => $studentId];
            $resultData = $this->Student_model->getStudentData($where);

            if(!empty($resultData)) {
                $studentData = [
                    'success' => true,
                    'data' => $resultData
                ];
            }

            // echo json_encode($studentData);
            if ($studentData) {
                echo json_encode($studentData);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function getStudentYearlyData() {
        header('Content-Type: application/json');
        $studentSid = $this->input->get('studentSid'); 

        $where =  ['sid' => $studentSid];
        $studentData = $this->Student_model->getStudentYearlyData($where);

        if(!empty($studentData)) {
            $totalPercentage = 0;
            $totalStudents = count($studentData);

            foreach ($studentData as $student) {
                if ($student['grade'] === 'F') {
                    $averagePercentage = 0;
                    break;
                } else {
                    $totalPercentage += $student['percentage'];
                }
            }

            $averagePercentage = $totalStudents > 0 ? $totalPercentage / $totalStudents : 0;
        }
        
        $data = [
            'success' => true, 'data' => $studentData, 'yearlyAvgPercentages' => $averagePercentage
        ];

        if ($data) {
            echo json_encode($data);
        } else {
            // Return failure response
            echo json_encode(['success' => false]);
        }
    }

    public function ajaxSaveStudent() {

        $data['company'] = "AsdfFasdf";
        
        echo $this->load->view('modal/add_studnet_popup', $data, true);
    }  
    
    public function viewStudentResult() {
        
        $studentId = $this->input->post('studentId'); 

        if(!empty($studentId)) {
            $where =  ['id' => $studentId];
            $resultData = $this->Student_model->getStudentData($where);

            if(!empty($resultData)) {
                $data = [
                    'resultData' => $resultData
                ];
            }
        }
        echo $this->load->view('modal/view_studnet_result_popup', $data, true);
    }

    public function viewStudentYearlyResultPopup()
    {
        $studentSid = $this->input->post('studentSid');

        $where = ['sid' => $studentSid];
        $studentData = $this->Student_model->getStudentYearlyData($where);
       
        if(!empty($studentData)) {
            $totalPercentage = 0;
            $totalStudents = count($studentData);

            foreach ($studentData as $student) {
                if ($student['grade'] === 'F') {
                    $averagePercentage = 0;
                    break;
                } else {
                    $totalPercentage += $student['percentage'];
                }
            }

            $averagePercentage = $totalStudents > 0 ? $totalPercentage / $totalStudents : 0;
        }     
        
        $data = [
            'studentData' => $studentData,
            'averagePercentage' => $averagePercentage
        ];
       
        echo $this->load->view('modal/view_studnet_yearly_result_popup', $data, true);
    }

    public function demoAjaxSubmitFormPopup() {
        $data['demo'] = "Demo";

        echo $this->load->view('modal/add_mode', $data, true);
    }

    public function demoFormSave()
    {

        // $data = $this->input->post();

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();

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
        // echo "<pre>";
        // print_r($formData);
        // echo "</pre>";
        // die();

        if(!empty($formData)){

            $formData['created_at'] = date('Y-m-d H:i:s');

            // total of subject
            $sub1 = isset($formData['sub1']) ? (float)$formData['sub1'] : 0;
            $sub2 = isset($formData['sub2']) ? (float)$formData['sub2'] : 0;
            $sub3 = isset($formData['sub3']) ? (float)$formData['sub3'] : 0;

            // Calculate the total
            $formData['total'] = $sub1 + $sub2 + $sub3;
            
            if(!empty($formData['total'])){
                $formData['percentage'] = ($formData['total'] / 300) * 100;
            }

            // grade here.
            if(!empty($formData['percentage'])){
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
            }
            

            $where = ['sid' => $formData['sid'], 'sam' => $formData['sam']];
            $is_exist = $this->Student_model->CheckSemester($where);

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
    }
}
