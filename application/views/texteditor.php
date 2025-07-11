<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Summernote CSS -->
    <link href="<?= base_url('assets/summernote/summernote-bs4.css') ?>" rel="stylesheet">

    <!-- for font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto|Merriweather&display=swap" rel="stylesheet">

</head>
<body>
    <div class="m-5">
        <h2>Summernote Edito</h2>
        <textarea id="summernote" name="content"></textarea>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <!-- Summernote JS -->
    <script src="<?= base_url('assets/summernote/summernote-bs4.js') ?>"></script>

    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 300,
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Roboto', 'Times New Roman', 'Verdana'],
                fontNamesIgnoreCheck: ['Merriweather', 'Roboto'] // Add custom fonts here to avoid .toLowerCase() crash
            });
        });
    </script>
</body>
