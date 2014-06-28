<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idinmueble = $_REQUEST['id'];

$result = $miconexion->consulta("DELETE FROM inmuebles WHERE id_inmueble = $idinmueble;");

if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {
	echo "success";
}
	
$miconexion->desconectar();
exit();

?>