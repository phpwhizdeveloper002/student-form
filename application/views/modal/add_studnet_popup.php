<!-- Modal HTML structure -->
<div class="" id="addNewClinicPopup" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add New Student</h5>
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
                        <input type="number" class="form-control" id="sub1" name="sub1" required>
                        <small class="text-danger" id="subject1Error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="studentAge" class="form-label">Subject 2</label>
                        <input type="number" class="form-control" id="sub2" name="sub2" required>
                        <small class="text-danger" id="subject2Error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="studentAge" class="form-label">Subject 3</label>
                        <input type="number" class="form-control" id="sub3" name="sub3" required>
                        <small class="text-danger" id="subject3Error"></small>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveStudent()">Save</button>
            </div>
        </div>
    </div>
</div>

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
