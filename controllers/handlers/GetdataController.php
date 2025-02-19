<?php
require_once './databases/db.php';
require_once './models/FILE.php';
$files = new File($conn);
$images = $files->Show();
require_once './views/Homepage.php';
?>