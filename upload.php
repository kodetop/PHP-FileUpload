<?php

namespace Kodetop;

class Upload
{
    const VERSION = '1.0';

    private $maxFileSize = false;
    private $mimesAllowed = [];
    private $folder;

    public function __construct()
    {

    }

    public function allowMimeTypes(array $mimes)
    {
        $this->mimesAllowed = $mimes;
    }

    public function setMaxFileSize(int $size)
    {
        $this->maxFileSize = $size;
    }

    public function setRemoteFolder(string $folder)
    {
        $this->folder = $folder;
    }

    public function save(string $field, array $options = [])
    {
        $file = $_FILES[$field]['tmp_name'];
        $name = $_FILES[$field]['name'];
        $size = $_FILES[$field]['size'];
        $mime = mime_content_type($file);
        $error = $_FILES[$field]['error'];

        $folder = ($options['folder'] != '') ? $options['folder'] : $this->folder;

        if ($error === UPLOAD_ERR_OK) {
            // upload OK
            if (move_uploaded_file($file, $folder . "/" . $name)) {
                return (object) ['status' => true, 'name' => $name];
            } else {
                return (object) ['status' => false, 'error' => 'File was not uploaded please try again'];
            }
        }
    }
}
