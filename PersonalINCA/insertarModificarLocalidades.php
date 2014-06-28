<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idlocalidad = $_REQUEST['id'];
$nombre = utf8_decode(trim($_REQUEST['nombre']));
$accion = $_REQUEST['accion'];

if ($accion == "insertar") {
	
	$result = $miconexion->consulta("SELECT MAX(id_localidad) FROM localidades_inmuebles");
	$row = mysql_fetch_row($result);
	$idlocalidad = $row[0]+1;
	
	$query = "INSERT INTO localidades_inmuebles (id_localidad, nombre) ".
			"VALUES ($idlocalidad, '$nombre');";
		
} else if ($accion == "modificar") {
	
	$query = "UPDATE localidades_inmuebles SET ".
			"nombre = '$nombre' WHERE id_localidad = $idlocalidad;";
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