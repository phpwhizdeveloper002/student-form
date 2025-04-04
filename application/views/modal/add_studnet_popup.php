<!-- Modal HTML structure -->
<div class="" id="addNewClinicPopup" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="container">
                <h2>Add student form</h2>
                    <form id="demoForm" method="POST">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Student Name</label>
                                <input type="text" class="form-control" id="name" name="name">
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
                                <input type="number" class="form-control" min="0" max="100" id="sub2" name="sub2" required>
                                <small class="text-danger" id="subject2Error"></small>
                            </div>
                            <div class="mb-3">
                                <label for="studentAge" class="form-label">Subject 3</label>
                                <input type="number" class="form-control" min="0" max="100" id="sub3" name="sub3" required>
                                <small class="text-danger" id="subject3Error"></small>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                            </div>
                    </form>

            </div>
        </div>
    </div>
</div>


<script>
   $(document).ready(function() {
        $("#demoForm").on("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            
            $.ajax({
                url: "<?= base_url('Student/demoFormSave') ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {

                    if(response.message){
                        alert(response.message);
                        window.location.href = '<?= base_url('Student/index') ?>';
                    }else if(response.exist){
                        alert(response.exist);
                        window.location.href = '<?= base_url('Student/index') ?>';
                    }else if(response.errors) {
                        window.location.href = "<?= base_url('Student/index'); ?>"; 
                    }
                    
                    $("input[name='<?= $this->security->get_csrf_token_name(); ?>']").val(response.csrf_token);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Something went wrong. Please try again.");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.close').on('click', function() {
            location.reload();
        });
    });
</script>