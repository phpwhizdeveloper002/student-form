<?php if(!empty($studentData)) {

 foreach($studentData as $student) { ?> 
<tr>
    <td><?php echo $student['sid']; ?></td>
    <td><?php echo $student['name']; ?></td>
    <td>
        <?php /*<button class="btn btn-warning" onclick="studentResult(<?php echo $student['id']; ?>)">View result</button> */ ?>
        <button class="btn btn-warning" onclick="viewstudentResultPopup(<?php echo $student['id']; ?>)">View student result</button>
        <button class="btn btn-warning" onclick="viewStudentYearlyResultPopup(<?php echo $student['sid']; ?>)">View student yearly result</button>
    </td>
</tr>
<?php } }else{ ?>
    <tr><td colspan="3" class="text-center">No data available</td></tr>
<?php } ?>
