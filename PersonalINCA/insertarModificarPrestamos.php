<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$idprestamo = $_REQUEST['idf'];
$fecha_solicitud = $_REQUEST['fecha_solicitud'];
$fecha_fin = $_REQUEST['fecha_fin'];
$monto = utf8_decode(trim($_REQUEST['monto']));
$estado = $_REQUEST['estado'];
$archivo = utf8_decode(trim($_REQUEST['archivo']));
$accion = $_REQUEST['accion'];
$eliminar_archivo = $_REQUEST['eliminar_archivo'];

if (!is_numeric($monto)) {
	echo "El monto no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}

$arr = explode('/', $fecha_solicitud);
$fecha_solicitud = $arr[2].'-'.$arr[1].'-'.$arr[0];

$arr = explode('/', $fecha_fin);
$fecha_fin = $arr[2].'-'.$arr[1].'-'.$arr[0];

if ($archivo == "") 
	$archivo = "NULL";

if ($accion == "insertar") {
	$result = $miconexion->consulta("SELECT MAX(id_prestamo) FROM prestamos WHERE id_empleado = $idempleado");
	$row = mysql_fetch_row($result);
	$idprestamo = $row[0]+1;
	
	if ($archivo != "NULL"){
		$ext = substr($archivo, strrpos($archivo, '.'));
		$nombre_archivo = "'prestamo_".$idprestamo."_empleado_".$idempleado.$ext."'";
	}
	else{
		$nombre_archivo = $archivo;
	}
	
	$query = "INSERT INTO prestamos (".
			"id_prestamo, id_empleado, fecha_solicitud, fecha_fin, monto, estado, archivo) ".
			"VALUES ($idprestamo, $idempleado, '$fecha_solicitud', '$fecha_fin', $monto, $estado, $nombre_archivo);";
			
	//echo $query; exit();
			
} else if ($accion == "modificar") {
	if ($archivo != "NULL"){
		$ext = substr($archivo, strrpos($archivo, '.'));
		$nombre_archivo = ", archivo = 'prestamo_".$idprestamo."_empleado_".$idempleado.$ext."'";
	}
	else{
		if ($eliminar_archivo == "1") {
			$nombre_archivo = ", archivo = ".$archivo;
		}
		else{
			$nombre_archivo = "";
		}
		
	}
	
	$query = "UPDATE prestamos SET ".
			"fecha_solicitud = '$fecha_solicitud', fecha_fin = '$fecha_fin', monto = $monto, estado = $estado$nombre_archivo ".
			"WHERE id_empleado = $idempleado AND id_prestamo = $idprestamo;";
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