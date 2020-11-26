<?php

class ContenidoControl
{
    private $error;

    /**
     * Esta función obtiene todo el contenido de una carpeta
     * @param array $datos Contiene la información de la carpeta actual
     * 
     * @return mixed bool|null|array
     */
    public function abrirDirectorio(string $ruta = "")
    {
        $respuesta = null;
        $ruta = '../../public/files/' . $ruta;

        // Abro el directorio
        $direccion = opendir($ruta);

        // Si no se encuentra directorio
        if ($direccion === false) {
            $this->set_error("Error al abrir la carpeta.");
            return false;
        }

        // Obtengo el listado de carpetas y archivos
        $archivos = array();
        $carpetas = array();

        while (($temp = readdir($direccion)) !== false) {
            if ($temp !== "." && $temp !== ".." && !is_dir($ruta . '/' . $temp))    // Si es archivo
                array_push($archivos, $temp);
            if ($temp !== "." && $temp !== ".." && is_dir($ruta . '/' . $temp))     // Si es carpeta
                array_push($carpetas, $temp);
        }

        // Verifico si la carpeta está vacía o tiene contenido
        if (count($archivos) > 0 || count($carpetas) > 0) {
            $respuesta = $archivos;
        }

        return $respuesta;
    }

    /**
     * Métodos de Acceso
     */
    public function get_error()
    {
        return $this->error;
    }
    public function set_error($data)
    {
        $this->error = $data;
    }
    public function __toString()
    {
        return "Objeto ContenidoControl:
                <br> Error: {$this->get_error()}";
    }
}