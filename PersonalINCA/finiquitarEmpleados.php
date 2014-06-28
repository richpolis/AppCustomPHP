<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$fecha_finiquito = $_REQUEST['fecha_finiquito'];
$monto_finiquito = utf8_decode(trim($_REQUEST['monto_finiquito']));
$archivo_finiquito = utf8_decode(trim($_REQUEST['archivo_finiquito']));
$eliminar_finiquito = $_REQUEST['eliminar_finiquito'];
$eliminar_archivo_finiquito = $_REQUEST['eliminar_archivo_finiquito'];
$accion = $_REQUEST['accion'];

if (!is_numeric($monto_finiquito)) {
	echo "El monto de finiquito no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}

$arr = explode('/', $fecha_finiquito);
$fecha_finiquito = $arr[2].'-'.$arr[1].'-'.$arr[0];

if ($archivo_finiquito == "") 
	$archivo_finiquito = "NULL";

if ($accion == "insertar") {
	
	if ($archivo_finiquito != "NULL"){
		$ext = substr($archivo_finiquito, strrpos($archivo_finiquito, '.'));
		$nombre_archivo = "'finiquito_empleado_".$idempleado.$ext."'";
	}
	else{
		$nombre_archivo = $archivo_finiquito;
	}
	
	$query = "UPDATE empleados SET ".
			"finiquitado = 1, fecha_finiquito = '$fecha_finiquito', ".
			"monto_finiquito = $monto_finiquito, ".
			"archivo_finiquito = $nombre_archivo WHERE id_empleado = $idempleado;";
			
} else if ($accion == "modificar") {
	if ($eliminar_finiquito == "1") {
		$result = $miconexion->consulta("SELECT archivo_finiquito FROM empleados".
									" WHERE id_empleado = $idempleado;");		
		$row = mysql_fetch_array($result);
		if ($row["archivo_finiquito"] != NULL) {
			@unlink("./archivos/".$row["archivo_finiquito"]);
		}
		
		$query = "UPDATE empleados SET ".
			"finiquitado = 0, fecha_finiquito = NULL, ".
			"monto_finiquito = NULL, ".
			"archivo_finiquito = NULL WHERE id_empleado = $idempleado;";
	}
	else {		
		if ($archivo_finiquito != "NULL"){
			$ext = substr($archivo_finiquito, strrpos($archivo_finiquito, '.'));
			$nombre_archivo = ", archivo_finiquito = 'finiquito_empleado_".$idempleado.$ext."'";
		}
		else{
			if ($eliminar_archivo_finiquito == "1") {
				$nombre_archivo = ", archivo_finiquito = ".$archivo_finiquito;
			}
			else{
				$nombre_archivo = "";
			}
			
		}
		
		$query = "UPDATE empleados SET ".
				"fecha_finiquito = '$fecha_finiquito', ".
				"monto_finiquito = $monto_finiquito$nombre_archivo ".
				"WHERE id_empleado = $idempleado;";
	}	
}
		
$result = $miconexion->consulta($query);
	
if($result) {
	echo "success";	
}
else {
	if ($accion == "insertar")
		echo "No se pudo finiquitar al empleado.";
	else if ($accion == "modificar")
		echo "No se pudo modificar el registro del finiquito.";
}
$miconexion->desconectar();
exit();

?>