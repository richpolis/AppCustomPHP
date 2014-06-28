<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idlocalidad = $_REQUEST['id'];

$result = $miconexion->consulta("DELETE FROM localidades_inmuebles WHERE id_localidad = $idlocalidad;");

if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {
	echo "success";
}
	
$miconexion->desconectar();
exit();

?>