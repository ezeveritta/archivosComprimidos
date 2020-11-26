<?php

// Obtengo información de POST
if (count($_POST) < 1) {
    header("Location: ../contenido.php?aviso=Error:+no+se+proporcionó+un+archivo+para+comprimir");
    die();
}
$datos = $_POST;

// Defino información del archivo comprimido
$objZip       = new ZipArchive();
$rutaDestino  = '../../../public/files/';
$rutaArchivos = '../../../public/files/';
$objDatetime  = new DateTime();
$nombreZip    = $objDatetime->format('H_m_s') . '.zip';

// Creo el archivo zip
if ($objZip->open($rutaDestino.$nombreZip, ZIPARCHIVE::CREATE) === true) {

    // Añadimos los archivos
    foreach ($datos as $nombreArchivo) {
        $objZip->addFile($rutaArchivos . $nombreArchivo, $nombreArchivo); 
    }

    // Guardamos
    $objZip->close();

    // Redireccionamos a "contenido.php"
    header("Location: ../contenido.php?exito=Archivo+comprimido+con+exito!");
    die();

} else {
    header("Location: ../contenido.php?error=Error+al+comprimir");
    die();
}