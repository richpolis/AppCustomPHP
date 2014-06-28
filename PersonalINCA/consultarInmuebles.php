<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];

$query = "SELECT * FROM inmuebles WHERE id_inmueble = $id";

$result = $miconexion->consulta($query);

$row = mysql_fetch_array($result);

/*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/

$ubicacion = str_replace("\n", "\\n", $row["ubicacion"]);
$ubicacion = str_replace("\r", "\\r", $ubicacion);
$ubicacion = str_replace("\t", "\\t", $ubicacion);
	
//return in JSON format
$json = "{";
$json .= "\"localidad\": \"".$row["id_localidad"]."\",\n";
$json .= "\"ubicacion\": \"".utf8_encode($ubicacion)."\",\n";
$json .= "\"tipo\": \"".$row["tipo"]."\",\n";
$json .= "\"renta\": \"".utf8_encode($row["renta"])."\"\n";
$json .= "}";
  
//echo $json;
echo $json;


$miconexion->desconectar();
exit();

?>