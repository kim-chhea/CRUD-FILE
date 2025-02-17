<?php 
require_once './models/FILE.php';
require_once './databases/db.php';

if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $fileTemPath = $image['tmp_name'];
    $fileName = basename($image['name']);
    $displayName = pathinfo($fileName, PATHINFO_FILENAME); // Extract filename without extension
    
    $UploadDirectory = './asset/picture/';

    if (!is_dir($UploadDirectory)) {
        mkdir($UploadDirectory, 0755, true); // Secure permissions
    }

    $path = $UploadDirectory . $fileName;

    if (move_uploaded_file($fileTemPath, $path)) {
      
        $query = 'INSERT INTO Files (Name_file, display_name) VALUES (?, ?)';
        $files = new File($conn);
        $result = $files->Store($query, [$fileName, $displayName]);
        echo $result['message'];  
        // Redirect correctly
        header('Location: /');
        exit();
    } else {
        echo "File upload failed.";
    }
} else {
    echo "No file uploaded.";
}
?>
