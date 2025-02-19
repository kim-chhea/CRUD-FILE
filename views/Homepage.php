<?php
// error
session_start(); 
if (isset($_SESSION['error'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('errorModal').classList.remove('hidden');
        });
    </script>";
    unset($_SESSION['error']); 
}

// success
if (isset($_SESSION['success'])) {
  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('success').classList.remove('hidden');
  });
</script>";
unset($_SESSION['success']); 
}

// empty
if (isset($_SESSION['empty'])) {
  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('Emptydata').classList.remove('hidden');
  });
</script>";
unset($_SESSION['empty']); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Upload and Preview</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
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
<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-lg font-semibold text-red-600">Error</h2>
    <p class="mt-2 text-gray-600" id="errorMessage">Sorry, file already exists.</p>
    <button id="closeModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
      Close
    </button>
  </div>
</div>

<!-- Success Modal -->
<div id="success" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-lg font-semibold text-green-600">Success</h2>
    <p class="mt-2 text-gray-600" id="successMessage">The files have been uploaded</p>
    <button id="closeModalsuccess" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-green-600">
      Close
    </button>
  </div>
</div>

<!-- Emptydata Modal -->
<div id="Emptydata" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-lg font-semibold text-red-600">Empty</h2>
    <p class="mt-2 text-red-600" id="EmptyMessage">There are no files have been uploaded</p>
    <button id="closeModalempty" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-green-600">
      Close
    </button>
  </div>
</div>

  <div class="min-h-screen flex items-center justify-center p-8">
    <div class="w-full max-w-4xl bg-gray-900 bg-opacity-80 p-8 rounded-xl shadow-2xl border border-gray-800">
      <h1 class="text-3xl font-bold text-white mb-8">Image Upload and Management</h1>

      <!-- Image Upload Section -->
      <div class="mb-8">
        <form action="/Store" method="post" enctype="multipart/form-data" class="space-y-4">
          <!-- User Name Input -->
          <div>
            <label for="username" class="block text-sm font-medium text-gray-300">Your Name</label>
            <input type="text" id="username" name="username" required
              class="w-full px-4 py-2 mt-1 bg-gray-800 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500" 
              placeholder="Enter your name">
          </div>

          <!-- User Email Input -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-300">Your Email</label>
            <input type="email" id="email" name="email" required
              class="w-full px-4 py-2 mt-1 bg-gray-800 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500" 
              placeholder="Enter your email">
          </div>

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
              <img src="<?= htmlspecialchars($image['paths']) ?>" alt="<?= htmlspecialchars($image['file_name']) ?>" class="w-full h-48 object-cover rounded-lg border-2 border-gray-700">
              <p class="mt-2 text-sm text-gray-400 text-center">Username : <?= htmlspecialchars($image['user_name']) ?></p>
              <p class="mt-2 text-sm text-gray-400 text-center">Email :<?= htmlspecialchars($image['email']) ?></p>
              <p class="mt-2 text-sm text-gray-400 text-center">Filename : <?= htmlspecialchars($image['file_name']) ?></p>
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
          preview.classList.remove('hidden'); 
        };
        
        reader.readAsDataURL(file); 
      }
    }

    document.getElementById('closeModal').addEventListener('click', function() {
      closeModal('errorModal');
    });

    document.getElementById('closeModalsuccess').addEventListener('click', function() {
      closeModal('success');
    });

    document.getElementById('closeModalempty').addEventListener('click', function(){
      closeModal('Emptydata');
    });

    function closeModal(modalId) {
      document.getElementById(modalId).classList.add('hidden');
    }
  </script>
</body>
</html>
