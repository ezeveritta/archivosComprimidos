<?php

// Si está definido el parámetro archivo en la URL, elimino el archivo
if (isset($_GET['archivo']))
    unlink('../' . $_GET['archivo']);

// Retorno a la vista contenido
header('Location: ../contenido.php');
die();