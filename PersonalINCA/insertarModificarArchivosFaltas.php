<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$idarchivo = $_REQUEST['idf'];
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$archivo = utf8_decode(trim($_REQUEST['archivo']));
$accion = $_REQUEST['accion'];
$eliminar_archivo = $_REQUEST['eliminar_archivo'];

if ($archivo == "") 
	$archivo = "NULL";

if ($accion == "insertar") {
	$result = $miconexion->consulta("SELECT MAX(id_archivo_faltas) FROM archivos_faltas WHERE id_empleado = $idempleado");
	$row = mysql_fetch_row($result);
	$idarchivo = $row[0]+1;
	
	if ($archivo != "NULL"){
		$ext = substr($archivo, strrpos($archivo, '.'));
		$nombre_archivo = "'archivo_faltas_".$idarchivo."_empleado_".$idempleado.$ext."'";
	}
	else{
		$nombre_archivo = $archivo;
	}
	
	$query = "INSERT INTO archivos_faltas (".
			"id_archivo_faltas, id_empleado, mes, ano, archivo) ".
			"VALUES ($idarchivo, $idempleado, $mes, $ano, $nombre_archivo);";
	//echo $query; exit();
} else if ($accion == "modificar") {
	
	if ($archivo != "NULL"){
		$ext = substr($archivo, strrpos($archivo, '.'));
		$nombre_archivo = ", archivo = 'archivo_faltas_".$idarchivo."_empleado_".$idempleado.$ext."'";
	}
	else{
		if ($eliminar_archivo == "1") {
			$nombre_archivo = ", archivo = ".$archivo;
		}
		else{
			$nombre_archivo = "";
		}
		
	}
	
	$query = "UPDATE archivos_faltas SET ".
			"mes = $mes, ano = $ano$nombre_archivo ".
			"WHERE id_empleado = $idempleado AND id_archivo_faltas = $idarchivo;";
			
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