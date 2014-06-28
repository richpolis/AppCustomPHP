<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idempleado = $_REQUEST['id'];

//eliminar archivos que referencian al empleado en archivos_faltas
$result = $miconexion->consulta("SELECT archivo FROM archivos_faltas WHERE id_empleado = $idempleado;");
while($row = mysql_fetch_array($result)) {
	if ($row[0]!=NULL && $row[0]!= 'NULL' && $row[0]!= "") {
		unlink("./archivos/".$row[0]);
	}
}

//eliminar archivos que referencian al empleado en prestamos
$result = $miconexion->consulta("SELECT archivo FROM prestamos WHERE id_empleado = $idempleado;");
while($row = mysql_fetch_array($result)) {
	if ($row[0]!=NULL && $row[0]!= 'NULL' && $row[0]!= "") {
		unlink("./archivos/".$row[0]);
	}
}

$result = $miconexion->consulta("SELECT archivo_alta, archivo_finiquito, ultimo_recibo, penultimo_recibo, ".
				"archivo_alta_foraneidad, archivo_baja_foraneidad FROM empleados WHERE id_empleado = $idempleado;");
$row = mysql_fetch_array($result);

$result = $miconexion->consulta("DELETE FROM empleados WHERE id_empleado = $idempleado;");

if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {
	for ($i = 0; $i < 6; $i++) {
		if ($row[$i]!=NULL && $row[$i]!= 'NULL' && $row[$i]!= "") {
			unlink("./archivos/".$row[$i]);
		}
	}
	echo "success";
}
	
$miconexion->desconectar();
exit();

?>