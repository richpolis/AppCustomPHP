<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];


$query = "SELECT empleados.id_empleado AS id_empleado, empleados.nombre AS nombre, empleados.apellido_paterno AS apellido_paterno,".
		" empleados.apellido_materno AS apellido_materno".
		" FROM inmuebles_foraneidad, empleados WHERE id_inmueble = $id AND empleados.id_empleado = inmuebles_foraneidad.id_empleado;";

$result = $miconexion->consulta($query);

if (mysql_num_rows($result)!=0) {
	$response = "";
	while ($row = mysql_fetch_array($result)) {
		$response .= "<div class='etiqueta'> &nbsp; </div>";        
		$response .= "<div>";
		$response .= "<a href='#' onclick='return eliminar(".$row["id_empleado"].
						");' title='Quitar Asignaci&oacute;n Empleado' style='vertical-align:middle;'><img src='images/sign_remove.png' /></a>&nbsp;";
		$response .= htmlentities($row["nombre"])." ".htmlentities($row["apellido_paterno"])." ".htmlentities($row["apellido_materno"])."<br />\n";
		$response .= "</div>";
	}
	echo $response;
}
else{
	echo "";
}

$miconexion->desconectar();
exit();

?>