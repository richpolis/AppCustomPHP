<?php
include ("../Acceso.php");
require_once('Browser.php');
$browser = new Browser();
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$accion = $_REQUEST['accion'];
if( $browser->getBrowser() == Browser::BROWSER_IE && $accion == "insertar") {
	$idformato = $_REQUEST['id'];
}
else {
	//$idformato = $_REQUEST['id'];
	$idformato = utf8_decode($_REQUEST['id']);
}
$descripcion = utf8_decode(trim($_REQUEST['descripcion']));

$archivo = utf8_decode(trim($_REQUEST['archivo']));
$privado = trim($_REQUEST['privado']);


if ($archivo == "") 
	$archivo = "NULL";


if ($accion == "insertar") {
	
	if ($archivo != "NULL"){
		$nombre_archivo = "'$archivo'";
	}
	else{
		$nombre_archivo = "NULL";
	}
	
	$query = "INSERT INTO formatos (id_formato, descripcion, privado) ".
			"VALUES ($nombre_archivo, '$descripcion', $privado);";

		
} else if ($accion == "modificar") {
	
	if ($archivo != "NULL"){
		$nombre_archivo = ", id_formato = '$archivo'";
	}
	else{
			$nombre_archivo = "";		
	}
	
	$query = "UPDATE formatos SET ".
			"descripcion = '$descripcion', privado = $privado$nombre_archivo WHERE id_formato = '$idformato';";
	//echo $query; exit();
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