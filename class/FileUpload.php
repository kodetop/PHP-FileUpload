<?php
/**
 * FileUpload
 */
namespace Kodetop;

class FileUpload
{
    private string $folder;
    private int $maxSize;
    private array $TYPES;
    private array $MIMES;
    private array $error;

    public function __construct() {
        $this->folder = "uploads";
        $this->maxSize = 0;
        $this->TYPES = [];
        $this->error = [];
    }

    public function setFolderDestination(string $folder)
    {
        $this->folder = $folder;
    }

    public function setMaxSize(int $maxSize) {
        $this->maxSize = $maxSize;
    }

    public function setTypesAllowed(array $types) {
        $this->TYPES = $types;
        $this->checkAllowedMimes();
    }

    public function save(string $name, string $folder = '') {
        $file = $_FILES[$name];
        $this->folder = ($folder != '') ? $folder : $this->folder;

        $name = basename($file['name']);                                          // file name
        $size = $file['size'];                                                    // file size
        $type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));    // file type
        $mime = mime_content_type($file['tmp_name']);                             // mime type

        // Check upload error
        if ($file["error"] !== UPLOAD_ERR_OK) {
            $this->error[] = "Error: " . $file["error"];
            return false;
        }

        // Check file type
        if (!in_array($type, $this->TYPES)) {
            $this->error[] = "Error (" . $name . "): Tipo de archivo no permitido (File type).";
            return false;
        }

        // Check mime type
        if (!in_array($mime, $this->MIMES)) {
            $this->error[] = "Error (" . $name . "): Tipo de archivo no permitido (MIME type).";
            return false;
        }

        // Check file size
        if ($this->maxSize > 0 && $this->maxSize < $size) {
            $this->error[] = "Error (" . $name . "): El archivo es demasiado grande.";
            return false;
        }

        // Move uploaded file to target directory
        $newFile =  uniqid() . '-' . $name;
        if (move_uploaded_file($file['tmp_name'], $this->folder . '/' . $newFile)) {
            return $newFile;
        } else {
            $this->error[] = "Error (" . $name . "): Hubo un problema al subir el archivo.";
            return false;
        }
    }

    public function hasError() {
        return (sizeof($this->error) > 0);
    }

    public function getErrorMessage() {
        return implode('<br>', $this->error);
    }

    private function checkAllowedMimes()
    {
        $mimeTypes = array(
            // images
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'svg'   => 'image/svg+xml',

            // documents
            'pdf'   => 'application/pdf',
            'xls'   => 'application/vnd.ms-excel',
            'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'doc'   => 'application/msword',
            'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt'   => 'application/vnd.ms-powerpoint',
            'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',

            // files
            'zip'   => 'application/zip',
            'rar'    => 'application/x-rar-compressed',
            'txt'   => 'text/plain',
            'htm'   => 'text/html',
            'html'  => 'text/html',
            'xml'   => 'application/xml',
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'json'  => 'application/json',
        );

        $allowedMimes = array();
        foreach ($this->TYPES as $type) {
            $allowedMimes[] = $mimeTypes[$type];
        }

        $this->MIMES = $allowedMimes;
    }
}
