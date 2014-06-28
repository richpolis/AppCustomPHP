<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idinmueble = $_REQUEST['id'];
$ubicacion = utf8_decode(trim($_REQUEST['ubicacion']));
$localidad = $_REQUEST['localidad'];
$tipo = $_REQUEST['tipo'];
$renta = trim($_REQUEST['renta']);

$accion = $_REQUEST['accion'];

if ($localidad == "-1") 
	$localidad = "NULL";

if ($accion == "insertar") {
	
	$result = $miconexion->consulta("SELECT MAX(id_inmueble) FROM inmuebles");
	$row = mysql_fetch_row($result);
	$idinmueble = $row[0]+1;
	
	$query = "INSERT INTO inmuebles (id_inmueble, id_localidad, ubicacion, tipo, renta) ".
			"VALUES ($idinmueble, $localidad, '$ubicacion', $tipo, $renta);";
		
} else if ($accion == "modificar") {	
	$query = "UPDATE inmuebles SET ".
			"id_localidad = $localidad, ubicacion = '$ubicacion', tipo = $tipo, renta = $renta WHERE id_inmueble = $idinmueble;";
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