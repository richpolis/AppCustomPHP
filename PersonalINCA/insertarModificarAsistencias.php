<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$idfalta = $_REQUEST['idf'];
$fecha = $_REQUEST['fecha'];
$motivo = utf8_decode($_REQUEST['motivo']);
$accion = $_REQUEST['accion'];

$arr = explode('/', $fecha);
$fecha = $arr[2].'-'.$arr[1].'-'.$arr[0];

if ($accion == "insertar") {
	$result = $miconexion->consulta("SELECT MAX(id_falta) FROM faltas WHERE id_empleado = $idempleado");
	$row = mysql_fetch_row($result);
	$idfalta = $row[0]+1;
	
	$query = "INSERT INTO faltas (".
			"id_falta, id_empleado, fecha, motivo) VALUES ($idfalta, $idempleado, '$fecha', '$motivo');";
			
} else if ($accion == "modificar") {
	
	$query = "UPDATE faltas SET ".
			"fecha = '$fecha', motivo = '$motivo' WHERE id_empleado = $idempleado AND id_falta = $idfalta;";
}
		
$result = $miconexion->consulta($query);
	
if($result) {
	echo "success";	
}
else {
	if ($accion == "insertar")
		echo "No se pudo insertar el registro.";
	else if ($accion == "modificar")
		echo "No se pudo modificar el registro.";
}
$miconexion->desconectar();
exit();

?>