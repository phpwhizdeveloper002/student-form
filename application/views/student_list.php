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

    <table class="table">
        <thead>
            <tr>
            <th scope="col">No.</th>
            <th scope="col">SID.</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

<!-- Add student model code here. -->
<?php $this->load->view('modal/add_student_modal'); ?>

<!-- Result model code here. --->
<?php $this->load->view('modal/result_modal'); ?>

<!-- Yearly result model code here. -->
<?php $this->load->view('modal/yearly_result_model'); ?>

<div class="modal hide fade px-3" id="addNewClinicPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function(){
        $.ajax({
            url: "<?= base_url('Student/fetchData'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let tableBody = $('table tbody');
                tableBody.empty();

                $.each(response, function(index, item) {
                    let row = `<tr>
                                <th scope="row">${item.id}</th>
                                <th>${item.sid}</th>
                                <td>${item.name}</td>
                                <td>
                                   <?php /* <button class="btn btn-warning" onclick="studentResult(${item.id})">View result</button> */ ?>
                                    <button class="btn btn-warning" onclick="studentYearlyResult(${item.sid})">Yearly result</button>
                                </td>
                            </tr>`;
                    tableBody.append(row);
                });
                if (response.length === 0) {
                    let noDataRow = `<tr>
                                        <td colspan="9" class="text-center">No data found</td>
                                    </tr>`;
                    tableBody.append(noDataRow);
                }
            },
            error: function() {
                alert('Failed to fetch data.');
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

    function studentResult(studentId) {
        
        $.ajax({
            url:  "<?= base_url('Student/getStudentData'); ?>",
            type: 'GET',
            data: { studentId: studentId },
            success: function(response) {
                console.log(response)
                if (response.success && response.data) {
                    document.getElementById("studentId").innerText = "Student ID: " + studentId;
                    document.getElementById("studentName").innerText = "Name: " + response.data.name;
                    document.getElementById("studentsub1").innerText = "Subject 1: " + response.data.sub1;
                    document.getElementById("studentsub2").innerText = "Subject 2: " + response.data.sub2;
                    document.getElementById("studentsub3").innerText = "Subject 3: " + response.data.sub3;
                    document.getElementById("total").innerText = "total: " + response.data.total;
                    document.getElementById("percentage").innerText = "Percentage: " + response.data.percentage;
                    document.getElementById("grade").innerText = "Grade: " + response.data.grade;

                    var myModal = new bootstrap.Modal(document.getElementById('resultModal'));
                    myModal.show();
                } else {
                    alert("Failed to fetch student data");
                }
            },
            error: function() {
                alert("An error occurred while fetching data");
            }
        });
    }

    function studentYearlyResult(studentSid) {
        $.ajax({
            url:  "<?= base_url('Student/getStudentYearlyData'); ?>",
            type: 'GET',
            data: { studentSid: studentSid },
            success: function(response) {
                console.log(response);
                
                if (response.success) {

                    var table = '<table class="table table-bordered">';
                    table += '<thead><tr>';
                    table += '<th>Student ID</th>';
                    table += '<th>Name</th>';
                    table += '<th>Subject 1</th>';
                    table += '<th>Subject 2</th>';
                    table += '<th>Subject 3</th>';
                    table += '<th>Total</th>';
                    table += '<th>Percentage</th>';
                    table += '<th>Grade</th>';
                    table += '<th>SEM</th>';
                    table += '<th>Action</th>';
                    table += '</tr></thead>';
                    table += '<tbody>';

                    $.each(response.data, function(index, item) {
                        var row = `<tr>
                                    <td>${item.sid}</td>
                                    <td>${item.name}</td>
                                    <td>${item.sub1}</td>
                                    <td>${item.sub2}</td>
                                    <td>${item.sub3}</td>
                                    <td>${item.total}</td>
                                    <td>${item.percentage}</td>
                                    <td>${item.grade}</td>
                                    <td>${item.sam}</td>
                                    <td>
                                        <button class="btn btn-warning" onclick="studentResult(${item.id})">View result</button>
                                    </td>
                                </tr>`;
                        table += row;
                    });

                    table += '</tbody></table>';

                    // Insert the table into the modal
                    document.getElementById("modalContent").innerHTML = table;
                    let avgPercentage = response.yearlyAvgPercentages;
                    $('#avg').html(`<p><strong>Average Percentage: </strong>${avgPercentage}%</p>`);

                    // Show the modal
                    var myModal = new bootstrap.Modal(document.getElementById('yearlyResultModal'));
                    myModal.show();
                } else {
                    document.getElementById("modalContent").innerHTML = "No data found for Student ID: " + studentSid;
                    var myModal = new bootstrap.Modal(document.getElementById('yearlyResultModal'));
                    myModal.show();
                }
            }
        });
    }
</script>
</body>
</html>