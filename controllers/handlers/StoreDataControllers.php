<?php 
require_once './models/FILE.php';
require_once './databases/db.php';

session_start(); 

if (isset($_FILES['image'])&& isset($_POST['email'])&& isset($_POST['username'])) {

    $image = $_FILES['image'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $fileTemPath = $image['tmp_name'];
    $fileName = basename($image['name']);
    $displayName = pathinfo($fileName, PATHINFO_FILENAME); 
    $UploadDirectory = './asset/picture/';
    $file  = new File($conn);
    $Checking =  $file->Checkimage([$displayName]);

    if ($Checking) {
        if (!is_dir($UploadDirectory)) {
            mkdir($UploadDirectory, 0755, true); // Secure permissions
        }

        $path = $UploadDirectory . $fileName;

        if (move_uploaded_file($fileTemPath, $path)) {
            $file->StoreUser([ $username ,$email  ]);
            $user_id = $conn->lastInsertId();
            $query = 'INSERT INTO Image (paths, file_name, user_id) VALUES (?, ?,?)';
            $files = new File($conn);
            $result = $files->StoreFile($query, [$path, $displayName, $user_id]);
           
            $_SESSION['success'] = "Successfully added";  
            header('Location: /'); 
            exit();
        } else {
            $_SESSION['empty'] = "empty file added"; 
            header('Location: /');  
            exit();

        }
    } else {
        $_SESSION['error'] = "File already exists!";  
        header('Location: /');  
        exit();
    }
  
} else {
    echo "No file uploaded.";
    header('Location: /');  

}
?>
