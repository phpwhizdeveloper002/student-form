<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('Register');
	}

    public function index()
    {
        $this->load->view('register');
    }

    public function textEditor()
    {
        $this->load->view('texteditor');
    }

    public function resizeImageDemo()
    {
        $this->load->view('resizeImageDemo');
    }


    // Without ajax form submit

    // public function store()
    // {
        // $this->load->library('form_validation');
        // $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]');
        // $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        // $this->form_validation->set_rules('gender', 'Gender', 'required');
        // $this->form_validation->set_rules('comments', 'Comments', 'max_length[200]');

        // if ($this->form_validation->run() === FALSE) {
        //     $data['errors'] = validation_errors();  // Collect the errors
        //     $this->load->view('register', $data);  // Pass errors to the view
        // } else {
        //     $data = array(
        //         'name' => $this->input->post('name'),
        //         'email' => $this->input->post('email'),
        //         'gender' => $this->input->post('gender'),
        //         'comments' => $this->input->post('comments'),
        //     );
        //     $this->load->model('Register');
        //     $inserted = $this->Register->insert_data($data);

        //     if ($inserted) {
        //         redirect('Home/index');
        //     } else {
        //         $this->load->view('error_view');
        //     }
        // }
    // }

    // With ajax form submit
    public function store() {

        log_message('debug', 'POST Data: ' . json_encode($this->input->post()));
    
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('comments', 'Comments', 'required');

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

        $inserted = $this->Register->insert_data($formData);
    
        if ($inserted) {
            echo json_encode(['success' => true, 'message' => 'Form submitted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit form!']);
        }
    }
    
    // public function storeResizedImage()
    // {
    //     header('Content-Type: application/json');
    //     print_r($_POST);  // Or use $this->input->post()
    //     die();
    // }

    public function storeResizedImage()
    {
        $base64Image = $this->input->post('resizedImage');
        $width = $this->input->post('width');
        $height = $this->input->post('height');

        // Validate base64
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $data = substr($base64Image, strpos($base64Image, ',') + 1);
            $data = base64_decode($data);
            $extension = strtolower($type[1]); // png, jpg, etc.

            // Only allow image types
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo json_encode(['status' => 'error', 'message' => 'Unsupported image type']);
                return;
            }

            // Save path
            $folderPath = FCPATH . 'uploads/resized/';
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Create unique file
            $fileName = 'resized_' . uniqid() . '.' . $extension;
            $filePath = $folderPath . $fileName;
            $fileUrl = 'uploads/resized/' . $fileName;

            $data = [
                'image'  => $fileUrl,
                'height' => $height,
                'width'  => $width
            ];
            
            $this->db->insert('image_resizes', $data);

            // Save image
            if (file_put_contents($filePath, $data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Image saved successfully.',
                    'image_path' => $fileUrl
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to save image.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid base64 image data.'
            ]);
        }
    }


}
