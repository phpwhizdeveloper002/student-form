<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Advanced Image Resizer</title>

    <meta name="csrf-token-name" content="<?= $this->security->get_csrf_token_name(); ?>">
    <meta name="csrf-token-hash" content="<?= $this->security->get_csrf_hash(); ?>">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #ffe4e4;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px;
    }

    h1 {
      margin-bottom: 20px;
      color: #333;
    }

    .container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border: 2px dashed #ccc;
      text-align: center;
      max-width: 90%;
    }

    input[type="file"] {
      margin-bottom: 15px;
    }

    .resizable-wrapper {
      max-height: 500px;
      overflow: auto;
      margin: 15px auto;
      border: 1px solid #ddd;
      padding: 10px;
    }

    .resizable {
      display: inline-block;
      position: relative;
    }

    .resizable img {
      display: block;
      width: 100%;
      height: 100%;
      border: 2px solid #007bff;
      border-radius: 6px;
    }

    .controls {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
      align-items: center;
    }

    .controls input[type="number"] {
      width: 100px;
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .toggle {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .btn {
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      background: #007bff;
      color: white;
      cursor: pointer;
    }

    .btn:hover {
      background: #0056b3;
    }

    .download-btn {
      background: #f47171;
      margin-top: 20px;
    }

    .download-btn:hover {
      background: #e25c5c;
    }

    .hidden {
      display: none;
    }

    label {
      font-size: 14px;
    }

    #removeBtn {
        background: #dc3545;
        color: white;
        margin-top: 10px;
    }

    #removeBtn:hover {
        background: #c82333;
    }    
  </style>
</head>
<body>

  <h1>Demo project Resizer</h1>

  <div class="container">
    <input type="file" id="upload" accept="image/*" />
    
    <div class="resizable-wrapper hidden" id="previewWrapper">
      <div class="resizable" id="resizable-box">
        <img id="image" />
      </div>
    </div>

    <div class="controls hidden" id="controls">
      <div class="toggle">
        <input type="checkbox" id="keepAspect" />
        <label for="keepAspect">Aspect ratio</label>
      </div>

      <input type="number" id="customWidth" placeholder="Width" min="1" max="20000" />
      <span>×</span>
      <input type="number" id="customHeight" placeholder="Height" min="1" max="20000" />
      <button class="btn" id="applyBtn">Apply</button>
      <button class="btn" id="removeBtn">Remove Image</button>
    </div>

    <button class="btn download-btn hidden" id="downloadBtn">Download Resized Image</button>
  </div>

  <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
    const upload = document.getElementById("upload");
    const image = document.getElementById("image");
    const resizableBox = document.getElementById("resizable-box");
    const previewWrapper = document.getElementById("previewWrapper");
    const controls = document.getElementById("controls");
    const downloadBtn = document.getElementById("downloadBtn");
    const widthInput = document.getElementById("customWidth");
    const heightInput = document.getElementById("customHeight");
    const keepAspect = document.getElementById("keepAspect");
    const applyBtn = document.getElementById("applyBtn");

    let originalAspectRatio = 1;
    downloadBtn.style.display = 'none';

    upload.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          image.src = e.target.result;
          previewWrapper.classList.remove("hidden");
          controls.classList.remove("hidden");
          downloadBtn.classList.remove("hidden");
          removeBtn.classList.remove("hidden");

          image.onload = function () {
            resizableBox.style.width = image.naturalWidth + "px";
            resizableBox.style.height = image.naturalHeight + "px";
            widthInput.value = image.naturalWidth;
            heightInput.value = image.naturalHeight;
            originalAspectRatio = image.naturalWidth / image.naturalHeight;
          };
        };
        reader.readAsDataURL(file);
      }
    });

    applyBtn.addEventListener("click", function () {

        let width = parseInt(widthInput.value);
        let height = parseInt(heightInput.value);

        if(widthInput.value == '' || heightInput.value == ''){
          alert('Please enter valid width / Height for image resizeing');
          return false;
        }

        downloadBtn.style.display = 'block';

        if (keepAspect.checked) {
            height = Math.round(width / originalAspectRatio);
            heightInput.value = height;
        }

        const canvas = document.createElement("canvas");
        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext("2d");
        ctx.drawImage(image, 0, 0, width, height);

        const csrfTokenName = document.querySelector('meta[name="csrf-token-name"]').content;
        const csrfTokenHash = document.querySelector('meta[name="csrf-token-hash"]').content;
        const resizedImagePath = canvas.toDataURL("image/png");

        if (width > 0 && height > 0) {
            resizableBox.style.width = width + "px";
            resizableBox.style.height = height + "px";
            image.style.width = "100%";
            image.style.height = "100%";

        }

        const formData = new FormData();
        formData.append("width", width);
        formData.append("height", height);
        formData.append("resizedImage", resizedImagePath);
        formData.append(csrfTokenName, csrfTokenHash);

        $.ajax({
            url: "<?= base_url('Home/storeResizedImage'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == 'error'){
                  alert('Resized image uploaded successfully.');
                }
                alert('Resized image uploaded successfully.');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                if (xhr.status === 403 && xhr.responseText.includes('exceeds the limit')) {
                    alert("The image is too large. Please select a smaller one (max 5MB).");
                } else {
                    alert("An error occurred: " + error);
                    console.error("AJAX Error:", xhr.responseText);
                }
            }
        });
    });

    // downloadBtn.addEventListener("click", function () {
    //   const canvas = document.createElement("canvas");
    //   const width = resizableBox.offsetWidth;
    //   const height = resizableBox.offsetHeight;
    //   const file = this.files;

    //   canvas.width = width;
    //   canvas.height = height;

    //   const ctx = canvas.getContext("2d");
    //   ctx.drawImage(image, 0, 0, width, height);

    //   const link = document.createElement("a");
    //   link.download = "resized-image.png";
    //   link.href = canvas.toDataURL();
    //   link.click();
    // });

    //Remove existing image code here.
    const removeBtn = document.getElementById("removeBtn");
    removeBtn.addEventListener("click", function () {
    // Clear the image src
    image.src = "";
    // Reset file input
    upload.value = "";
    // Hide all UI elements
    previewWrapper.classList.add("hidden");
    controls.classList.add("hidden");
    downloadBtn.classList.add("hidden");
    removeBtn.classList.add("hidden");
    });

  </script>

</body>
</html>
