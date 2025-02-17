<?php 
//  print_r($images); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Upload and Preview</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Custom blur effect for the background */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
      backdrop-filter: blur(10px); /* Blur effect */
      z-index: -1;
    }
  </style>
</head>
<body class="bg-black text-gray-100">
  <div class="min-h-screen flex items-center justify-center p-8">
    <div class="w-full max-w-4xl bg-gray-900 bg-opacity-80 p-8 rounded-xl shadow-2xl border border-gray-800">
      <h1 class="text-3xl font-bold text-white mb-8">Image Upload and Management</h1>

      <!-- Image Upload Section -->
      <div class="mb-8">
        <form action="/Store" method="post" enctype="multipart/form-data" class="space-y-4">
          <div class="flex items-center space-x-4">
            <input type="file" id="imageUpload" name="image" accept="image/*" class="hidden" onchange="previewImage(event)" />
            <label for="imageUpload" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300">
              Upload Image
            </label>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition duration-300">
              Submit
            </button>
          </div>

          <!-- Image Preview -->
          <div id="imagePreview" class="mt-6">
            <img id="preview" class="hidden w-64 h-64 object-cover rounded-lg shadow-md border-2 border-gray-700">
          </div>
        </form>
      </div>

      <!-- Image List Section -->
      <div>
        <h2 class="text-2xl font-semibold text-white mb-6">Uploaded Images</h2>
        <ul id="imageList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <?php foreach ($images as $image): ?>
            <li class="bg-gray-800 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
              <img src="./asset/picture/<?= htmlspecialchars($image['Name_file']) ?>" alt="<?= htmlspecialchars($image['display_name']) ?>" class="w-full h-48 object-cover rounded-lg border-2 border-gray-700">
              <p class="mt-2 text-sm text-gray-400 text-center"><?= htmlspecialchars($image['display_name']) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <script>
    function previewImage(event) {
      const preview = document.getElementById('preview');
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden'); // Show the image preview
        };
        
        reader.readAsDataURL(file); // Read the image file
      }
    }
  </script>
</body>
</html>