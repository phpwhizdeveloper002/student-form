<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container{
            margin-top: 10%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-end">
        <button class="btn btn-success" onclick="addNewStudentPopup()">Add student</button>
        <!-- <button class="btn btn-success" onclick="addStudentPopup()">Add New student</button> -->
    </div>

    <?php if ($this->session->flashdata('error_message')): ?>
        <div class="alert alert-danger" id="error-alert">
            <?= $this->session->flashdata('error_message'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success_message')): ?>
        <div class="alert alert-success" id="success-alert">
            <?= $this->session->flashdata('success_message'); ?>
        </div>
    <?php endif; ?>

    <table class="table" id="student_list">
        <thead>
            <tr>
            <th scope="col">SID.</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

<!-- Add student model code here. -->
<?php $this->load->view('modal/add_student_modal'); ?>

<div class="modal hide fade px-3" id="addNewClinicPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal hide fade px-3" id="studentYearlyResultPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal hide fade px-3" id="studentResultPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    $(document).ready(function() {
        $.ajax({
            url: "<?= base_url('Student/showStudentData'); ?>",
            type: 'GET',
            dataType: 'html', 
            success: function(response) {
                let tableBody = $('#student_list tbody');
                tableBody.empty();

                if (response.trim()) {
                    tableBody.append(response);
                } 
            },
            error: function() {
                alert("An error occurred while fetching student data.");
            }
        });
    });

</script>

<script>
    // Hide alerts after 30 seconds (30000 milliseconds)
    setTimeout(function() {
        document.getElementById('error-alert')?.remove();
        document.getElementById('success-alert')?.remove();
    }, 3000);
</script>

<script>
    function addNewStudentPopup() {
        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('addStudentModal'));
        myModal.show();
    }

    // ----------------Old code of student result

    function viewstudentResultPopup(studentId) {
        $.ajax({
            url:  "<?= base_url('Student/viewStudentResult'); ?>",
            type: 'POST',
            dataType: "html",
            data: { 
                studentId: studentId,
                '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>' 
            },
            cache: false,
            success: function(response) {
                console.log(response);
                $("#studentResultPopup").html(response);

                $('#studentResultPopup').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            }
        });
    }

    function viewStudentYearlyResultPopup(studentSid) {
 
        $.ajax({
            url: "<?= base_url('Student/viewStudentYearlyResultPopup'); ?>",
            type: 'POST',
            dataType: "html",
            data: { 
                studentSid: studentSid,
                '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>' 
            },
            cache: false,
            success: function(response) { 
                $("#studentYearlyResultPopup").html(response);

                $('#studentYearlyResultPopup').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            }
        });
    }

    function addStudentPopup() {

        $.ajax({
            url: "<?= base_url('Student/ajaxSaveStudent'); ?>",
            type: 'POST',
            dataType: "html",
            data: {
                'csrf_token': "<?= $this->security->get_csrf_hash(); ?>"
            },
            cache: false,
            success: function(response) {           
                $("#addNewClinicPopup").html(response);

                $('#addNewClinicPopup').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            }
        });
    }
</script>
</body>
</html>