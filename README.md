# Generación de archivos comprimidos
Aplicación web desarrollada en PHP para el cursado de la materia **Programación Web Dinámica** de la *Universidad Nacional del Comahue*.

## Requisitos
Es posible utilizar la extensión **_ZipArchive_** incluida de forma nativa en *PHP versión __5.2.0__* ó superior.

Para corroborar si nuestro PHP soporta el uso de ésta extensión procedemos a correr un **archivo .php** en el navegador con la siguiente línea:
```php
<?php
phpinfo();
?>
```
En la página se verá como resultado un listado de la configuración completa de PHP. Se deberá buscar la sección "**_ZIP_**" 

*simplificar el paso abriendo el buscador (ctrl + F) y buscar "**zip version**" para dirigirnos a dicha sección.*

En el apartado, buscar la fila "**Zip**", la segunda columna debe decir "**enabled**" para poder utilizar la extensión en nuestro servidor.

## Librerías
Existen varias librerías creadas en la comunidad para tratar con Archivos Comprimidos, algunas de ellas son:

### [# Wrapper 7-zip (p7zip)](https://github.com/Gemorroj/Archive7z): Extensa librería para tratar con archivos 7-zip
Permite trabajar con una extensa cantidad de extensiones.
> Requiere PHP >=7.1.3

Ejemplo de uso (provista de su documentación):
```php
. . .
use Archive7z\Archive7z;

class MyArchive7z extends Archive7z
{
    protected $timeout = 120;
    protected $compressionLevel = 6;
    protected $overwriteMode = self::OVERWRITE_MODE_S;
    protected $outputDirectory = '/path/to/custom/output/directory';
}

$obj = new MyArchive7z('path_to_7z_file.7z');

if (!$obj->isValid()) {
    throw new \RuntimeException('Incorrect archive');
}

foreach ($obj->getEntries() as $entry) {
        print_r($entry);
        /*
Archive7z\Entry Object
 (
 [path:Archive7z\Entry:private] => 1.jpg
 [size:Archive7z\Entry:private] => 91216
 [packedSize:Archive7z\Entry:private] => 165344
 [modified:Archive7z\Entry:private] => 2013-06-10 09:56:07
 [attributes:Archive7z\Entry:private] => A
 [crc:Archive7z\Entry:private] => 871345C2
 [encrypted:Archive7z\Entry:private] => +
 [method:Archive7z\Entry:private] => LZMA:192k 7zAES:19
 [block:Archive7z\Entry:private] => 0
 [comment:Archive7z\Entry:private] => 
 [hostOs:Archive7z\Entry:private] => 
 [folder:Archive7z\Entry:private] => 
 [archive:Archive7z\Entry:private] => Archive7z\Archive7z Object
 (
 [compressionLevel:protected] => 9
 [binary7z:Archive7z\Archive7z:private] => C:\Program Files\7-Zip\7z.exe
 [filename:Archive7z\Archive7z:private] => S:\VCS\Git\Archive7z\tests/fixtures/testPasswd.7z
 [password:Archive7z\Archive7z:private] => 123
 [outputDirectory:Archive7z\Archive7z:private] => ./
 [overwriteMode:Archive7z\Archive7z:private] => -aoa
 [timeout:Archive7z\Archive7z:private] => 60
 )
 )
 */

    if ($entry->getPath() === 'test/test.txt') {
        $entry->extractTo('path_to_extract_folder/'); // extract file
    }
}

echo $obj->getContent('test/test.txt'); // show content of the file
$obj->setOutputDirectory('path_to_extract_folder/')->extract(); // extract archive
$obj->setOutputDirectory('path_to_extract_pass_folder/')->setPassword('pass')->extractEntry('test/test.txt'); // extract password-protected entry

$obj->addEntry(__FILE__); // add file to archive
$obj->addEntry(__DIR__);  // add directory to archive (include subfolders)

$obj->renameEntry(__FILE__, __FILE__.'new'); // rename file in archive
$obj->delEntry(__FILE__.'new'); // remove file from archive
. . .

```
### [PhpZip](https://github.com/Ne-Lexa/php-zip): Librería para un trabajo más extenso sobre archivos Zip. 
Permite crear/modificar archivos .ZIP sin necesidad de la extensión *ZIP* ó la clase *ZipArchive*. Además puede retornar el resultado final en forma de *string* sin necesidad de almacenar en el servidor el archivo resultante.
> Requiere PHP >5.5 (preferentemente en sistemas de 64bits)

Ejemplo de uso:
```php
. . .
$zipFile = new \PhpZip\ZipFile();
$zipFile->addFromString('zip/entry/filename', 'Is file content') // Añade una entrada con el texto del segundo parámetro.
        ->addFile('/path/to/file', 'data/tofile') // Añade un archivo
        ->addDir(__DIR__, 'to/path/') // Añade todos los archivos de un directorio
        ->saveAsFile($outputFilename) // Guarda el archivo final
        ->close(); // Cierra el objeto.
. . .

```
### [# RarArchiver](https://www.phpclasses.org/package/9207-PHP-Create-manipulate-and-extract-RAR-archives.html): Librería para trabajar con archivos .rar
Permite crear/modificar archivos .RAR con una forma similar a la de ZipArchive/RarArchive, con características como añadir directorios vacíos, renombrar archivos..
> Requiere PHP >5.5.11

# Uso de *ZipArchive* - Crear archivo .zip
- [Manual PHP](https://www.php.net/manual/es/class.ziparchive.php).
- [Ejemplo](https://github.com/ezeveritta/archivosComprimidos/blob/main/app/views/actions/comprimir.php).

Cumpliendo los requisitos, comenzamos definiendo una variable como objeto de la clase *ZipArchive*
```php
$objZip = new ZipArchive();
```
Procedemos a *abrir* el objeto para comenzar a editar su información, en este paso definimos el nombre (y ruta de destino) del archivo resultante.
```php
$nombreZip = "resultado/miArchivo.zip";
if ($objZip->open($rutaDestino.$nombreZip, ZIPARCHIVE::CREATE))
{   ...
```
Dentro del condicional, podemos realizar todas las operaciones requeridas hasta terminar con:

```php
	...
	$objZip->close();
}
```
## Algunas funciones
```php
$objZip->addEmptyDir("Nombre de carpeta"); # Añade un directorio vacío.
$objZip->addFile("Dirección del archivo", "Dirección local" opcional); # Añade un archivo (primer parámetro) con el nombre del primer o segundo parámetro.
$objZip->addFromString("Nombre local", "Contenido"); # Añade un archivo con el nombre y contenido pasado por parámetro.
$objZip->addPattern("Expresión Regular", "Dirección a escanear", [arreglo, de, opciones]); # Añade todos los archivos de un directorio filtrados con la expresión regular.
$objZip->close(); # Cierra el objeto ZipArchive y guarda los cambios.
$objZip->count(); # Retorna la cantidad de archivos almacenado.
$objZip->deleteIndex(n); # Elimina una entrada según el indice (int) pasado por parámetro.
$objZip->deleteName("nombreArchivo"); # Elimina una entrada según el nombre.
$objZip->extractTo("destino", ["arreglo", "de.archivos"] opcional); # Extrae el contenido en el directorio pasado por parámetro. se puede elegir cuales archivos en el arreglo.
$objZip->locateName("nombre"); # Devuelve el índice de la entrada o FALSE en caso de no encontrarlo.
$objZip->open("nombre.zip", BANDERAS:OVERWRITE/CREATE/RDONLY/EXCL/CHECKCONS); # Abre un archivo .zip y permite su alteración.
$objZip->renameIndex(n, "nuevo nombre"); # Renombra una entrada según un indice.
$objZip->renameName("nombre", "nuevo nombre"); # Renombra una entrada según un nombre.
$objZip->replaceFile("nuevo Archivo", n); # Reemplaza una entrada según su índice, por el archivo pasado por parámetro.
$objZip->setArchiveComment("comentario"); # Añade un comentario al archivo comprimido.
$objZip->setCommentIndex(n, "comentario"); # Añade un comentario a una entrada según su índice.
$objZip->setCommentName("nombre", "comentario"); # Añade un comentario a una entrada según su nombre.
$objZip->setCompressionIndex(n, BANDERA:METODO); # Define método de compresion de una entrada según un indice.
$objZip->setCompressionName("nombre", BANDERA:METODO); # Define método de compresion de una entrada según un nombre.
$objZip->setEncryptionIndex(n, BANDERA:METODO, "contraseña" opcional); # Define un tipo de encriptación para una entrada según su índice, y permite proporcionar contraseña.
$objZip->setEncryptionName("nombre", BANDERA:METODO, "contraseña" opcional); # Define un tipo de encriptación para una entrada según su nombre, y permite proporcionar contraseña.
$objZip->setMtimeIndex(n, "Timestamp", BANDERAS); # Establece la hora de modificación de una entrada según su índice.
$objZip->setMtimeName(n, "Timestamp", BANDERAS); # Establece la hora de modificación de una entrada según su nombre.
$objZip->setPassword("contraseña"); # Establece una contraseña para acceder al archivo.
$objZip->statIndex(n, BANDERAS); # Retorna la información de una entrada según su índice.
$objZip->statName("nombre", BANDERAS); # Retorna la información de una entrada según su nombre.
$objZip->unchangeALL(); # Reestablece todos los cambios desde que se abrió.
```

# Acerca de ésta aplicación:
Se intentó hacer una aplicación básica con la que demostrar la facilidad con la que se utiliza *ZipArchive*. El proyecto se organiza según el modelo MVC y cuenta con las siguientes características:

- __Página *contenido.php*:__ Muestra todos los archivos del directorio **_Raiz/public/files/_**, con un formulario permite seleccionar esos archivos y acceder a la acción **_action/comprimir.php_**.
- __Acción *action/comprimir.php*:__ Crea un archivo .zip y añade los ficheros cuyos nombres fueron pasados por el formulario de *contenido.php*. Una vez completado, retorna a la página anterior.
- __Acción *action/eliminar.php*:__ Elimina un archivo del servidor según el parámetro $_GET.
- __Control *ContenidoContro.php*:__ Proporciona métodos para acceder a la información de un directorio.

# Referencias
- [Manual PHP](https://www.php.net/manual/es/index.php).
- [Manual ZipArchive](https://www.php.net/manual/es/class.ziparchive).
- [Tutorial compresión de archivos con PHP](https://www.imaginanet.com/blog/comprimir-archivos-dinamicamente-en-zip-con-php.html).
- [Tutorial Cómo comprimir y descomprimir..](https://code.tutsplus.com/es/tutorials/file-compression-and-extraction-in-php--cms-31977).
