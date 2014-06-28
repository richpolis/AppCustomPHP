<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idempleado = $_REQUEST['id'];
$idprestamo = $_REQUEST['idf'];

$result = $miconexion->consulta("SELECT archivo FROM prestamos WHERE id_empleado = $idempleado AND id_prestamo = $idprestamo;");
$row = mysql_fetch_array($result);

$result = $miconexion->consulta("DELETE FROM prestamos WHERE id_empleado = $idempleado AND id_prestamo = $idprestamo;");

if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {
	if ($row[0]!=NULL && $row[0]!= 'NULL' && $row[0]!= "") {
		unlink("./archivos/".$row[0]);
	}
	echo "success";
}
	
$miconexion->desconectar();
exit();

?>