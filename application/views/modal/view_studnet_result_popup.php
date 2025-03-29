<!-- Modal HTML structure -->
<div class="" id="studentResultPopup" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Student Result</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <p id="studentId">SID : <span><?php echo $resultData['sid']; ?></span></p>
                <p id="studentId">Semester : <?php echo $resultData['sam']; ?></p>
                <p id="studentName">Username : <?php echo $resultData['name']; ?></p>
                <p id="studentsub1">Subject 1 : <?php echo $resultData['sub1']; ?></p>
                <p id="studentsub2">Subject 2 : <?php echo $resultData['sub2']; ?></p>
                <p id="studentsub3">Subject 3 : <?php echo $resultData['sub3']; ?></p>
                <p id="total">Total marks : <?php echo $resultData['total']; ?></p>
                <p id="percentage">Total percentage : <?php echo $resultData['percentage']; ?></p>
                <p id="grade">Grade : <?php echo $resultData['grade']; ?></p>
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