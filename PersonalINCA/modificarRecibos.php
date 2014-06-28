<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$faltantes = utf8_decode(trim($_REQUEST['faltantes']));
$ultimo_recibo = utf8_decode(trim($_REQUEST['ultimo_recibo']));
$penultimo_recibo = utf8_decode(trim($_REQUEST['penultimo_recibo']));
$eliminar_archivo1 = $_REQUEST['eliminar_archivo1'];
$eliminar_archivo2 = $_REQUEST['eliminar_archivo2'];

if (!is_numeric($faltantes)) {
	echo "El n&uacute;mero faltante de recibos de honorarios no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}
	
if ($ultimo_recibo == "") 
	$ultimo_recibo = "NULL";
	
if ($penultimo_recibo == "") 
	$penultimo_recibo = "NULL";
	
if ($ultimo_recibo != "NULL"){
	$ext = substr($ultimo_recibo, strrpos($ultimo_recibo, '.'));
	$nombre_archivo1 = ", ultimo_recibo = 'ultimo_recibo_empleado_".$idempleado.$ext."'";
}
else{
	if ($eliminar_archivo1 == "1") {
		$nombre_archivo1 = ", ultimo_recibo = ".$ultimo_recibo;
	}
	else{
		$nombre_archivo1 = "";
	}
	
}

if ($penultimo_recibo != "NULL"){
	$ext = substr($penultimo_recibo, strrpos($penultimo_recibo, '.'));
	$nombre_archivo2 = ", penultimo_recibo = 'penultimo_recibo_empleado_".$idempleado.$ext."'";
}
else{
	if ($eliminar_archivo2 == "1") {
		$nombre_archivo2 = ", penultimo_recibo = ".$penultimo_recibo;
	}
	else{
		$nombre_archivo2 = "";
	}
	
}

$query = "UPDATE empleados SET ".
		"recibos_faltantes = $faltantes$nombre_archivo1$nombre_archivo2 WHERE id_empleado = $idempleado;";

		
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