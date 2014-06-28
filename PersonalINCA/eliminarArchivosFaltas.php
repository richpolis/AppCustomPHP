<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idempleado = $_REQUEST['id'];
$idarchivo = $_REQUEST['idf'];

$result = $miconexion->consulta("SELECT archivo FROM archivos_faltas WHERE id_empleado = $idempleado AND id_archivo_faltas = $idarchivo;");
$row = mysql_fetch_array($result);

$result = $miconexion->consulta("DELETE FROM archivos_faltas WHERE id_empleado = $idempleado AND id_archivo_faltas = $idarchivo;");

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