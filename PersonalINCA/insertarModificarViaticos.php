<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$idviatico = $_REQUEST['idf'];
$fecha_salida = $_REQUEST['fecha_salida'];
$fecha_regreso = $_REQUEST['fecha_regreso'];
$monto = utf8_decode(trim($_REQUEST['monto']));
$motivo = utf8_decode($_REQUEST['motivo']);
$accion = $_REQUEST['accion'];

if (!is_numeric($monto)) {
	echo "El monto autorizado no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}

$arr = explode('/', $fecha_salida);
$fecha_salida = $arr[2].'-'.$arr[1].'-'.$arr[0];

$arr = explode('/', $fecha_regreso);
$fecha_regreso = $arr[2].'-'.$arr[1].'-'.$arr[0];

if ($accion == "insertar") {
	$result = $miconexion->consulta("SELECT MAX(id_viatico) FROM viaticos WHERE id_empleado = $idempleado");
	$row = mysql_fetch_row($result);
	$idviatico = $row[0]+1;
	
	$query = "INSERT INTO viaticos (".
			"id_viatico, id_empleado, fecha_salida, fecha_regreso, monto_autorizado, motivo) ".
			"VALUES ($idviatico, $idempleado, '$fecha_salida', '$fecha_regreso', $monto, '$motivo');";
			
} else if ($accion == "modificar") {
	
	$query = "UPDATE viaticos SET ".
			"fecha_salida = '$fecha_salida', fecha_regreso = '$fecha_regreso', monto_autorizado = $monto, motivo = '$motivo' ".
			"WHERE id_empleado = $idempleado AND id_viatico = $idviatico;";
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