# PHP FileUpload

Clase para validar y procesar upload de archivos con PHP.

## Instalación

El proceso de instalación requiere descargar los archivos y copiar el archivo `FileUpload.php` a la carpeta de tu proyecto.

## Uso de FileUpload

Se requiere crear una instancia de la clase, se puede configurar los tipos de archivos a aceptar 
y luego guardar el archivo.

```php
<?php
require 'class/FileUpload.php';
use \Kodetop\FileUpload;

$upload = new FileUpload();
$upload->setTypesAllowed(['jpg', 'jpeg', 'png']);   // Only images
$photo = $upload->save('photo', 'uploads');         // Save file

if ($upload->hasError()) {
    echo $upload->getErrorMessage();
} else {
    echo 'File uploaded: ' . $photo;
}
```

También se puede definir la carpeta donde guardar los archivos, el tamaño máximo del archivo y procesar
varios archivos simultaneamente.

```php
<?php
require 'class/FileUpload.php';
use \Kodetop\FileUpload;

$upload = new FileUpload();
$upload->setFolderDestination('uploads');           // Folder to save
$upload->setTypesAllowed(['jpg', 'jpeg', 'png']);   // Only images
$upload->setMaxSize(400 * 1024);                    // Max 400KB

$photo = $upload->save('photo');                    // Save file 'photo'
$signature = $upload->save('signature');            // Save file 'signature'
$document = $upload->save('document');              // Save file 'document'

if ($upload->hasError()) {
    echo $upload->getErrorMessage();
} else {
    echo "<strong>Files uploaded:</strong><br>";
    echo "  * photo: {$photo} <br>";
    echo "  * signature: {$signature} <br>";
    echo "  * document: {$document}";
}
```

## Métodos disponibles

| Método                       | Descripción                                                                   |
|------------------------------|-------------------------------------------------------------------------------|
| `setFolderDestination(path)` | Define la carpeta donde se guardarán los archivos                             |
| `setMaxFileSize(size)`       | Define el tamaño máximo aceptado, se expresa en bytes                         |
| `setFilesAllowed([])`        | Array con los tipos de archivos (extensiones) aceptados.                      |
| `save(input, path)`          | Guarda el archivo subido, usa nombre del input y opcional la ruta de destino. |
| `getErrorMessage()`          | Devuelve los mensajes de error encontrados en el proceso de upload.           |
| `hasError()`                 | Devuelve true si el proceso de upload ha tenido un error.                     |

