<?php
$uploadDir = 'img/';
$uploadedImages = [];

// Check if the upload form was submitted
if (isset($_POST['upload'])) {
    // Get the uploaded file
    $file = $_FILES['image'];
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    // Allow only specific file types
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // 5MB limit
                $newFileName = uniqid('', true) . '.' . $fileExt;
                $fileDestination = $uploadDir . $newFileName;

                // Move the file to the "img" directory
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Successfully uploaded
                } else {
                    $errorMessage = "Error uploading file.";
                }
            } else {
                $errorMessage = "Your file is too large.";
            }
        } else {
            $errorMessage = "There was an error uploading your file.";
        }
    } else {
        $errorMessage = "You cannot upload files of this type.";
    }
}

// Check if a delete request has been made
if (isset($_GET['delete'])) {
    $imageToDelete = $_GET['delete'];
    $imagePath = $uploadDir . $imageToDelete;

    // If the image exists, delete it
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Redirect to reload the page
    header('Location: photo.php');
    exit;
}

// Read all uploaded images from the "img" directory
if ($handle = opendir($uploadDir)) {
    while (($file = readdir($handle)) !== false) {
        if ($file != '.' && $file != '..' && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
            $uploadedImages[] = $file;
        }
    }
    closedir($handle);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Photo Gallery</title>
  
  <!-- Font Awesome CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <style>
    /* General body styling */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      min-height: 100vh;
      background-color: palevioletred;
      color: #333;
    }

    /* Header styling */
    h1 {
      color: white;
      text-align: center;
      margin-bottom: 30px;
      font-size: 2.5em;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }

    /* Form styling */
    form {
      margin-bottom: 30px;
      text-align: center;
      width: 90%;
      max-width: 400px;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    form label {
      font-size: 18px;
      color: #333;
    }

    form input[type="file"] {
      margin-top: 10px;
      padding: 10px;
      font-size: 16px;
      width: 60%;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f9f9f9;
    }

    form button {
      margin-top: 15px;
      padding: 10px 20px;
      background-color: palevioletred;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }

    form button:hover {
      background-color:rgb(224, 14, 84);
    }

    /* Gallery container */
    .gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      padding: 10px;
      width: 100%;
      box-sizing: border-box;
      max-width: 1200px;
    }

    /* Individual photo box */
    .photo-box {
      width: 180px;
      height: 180px;
      overflow: hidden;
      border-radius: 8px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease-in-out;
      position: relative;
      background-color: #fff;
      cursor: pointer;
    }

    .photo-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Hover effect for image */
    .photo-box:hover {
      transform: scale(1.05);
    }

    /* Delete and download buttons */
    .btn-container {
      position: absolute;
      top: 10px;
      right: 10px;
      display: flex;
      flex-direction: column;
    }

    .delete-btn,
    .download-btn {
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      margin-bottom: 5px;
      font-size: 18px;
      display: block;
      text-align: center;
    }

    .delete-btn:hover {
      background-color: red;
    }

    .download-btn:hover {
      background-color: #4a90e2;
    }

    /* Fullscreen modal styles */
    .fullscreen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      cursor: pointer;
    }

    .fullscreen img {
      max-width: 90%;
      max-height: 90%;
      object-fit: contain;
    }

    /* Close button for fullscreen */
    .close-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      font-size: 30px;
      color: white;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 10px;
      border-radius: 50%;
      cursor: pointer;
    }

    .close-btn:hover {
      background-color: rgba(0, 0, 0, 0.9);
    }

    /* Responsive Styles for smaller screens */
    @media (max-width: 600px) {
      h1 {
        font-size: 2em;
      }

      .photo-box {
        width: 150px;
        height: 150px;
      }

      form {
        width: 80%;
        padding: 15px;
      }

      form input, form button {
        width: 100%;
      }

      .gallery {
        gap: 10px;
        padding: 5px;
      }
    }
  </style>
</head>
<body>

  <h1>My Photo Gallery</h1>

  <!-- Image Upload Form -->
  <form action="" method="POST" enctype="multipart/form-data">
    <label for="image">Upload an image:</label>
    <input type="file" name="image" id="image" required>
    <button type="submit" name="upload">Upload</button>
  </form>

  <!-- Display Error Message if Upload Fails -->
  <?php if (isset($errorMessage)): ?>
    <p class="error"><?= $errorMessage ?></p>
  <?php endif; ?>

  <!-- Gallery of uploaded images -->
  <div class="gallery">
    <?php foreach ($uploadedImages as $image): ?>
      <div class="photo-box" onclick="openFullscreen('img/<?= $image ?>')">
        <img src="img/<?= $image ?>" alt="Uploaded Image">
        <div class="btn-container">
          <!-- Delete Button -->
          <a href="?delete=<?= $image ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this image?')">
            <i class="fas fa-trash-alt"></i>
          </a>
          <!-- Download Button -->
          <a href="img/<?= $image ?>" class="download-btn" download>
            <i class="fas fa-download"></i>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Fullscreen Modal (Initially hidden) -->
  <div id="fullscreenModal" class="fullscreen" style="display: none;" onclick="closeFullscreen()">
    <img id="fullscreenImage" src="" alt="Fullscreen Image">
    <span class="close-btn" onclick="closeFullscreen()">×</span>
  </div>

  <script>
    // Open fullscreen image
    function openFullscreen(imageUrl) {
      const fullscreenModal = document.getElementById('fullscreenModal');
      const fullscreenImage = document.getElementById('fullscreenImage');
      fullscreenImage.src = imageUrl;
      fullscreenModal.style.display = 'flex';
    }

    // Close fullscreen view
    function closeFullscreen() {
      const fullscreenModal = document.getElementById('fullscreenModal');
      fullscreenModal.style.display = 'none';
    }
  </script>

</body>
</html>
