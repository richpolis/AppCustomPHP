<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idobra = $_REQUEST['id'];

$result = $miconexion->consulta("SELECT * FROM obras WHERE id_obra = $idobra;");
$row = mysql_fetch_array($result);

$result = $miconexion->consulta("DELETE FROM obras WHERE id_obra = $idobra;");

if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {

	if ($row["organigrama"]!=NULL && $row["organigrama"]!= 'NULL' && $row["organigrama"]!= "") {
		unlink("./archivos/".$row["organigrama"]);
	}

	echo "success";
}
	
$miconexion->desconectar();
exit();

?>