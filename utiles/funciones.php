<?php 

function data_submitted() {
	$_AAux= array();
    if (!empty($_POST)) 
    	$_AAux =$_POST;
    else 
		if(!empty($_GET)) {
            $_AAux =$_GET;
		}
	if (count($_AAux)){
		foreach ($_AAux as $indice => $valor) {
				if ($valor=="")
                	$_AAux[$indice] = 'null'	;
			}
	}
	return $_AAux;

}


/**
 * Éste método retorna un string HTML correspondiente a una alerta de error, exito o aviso
 * @param array $datos
 * @return string
 */
	function get_aviso($datos)
{
	$HTML = '<style>
    .bs-example {
        position: absolute;
        top: 80px;
		right: 35px;
		z-index: 40;
    }</style>';

	if (isset($datos['error'])) {
		$HTML .=   '<div class="bs-example">
						<div class="alert alert-danger alert-dismissible fade show">
							<strong>Error! </strong>' . $datos['error'] .
							'<button type="button" class="close" data-dismiss="alert">&times;</button>
						</div>
					</div>';
	}
	if (isset($datos['aviso'])) {
		$HTML .=   '<div class="bs-example">
						<div class="alert alert-warning alert-dismissible fade show">
							<strong>Alerta! </strong>' . $datos['aviso'] .
			'<button type="button" class="close" data-dismiss="alert">&times;</button>
						</div>
					</div>';
	}
	if (isset($datos['exito'])) {
		$HTML .=   '<div class="bs-example">
						<div class="alert alert-success alert-dismissible fade show fixed">
							<strong>Exito! </strong>' . $datos['exito'] .
							'<button type="button" class="close" data-dismiss="alert">&times;</button>
						</div>
					</div>';
	}

	return $HTML;
}

?>