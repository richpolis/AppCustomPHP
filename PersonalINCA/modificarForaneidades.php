<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$monto = utf8_decode(trim($_REQUEST['monto']));
$estado = $_REQUEST['estado'];
$transporte = utf8_decode(trim($_REQUEST['transporte']));
$archivo_alta_foraneidad = utf8_decode(trim($_REQUEST['archivo_alta']));
$archivo_baja_foraneidad = utf8_decode(trim($_REQUEST['archivo_baja']));
$eliminar_archivo1 = $_REQUEST['eliminar_archivo1'];
$eliminar_archivo2 = $_REQUEST['eliminar_archivo2'];

if (!is_numeric($monto)) {
	echo "El monto de foraneidad no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}

if (!is_numeric($transporte)) {
	echo "El apoyo mensual para transporte no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}
	
if ($archivo_alta_foraneidad == "") 
	$archivo_alta_foraneidad = "NULL";
	
if ($archivo_baja_foraneidad == "") 
	$archivo_baja_foraneidad = "NULL";
	
if ($archivo_alta_foraneidad != "NULL"){
	$ext = substr($archivo_alta_foraneidad, strrpos($archivo_alta_foraneidad, '.'));
	$nombre_archivo1 = ", archivo_alta_foraneidad = 'alta_foraneidad_empleado_".$idempleado.$ext."'";
}
else{
	if ($eliminar_archivo1 == "1") {
		$nombre_archivo1 = ", archivo_alta_foraneidad = ".$archivo_alta_foraneidad;
	}
	else{
		$nombre_archivo1 = "";
	}
	
}

if ($archivo_baja_foraneidad != "NULL"){
	$ext = substr($archivo_baja_foraneidad, strrpos($archivo_baja_foraneidad, '.'));
	$nombre_archivo2 = ", archivo_baja_foraneidad = 'baja_foraneidad_empleado_".$idempleado.$ext."'";
}
else{
	if ($eliminar_archivo2 == "1") {
		$nombre_archivo2 = ", archivo_baja_foraneidad = ".$archivo_baja_foraneidad;
	}
	else{
		$nombre_archivo2 = "";
	}
	
}

$query = "UPDATE empleados SET ".
		"estado_foraneidad = $estado, foraneidad_monto = $monto, ".
		"apoyo_mensual_transporte = $transporte$nombre_archivo1$nombre_archivo2 WHERE id_empleado = $idempleado;";

$result = $miconexion->consulta($query);
	
if($result) {
	echo "success";	
}
else {
	echo "No se pudo modificar el registro.";
}
$miconexion->desconectar();
exit();

?>