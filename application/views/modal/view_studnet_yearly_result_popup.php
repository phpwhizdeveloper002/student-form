<!-- Modal HTML structure -->
<div class="" id="studentYearlyResultPopup" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Yearly Student Result</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Subject 1</th>
                        <th scope="col">Subject 2</th>
                        <th scope="col">Subject 3</th>
                        <th scope="col">Total</th>
                        <th scope="col">Percentage</th>
                        <th scope="col">Grade</th>
                        <th scope="col">SEM</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php foreach($studentData as $student) { ?> 
                        <tr>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['sub1']; ?></td>
                            <td><?php echo $student['sub2']; ?></td>
                            <td><?php echo $student['sub3']; ?></td>
                            <td><?php echo $student['total']; ?></td>
                            <td><?php echo $student['percentage']; ?></td>
                            <td><?php echo $student['grade']; ?></td>
                            <td><?php echo $student['sam']; ?></td>
                            <td>
                                <?php /* <button class="btn btn-warning" onclick="studentResult(<?php echo $student['id']; ?>)">View result</button> */ ?>
                                <button class="btn btn-warning" onclick="viewstudentResult(<?php echo $student['id']; ?>)">View student result</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal hide fade px-3" id="studentResultPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.close').on('click', function() {
            location.reload();
        });
    });
</script>

<script>
    function viewstudentResult(studentId) {
        // alert('asdfasdf');
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
                $("#studentResultPopup").html(response);

                var myModal = new bootstrap.Modal(document.getElementById('studentResultPopup'), {
                    backdrop: 'static',
                    keyboard: false
                });
                myModal.show();
            }
        });
    }
</script>
