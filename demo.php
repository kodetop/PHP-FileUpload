<?php
require 'class/file-upload.php';
use Kodetop;

$upload = new FileUpload('files/');
$upload->setFilesAllowed(array('jpg', 'jpeg', 'png'));      // Only images
$upload->setMaxFileSize(50 * 1024);              // 50KB
$file = $upload->save('photo');

if (!$file) {
    echo $upload->getErrorMessage();
} else {
    echo 'file uploaded: ' . $file;
}
