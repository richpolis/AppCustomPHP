<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idempleado = $_REQUEST['id'];
$idfalta = $_REQUEST['idf'];

$result = $miconexion->consulta("DELETE FROM faltas WHERE id_empleado = $idempleado AND id_falta = $idfalta;");

if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {
	echo "success";
}
	
$miconexion->desconectar();
exit();

?>