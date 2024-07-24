<?php
require '../class/FileUpload.php';
use \Kodetop\FileUpload;

$upload = new FileUpload();
$upload->setTypesAllowed(['jpg', 'jpeg', 'png']);           // Only images
$photo = $upload->save('photo', 'uploads');    // Save file

if ($upload->hasError()) {
    echo $upload->getErrorMessage();
} else {
    echo 'File uploaded: ' . $photo;
}
