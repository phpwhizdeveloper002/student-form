<!-- Modal HTML structure -->
<div class="" id="studentYearlyResultPopup" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add New Student</h5>
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
                                <button class="btn btn-warning" onclick="studentResult(<?php echo $student['id']; ?>)">View result</button>
                                <button class="btn btn-warning" onclick="viewStudentResult(<?php echo $student['id']; ?>)">View student result</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.close').on('click', function() {
            location.reload();
        });
    });
</script>
