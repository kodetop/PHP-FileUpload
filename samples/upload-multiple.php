<?php
require '../class/FileUpload.php';
use \Kodetop\FileUpload;

$upload = new FileUpload();
$upload->setFolderDestination('uploads');         // Folder to save
$upload->setTypesAllowed(['jpg', 'jpeg', 'png']);        // Only images
$upload->setMaxSize(400 * 1024);                // Max 400KB

$photo = $upload->save('photo');                   // Save file 'photo'
$signature = $upload->save('signature');           // Save file 'signature'
$document = $upload->save('document');             // Save file 'document'

if ($upload->hasError()) {
    echo $upload->getErrorMessage();
} else {
    echo "<strong>Files uploaded:</strong><br>";
    echo "  * photo: {$photo} <br>";
    echo "  * signature: {$signature} <br>";
    echo "  * document: {$document}";
}
