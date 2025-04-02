<!-- Modal HTML structure -->
<div class="" id="addNewClinicPopup" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="student-form" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="csrf_token_1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <small class="text-danger" id="nameError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="sid" class="form-label">SID</label><span class="text-danger">*Please remember this sid number for register with other SEM</span>
                        <input type="number" class="form-control" id="sid" name="sid" value="233324234234" required 
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
                        <input type="number" class="form-control" id="sub1" name="sub1" value="45" required>
                        <small class="text-danger" id="subject1Error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="studentAge" class="form-label">Subject 2</label> 
                        <input type="number" class="form-control" id="sub2" name="sub2" value="45" required>
                        <small class="text-danger" id="subject2Error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="studentAge" class="form-label">Subject 3</label>
                        <input type="number" class="form-control" id="sub3" name="sub3" value="34" required>
                        <small class="text-danger" id="subject3Error"></small>
                    </div>
                </div>
                

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveStudent(event)">Save</button>
                    <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function saveStudent(event) {
        event.preventDefault(); // Prevent default form submission
        var form = document.getElementById("student-form"); 
        var formData = new FormData(form); 
        console.log(formData);

        // Get CSRF token safely
        var csrfTokenField = document.getElementById("csrf_token_1");
        if (csrfTokenField) {
            formData.append("<?= $this->security->get_csrf_token_name(); ?>", csrfTokenField.value);
        }

        $.ajax({
            url: "<?= base_url('Student/saveStudent'); ?>",
            method: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert("Data successfully stored!");
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
            },
        });
    }
</script>
