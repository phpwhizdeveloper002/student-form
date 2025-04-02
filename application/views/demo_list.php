<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <button class="btn btn-success" onclick="addStudentPopup()">Add New student</button>

    <div class="modal hide fade px-3" id="addNewDemoPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function addStudentPopup() {
        $.ajax({
            url: "<?= base_url('Student/demoAjaxSubmitFormPopup'); ?>",
            type: 'POST',
            dataType: "html",
            data: {
                '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>' 
            },
            cache: false,
            success: function(response) {           
                $("#addNewDemoPopup").html(response);

                $('#addNewDemoPopup').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            }
        });
    }
</script>
</body>
</html>