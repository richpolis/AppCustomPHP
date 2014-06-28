<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idobra = $_REQUEST['id'];
$nombre = utf8_decode(trim($_REQUEST['nombre']));
$organigrama = utf8_decode(trim($_REQUEST['organigrama']));
$accion = $_REQUEST['accion'];
$eliminar_organigrama = $_REQUEST['eliminar_organigrama'];

if ($organigrama == "") 
	$organigrama = "NULL";


if ($accion == "insertar") {
	
	$result = $miconexion->consulta("SELECT MAX(id_obra) FROM obras");
	$row = mysql_fetch_row($result);
	$idobra = $row[0]+1;
	
	if ($organigrama != "NULL"){
		$ext = substr($organigrama, strrpos($organigrama, '.'));
		$nombre_archivo = "'organigrama_obra_".$idobra.$ext."'";
	}
	else{
		$nombre_archivo = $organigrama;
	}
	
	$query = "INSERT INTO obras (id_obra, nombre, organigrama) ".
			"VALUES ($idobra, '$nombre', $nombre_archivo);";
		
} else if ($accion == "modificar") {
	
	if ($organigrama != "NULL"){
		$ext = substr($organigrama, strrpos($organigrama, '.'));
		$nombre_archivo = ", organigrama = 'organigrama_obra_".$idobra.$ext."'";
	}
	else{
		if ($eliminar_organigrama == "1") {
			$nombre_archivo = ", organigrama = ".$organigrama;
		}
		else{
			$nombre_archivo = "";
		}
		
	}
	
	$query = "UPDATE obras SET ".
			"nombre = '$nombre'$nombre_archivo WHERE id_obra = $idobra;";
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