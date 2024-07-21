# PHP FileUpload

Clase para validar y procesar upload de archivos con PHP.

## Instalación

El proceso de instalación requiere incluir la clase:

```php
require 'class/file-upload.php';
```

## Uso de FileUpload

Se requiere crear una instancia de la clase, esta instancia recibe como parámetro la carpeta donde se guardarán
los archivos subidos:

```php
use Kodetop;
$upload = new FileUpload('files/');
$upload->setFilesAllowed(array('jpg', 'jpeg', 'png'));      // Only images
$upload->setMaxFileSize(50 * 1024);                         // 50KB
$file = $upload->save('photo');

if (!$file) {
    echo $upload->getErrorMessage();
} else {
    echo 'file uploaded: ' . $file;
}
```

## Métodos disponibles

* `setMaxFileSize`: Tamaño máximo en bytes del archivo que se puede aceptar.
* `setFilesAllowed`: Array con las extensiones de archivos que se aceptan.
* `save`: Método para guardar el archivos subido, recibe el nombre del archivo.
* `getErrorMessage`: Si el upload ha fallado devuelve el mensaje de error.
