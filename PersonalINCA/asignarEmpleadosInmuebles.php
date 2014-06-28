<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];
$id_inmueble = $_REQUEST['id_inmueble'];

if (isset($_REQUEST["eliminar"])) {
	$query = "DELETE FROM inmuebles_foraneidad WHERE id_empleado = $id AND id_inmueble = $id_inmueble;";
}
else {
	if ($id == "-1") {
		echo "Debe elegir un empleado primero.";
		$miconexion->desconectar();
		exit();
	}
	
	$query = "SELECT * FROM inmuebles_foraneidad WHERE id_empleado = $id;";
	$result = $miconexion->consulta($query);
	if (mysql_num_rows($result)!=0) {
		echo "Ya fue asignado este emplado al inmueble.";
		$miconexion->desconectar();
		exit();
	}
	
	$query = "INSERT INTO inmuebles_foraneidad (id_empleado, id_inmueble) VALUE ($id, $id_inmueble);";
	
}

$result = $miconexion->consulta($query);
echo "success";	
$miconexion->desconectar();
exit();

?>