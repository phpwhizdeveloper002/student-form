<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form id="student-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" id="csrf_token">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <small class="text-danger" id="nameError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="sid" class="form-label">SID</label><span class="text-danger">*Please remember this sid number for register with other SEM</span>
                        <input type="number" class="form-control" id="sid" name="sid" required 
                            minlength="12" maxlength="12" oninput="validateSID(this)">
                            <small class="text-danger" id="sidError"></small>
                        <small class="text-danger" id="sidError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="sub1" class="form-label">Select Semaster</label>
                        <select class="form-control" id="sam" name="sam" required>
                            <option value="">Select semaster</option>
                            <option value="1">Semaster 1</option>
                            <option value="2">Semaster 2</option>
                            <option value="3">Semaster 3</option>
                        </select>
                        <small class="text-danger" id="semesterError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="studentAge" class="form-label">Subject 1</label>
                        <input type="number" class="form-control" min="0" max="100" id="sub1" name="sub1" required>
                        <small class="text-danger" id="subject1Error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="studentAge" class="form-label">Subject 2</label>
                        <input type="number" class="form-control" min="0" id="sub2" max="100" name="sub2" required>
                        <small class="text-danger" id="subject2Error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="studentAge" class="form-label">Subject 3</label>
                        <input type="number" class="form-control" min="0" id="sub3" max="100" name="sub3" required>
                        <small class="text-danger" id="subject3Error"></small>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveStudent()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Frontend validations here. -->
<script>
$(document).ready(function() {
    // Validate on blur event for each input field
    $('#sid').blur(function() {
        validateSIDField();
    });

    $('#name').blur(function() {
        validateNameField();
    });

    $('#sam').blur(function() {
        validateSemesterField();
    });

    $('#sub1').blur(function() {
        validateSubjects1Field();
    });

    $('#sub2').blur(function() {
        validateSubjects2Field();
    });

    $('#sub3').blur(function() {
        validateSubjects3Field();
    });

    // Validate SID: Ensure it's exactly 12 digits
    function validateSIDField() {
        var sid = $('#sid').val();
        if (sid.length != 12 || isNaN(sid)) {
            $('#sidError').text('SID must be a 12-digit number.');
        } else {
            $('#sidError').text('');
        }
    }

    // Validate Student Name
    function validateNameField() {
        var name = $('#name').val();
        if (name.trim() === '') {
            $('#nameError').text('Student Name is required.');
        } else {
            $('#nameError').text('');
        }
    }

    // Validate Semester Selection
    function validateSemesterField() {
        var semester = $('#sam').val();
        if (semester === '') {
            $('#semesterError').text('Please select a semester.');
        } else {
            $('#semesterError').text('');
        }
    }

    // Validate Subjects
    function validateSubjects1Field() {
        var sub1 = $('#sub1').val();
        if (sub1 === '') {
            $('#subject1Error').text('All subject1 fields must be filled.');
        } else {
            $('#subject1Error').text('');
        }
    }

    function validateSubjects2Field() {
        var sub2 = $('#sub2').val();
        if (sub2 === '') {
            $('#subject2Error').text('All subject2 fields must be filled.');
        } else {
            $('#subject2Error').text('');
        }
    }

    function validateSubjects3Field() {
        var sub3 = $('#sub3').val();
        if (sub3 === '') {
            $('#subject3Error').text('All subject3 fields must be filled.');
        } else {
            $('#subject3Error').text('');
        }
    }

    // Form submission event
    $('#student-form').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting immediately

        var isValid = true; // Flag to check form validity
        
        // Validate all fields before submitting
        validateSIDField();
        validateNameField();
        validateSemesterField();
        validateSubjects1Field();
        validateSubjects2Field();
        validateSubjects3Field();

        // Check if there are any errors
        if ($('#sidError').text() !== '' || $('#nameError').text() !== '' || $('#semesterError').text() !== '' || $('#subject1Error').text() !== '' || $('#subject2Error').text() !== '' || $('#subject3Error').text() !== '') {
            isValid = false;
        }

        // If form is valid, proceed with the form submission
        if (isValid) {
            // The form is valid, you can either submit it traditionally or perform any further action here
            this.submit(); // Submit the form (can be replaced by other actions if needed)
        }
    });
});
</script>

<script>
    function validateSID(input) {
        let value = input.value;
        let errorElement = document.getElementById('sidError');

        if (value.length > 12) {
            input.value = value.slice(0, 12); // Restrict input to 12 digits
        }

        if (value.length < 12) {
            errorElement.textContent = "SID must be exactly 12 digits.";
        } else {
            errorElement.textContent = "";
        }
    }
</script>

<script>
    function saveStudent(){
        
        event.preventDefault();
        var formData = new FormData($("#student-form")[0]); 
        console.log(formData);
        $.ajax({
            url: "<?= base_url('Student/saveStudent'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                
                if (response.errors) {
                    window.location.href = "<?= base_url('Student/index'); ?>"; // Redirect to display errors
                }

                if (response.exist) {
                    alert(response.exist);
                    window.location.href = "<?= base_url('Student/index'); ?>";
                }
                if (response.message) {
                    alert(response.message);
                    window.location.href = "<?= base_url('Student/index'); ?>";
                }
                
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
            }
        });
    }

</script>