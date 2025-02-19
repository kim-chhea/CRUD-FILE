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
  <link href="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #1a1b1f 0%, #2d143c 100%);
    }
    
    .glow-card {
      box-shadow: 0 0 40px rgba(139, 92, 246, 0.1);
    }
    
    .upload-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
    }
    
    .image-card:hover {
      transform: translateY(-4px);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
  </style>
</head>

<body class="text-gray-100">

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-lg font-semibold text-red-600">Error</h2>
    <p class="mt-2 text-gray-600" id="errorMessage">Sorry, file already exists.</p>
    <button id="closeModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
      Close
    </button>
  </div>
</div>

<!-- Success Modal -->
<div id="success" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-lg font-semibold text-green-600">Success</h2>
    <p class="mt-2 text-gray-600" id="successMessage">The files have been uploaded</p>
    <button id="closeModalsuccess" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-green-600">
      Close
    </button>
  </div>
</div>

<!-- Emptydata Modal -->
<div id="Emptydata" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-lg font-semibold text-red-600">Empty</h2>
    <p class="mt-2 text-red-600" id="EmptyMessage">There are no files have been uploaded</p>
    <button id="closeModalempty" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-green-600">
      Close
    </button>
  </div>
</div>

  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-6xl bg-gray-900/50 backdrop-blur-xl p-8 rounded-2xl glow-card border border-gray-800/60">
      <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
          <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent mb-3">
            Visual Archive
          </h1>
          <p class="text-gray-400">Upload and manage your images with style</p>
        </div>

        <!-- Upload Section -->
        <div class="mb-16">
          <form action="/Store" method="post" enctype="multipart/form-data" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-300">Your Name</label>
                <div class="relative">
                  <input type="text" id="username" name="username" required
                    class="w-full px-4 py-3 bg-gray-800/50 border-2 border-gray-700/30 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                    placeholder="John Doe">
                  <ion-icon name="person-circle-outline" class="text-gray-500 absolute right-4 top-3 text-xl"></ion-icon>
                </div>
              </div>

              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-300">Your Email</label>
                <div class="relative">
                  <input type="email" id="email" name="email" required
                    class="w-full px-4 py-3 bg-gray-800/50 border-2 border-gray-700/30 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                    placeholder="john@example.com">
                  <ion-icon name="mail-outline" class="text-gray-500 absolute right-4 top-3 text-xl"></ion-icon>
                </div>
              </div>
            </div>

            <div class="border-2 border-dashed border-gray-700/50 rounded-2xl p-8 text-center transition-all upload-hover">
              <input type="file" id="imageUpload" name="image" accept="image/*" class="hidden" onchange="previewImage(event)" />
              <label for="imageUpload" class="cursor-pointer space-y-4">
                <div class="inline-flex bg-gray-800/50 p-4 rounded-full">
                  <ion-icon name="cloud-upload-outline" class="text-4xl text-purple-400"></ion-icon>
                </div>
                <div class="space-y-1">
                  <h3 class="text-lg font-semibold text-gray-200">Drag and drop or click to upload</h3>
                  <p class="text-sm text-gray-500">PNG, JPG, JPEG up to 10MB</p>
                </div>
              </label>
            </div>

            <!-- Preview and Submit -->
            <div class="flex flex-col items-center space-y-6">
              <div id="imagePreview" class="mt-6 w-64 h-64 relative group">
                <img id="preview" class="w-full h-full object-cover rounded-2xl border-4 border-gray-800/50 shadow-xl transition-transform group-hover:scale-105">
                <div id="previewPlaceholder" class="absolute inset-0 flex items-center justify-center bg-gray-800/50 rounded-2xl border-4 border-gray-800/50">
                  <ion-icon name="image-outline" class="text-4xl text-gray-600"></ion-icon>
                </div>
              </div>
              <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-lg font-semibold rounded-xl transition-all transform hover:scale-[1.02]">
                Upload Now
                <ion-icon name="rocket-outline" class="ml-2"></ion-icon>
              </button>
            </div>
          </form>
        </div>

        <!-- Image Gallery -->
        <div class="pb-12">
          <h2 class="text-2xl font-bold text-gray-200 mb-8 flex items-center">
            <ion-icon name="images-outline" class="mr-2 text-purple-400"></ion-icon>
            Recent Uploads
          </h2>
          <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($images as $image): ?>
              <li class="image-card group relative bg-gray-800/50 rounded-2xl p-4 shadow-xl hover:shadow-2xl transition-all duration-300">
                <div class="relative overflow-hidden rounded-xl aspect-square">
                  <img src="<?= htmlspecialchars($image['paths']) ?>" 
                       alt="<?= htmlspecialchars($image['file_name']) ?>" 
                       class="w-full h-full object-cover transform transition duration-300 group-hover:scale-105">
                </div>
                <div class="mt-4 space-y-2">
                  <div class="flex items-center text-sm text-purple-400">
                    <ion-icon name="person-circle-outline" class="mr-2"></ion-icon>
                    <?= htmlspecialchars($image['user_name']) ?>
                  </div>
                  <div class="flex items-center text-sm text-gray-400">
                    <ion-icon name="mail-outline" class="mr-2"></ion-icon>
                    <?= htmlspecialchars($image['email']) ?>
                  </div>
                  <div class="flex items-center text-sm text-gray-400">
                    <ion-icon name="document-outline" class="mr-2"></ion-icon>
                    <?= htmlspecialchars($image['file_name']) ?>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Enhanced Preview Functionality
    function previewImage(event) {
      const preview = document.getElementById('preview');
      const placeholder = document.getElementById('previewPlaceholder');
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.src = e.target.result;
          placeholder.classList.add('hidden');
          preview.classList.add('opacity-100');
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