<?php
/**
 * FileUpload
 */
namespace Kodetop;

class FileUpload
{
    private $uploadDir;
    private $allowedTypes;
    private $allowedMimes;
    private $maxFileSize;
    private $errorMessage;

    public function __construct(String $uploadDir = "files/", Array $allowedTypes = array()) {
        $this->uploadDir = $uploadDir;
        $this->allowedTypes = $allowedTypes;
        $this->maxFileSize = 0;
        $this->errorMessage = "";

        $this->checkAllowedMimes();
    }

    public function setMaxFileSize(int $maxFileSize) {
        $this->maxFileSize = $maxFileSize;
    }

    public function setFilesAllowed(Array $allowedTypes) {
        $this->allowedTypes = $allowedTypes;
        $this->checkAllowedMimes();
    }

    public function save($name) {
        $file = $_FILES[$name];

        $name = basename($file['name']);                                          // file name
        $size = $file['size'];                                                    // file size
        $type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));    // file type
        $mime = mime_content_type($file['tmp_name']);                             // mime type

        // Check upload error
        if ($file["error"] !== UPLOAD_ERR_OK) {
            $this->errorMessage = "Error: " . $file["error"];
            return false;
        }

        // Check file type
        if (!in_array($type, $this->allowedTypes)) {
            $this->errorMessage = "Error: Tipo de archivo no permitido (File type).";
            return false;
        }

        // Check mime type
        if (!in_array($mime, $this->allowedMimes)) {
            $this->errorMessage = "Error: Tipo de archivo no permitido (MIME type).";
            return false;
        }

        // Check file size
        if ($this->maxFileSize > 0 && $this->maxFileSize < $size) {
            $this->errorMessage = "Error: El archivo es demasiado grande.";
            return false;
        }

        // Move uploaded file to target directory
        $newFile = $this->uploadDir . uniqid() . '-' . $name;
        if (move_uploaded_file($file['tmp_name'], $newFile)) {
            return $newFile;
        } else {
            $this->errorMessage = "Error: Hubo un problema al subir el archivo.";
            return false;
        }
    }

    public function getErrorMessage() {
        return $this->errorMessage;
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
        foreach ($this->allowedTypes as $type) {
            $allowedMimes[] = $mimeTypes[$type];
        }

        $this->allowedMimes = $allowedMimes;
    }
}
