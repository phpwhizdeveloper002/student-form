<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Premium Multi-Step Form</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1abc9c, #16a085);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        form {
            width: 90%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.95);
            padding: 3em;
            border-radius: 20px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .form-step {
            position: absolute;
            width: 100%;
            opacity: 0;
            transform: scale(0.8) translateY(50px);
            transition: all 0.5s ease;
        }

        .form-step.active {
            opacity: 1;
            transform: scale(1) translateY(0);
            position: relative;
        }

        .step-header {
            position: absolute;
            top: -30px;
            right: 30px;
            background: #16a085;
            color: #fff;
            padding: 0.5em 1em;
            border-radius: 30px;
            font-weight: 600;
            animation: slideIn 0.5s forwards;
        }

        h2 {
            margin-bottom: 1em;
            color: #333;
            font-weight: 600;
            text-align: center;
            animation: fadeInDown 0.5s ease-in-out;
        }

        label {
            display: block;
            margin-top: 1em;
            color: #555;
            font-weight: 500;
            animation: fadeInUp 0.5s ease-in-out;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 0.75em 1em;
            margin-top: 0.5em;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 1em;
            outline: none;
            transition: border-color 0.3s;
            animation: fadeInUp 0.5s ease-in-out;
        }

        input:focus,
        textarea:focus {
            border-color: #1abc9c;
        }

        input[type="checkbox"] {
            margin-right: 0.5em;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2em;
            animation: fadeInUp 0.5s ease-in-out;
        }

        button {
            padding: 0.75em 2em;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .next-step,
        .prev-step {
            background: #1abc9c;
            color: #fff;
        }

        .next-step:hover,
        .prev-step:hover {
            background: #16a085;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        button[type="submit"] {
            background: #e74c3c;
            color: #fff;
            margin-left: auto;
        }

        button[type="submit"]:hover {
            background: #c0392b;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        #summary p {
            margin: 1em 0;
            color: #333;
            font-weight: 500;
            animation: fadeInUp 0.5s ease-in-out;
        }

        .error {
            border: 1px solid red;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
<!-- <form id="multi-step-form" action="<?php //base_url('Home/store'); ?>" method="POST"> -->
<form id="multi-step-form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" id="csrf_token">

    <?php if ($this->session->flashdata('error_message')): ?>
        <div class="alert alert-danger" id="error-alert">
            <?= $this->session->flashdata('error_message'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success_message')): ?>
        <div class="alert alert-success" id="success-alert">
            <?= $this->session->flashdata('success_message'); ?>
        </div>
    <?php endif; ?>

    <div class="form-step active">
        <div class="step-header">Step 1 of 4</div>
        <h2>Personal Information</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required minlength="2" value="<?= set_value('name'); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="<?= set_value('email'); ?>">
        <div class="buttons">
            <button type="button" class="next-step">Next</button>
        </div>
    </div>

    <div class="form-step">
        <div class="step-header">Step 2 of 4</div>
        <div id="step-summary"></div>
        <h2>Gender</h2>
        <label><input type="radio" id="gender-male" name="gender" value="m" checked> Male</label>
        <label><input type="radio" id="gender-female" name="gender" value="f"> Female</label>
        <div class="buttons">
            <button type="button" class="prev-step">Previous</button>
            <button type="button" class="next-step">Next</button>
        </div>
    </div>

    <div class="form-step">
        <div class="step-header">Step 3 of 4</div>
        <div id="step-summary1"></div>
        <h2>Comments</h2>
        <label for="comments">Comments (max 200 characters):</label>
        <textarea id="comments" required name="comments" maxlength="200"><?= set_value('comments'); ?></textarea>
        <div class="buttons">
            <button type="button" class="prev-step">Previous</button>
            <button type="button" class="next-step">Next</button>
        </div>
    </div>

    <div class="form-step">
        <div class="step-header">Step 5 of 4</div>
        <h2>Summary</h2>
        <div id="step-summary"></div>
        <div id="summary"></div>
        <div class="buttons">
            <button type="button" class="prev-step">Previous</button>
            <button id="submit" type="submit">Submit</button>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- js code for validations and show previouse page data into current page. -->

<script>
   $(document).ready(function() {
        // Handle "Next" button click

        $(".next-step").on("click", function() {
            var currentStep = $(this).closest(".form-step");
            var nextStep = currentStep.next(".form-step");
            // Validate other required fields in the current step
            var isValid = true;
            currentStep.find("input[required], textarea[required]").each(function() {
                var field = $(this);
                var fieldName = field.attr("name") || field.attr("id");
                var errorMessage = '';

                // Check if the field is empty
                if (field.val() === "") {
                    isValid = false;
                    field.addClass("error");
                    errorMessage = fieldName ? fieldName + " is required" : "This field is required";
                } 
                // Additional validation for specific fields
                else if (field.is("[type='email']") && !validateEmail(field.val())) {
                    isValid = false;
                    field.addClass("error");
                    errorMessage = fieldName ? fieldName + " must be a valid email" : "Invalid email format";
                } 

                if (errorMessage) {
                    if (!field.next(".error-message").length) {
                        field.after("<div class='error-message'>" + errorMessage + "</div>");
                    }
                } else {
                    field.removeClass("error");
                    field.next(".error-message").remove();
                }
            });

            // If valid, move to the next step
            if (isValid) {
                currentStep.removeClass("active");
                nextStep.addClass("active");
            }
        });

        // Function to validate email format
        function validateEmail(email) {
            var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            return re.test(email);
        }



        // Handle "Previous" button click
        $(".prev-step").on("click", function() {
            var currentStep = $(this).closest(".form-step");
            var prevStep = currentStep.prev(".form-step");

            currentStep.removeClass("active");
            prevStep.addClass("active");
        });
        
    });
</script>

<!-- js code for move previouse next page -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.form-step');
        const nextBtns = document.querySelectorAll('.next-step');
        const prevBtns = document.querySelectorAll('.prev-step');
        const summary = document.getElementById('summary');
        const submitBtn = document.getElementById('submit');
        let currentStep = 0;

        let formData = {};
        console.log(formData);
        nextBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (validateStep()) {
                    saveFormData();

                    steps[currentStep].classList.remove('active');
                    currentStep++;
                    if (currentStep < steps.length) {
                        steps[currentStep].classList.add('active');
                        prefillStepData();  // Pre-fill the data for the next step
                        updateStepSummary();  // Show the data filled in the previous steps
                    }
                    if (currentStep === steps.length - 1) {
                        displaySummary();
                    }
                }
            });
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                steps[currentStep].classList.remove('active');
                currentStep--;
                steps[currentStep].classList.add('active');
                prefillStepData();  // Pre-fill the data for the previous step
                updateStepSummary();  // Show the data filled in the previous steps
            });
        });

        function validateStep() {
            let stepIsValid = true;
            const currentInputs = steps[currentStep].querySelectorAll('input, textarea');
            currentInputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    stepIsValid = false;
                }
            });
            return stepIsValid;
        }

        function saveFormData() {
            const currentInputs = steps[currentStep].querySelectorAll('input, textarea');
            currentInputs.forEach(input => {
                formData[input.name] = input.value;
            });
        }

        function prefillStepData() {
            const currentInputs = steps[currentStep].querySelectorAll('input, textarea');
            currentInputs.forEach(input => {
                if (formData[input.name] !== undefined) {
                    input.value = formData[input.name];
                    if (input.type === 'radio') {
                        input.checked = formData[input.name] === input.value;
                    }
                }
            });
        }

        function updateStepSummary() {
            // Display the saved data for previous steps on the current step
            const summaryContent = document.getElementById('step-summary');
            let stepSummary = '';

            // Show data for all previous steps
            for (let i = 0; i < currentStep; i++) {
                const stepInputs = steps[i].querySelectorAll('input, textarea');
                stepInputs.forEach(input => {
                    if (formData[input.name]) {
                        stepSummary += `<p><strong>${input.name}:</strong> ${formData[input.name]}</p>`;
                    }
                });
            }

            summaryContent.innerHTML = stepSummary;
        }

        function displaySummary() {
            const name = formData['name'] || 'N/A';
            const email = formData['email'] || 'N/A';
            const prefs = formData['gender'] || 'None';
            const comments = formData['comments'] || 'None';

            summary.innerHTML = `
                <p><strong>Name:</strong> ${name}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Gender:</strong> ${prefs}</p>
                <p><strong>Description:</strong> ${comments}</p>
            `;
        }       

        // Initialize the first step and its values
        steps.forEach((step, index) => {
            if (index !== currentStep) {
                step.classList.remove('active');
            } else {
                step.classList.add('active');
            }
        });
    });

    // Form submit here
    document.getElementById('submit').addEventListener('click', function(event) {
        event.preventDefault();
        var formData = new FormData($("#multi-step-form")[0]); 
        
        $.ajax({
            url: "<?= base_url('Home/store'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.errors) {
                    window.location.href = "<?= base_url('Home/index'); ?>"; // Redirect to display errors
                }

                window.location.href = "<?= base_url('Home/index'); ?>";
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
            }
        });
    });

</script>

</body>
</html>
