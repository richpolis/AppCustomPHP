<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$idempleado = $_REQUEST['id'];
$idmod = $_REQUEST['idm'];
$tipo = $_REQUEST['tipo'];

if ($tipo == "normal") {
	$result = $miconexion->consulta("SELECT * FROM mod_sueldos WHERE id_empleado = $idempleado AND id_mod_sueldo = $idmod;");
	$row = mysql_fetch_array($result);
	$result = $miconexion->consulta("UPDATE empleados SET sueldo_bruto_mensual =  ".$row["cantidad_anterior"].
									", porcentaje_imss = ".$row["porcentaje_anterior"]." WHERE id_empleado = $idempleado;");	
}
else if ($tipo == "aumento") {
	$result = $miconexion->consulta("SELECT * FROM mod_sueldos_aumento WHERE id_empleado = $idempleado AND id_mod_sueldo_aumento = $idmod;");
	$row = mysql_fetch_array($result);
	$result = $miconexion->consulta("UPDATE empleados SET sueldo_bruto_mensual =  ".$row["cantidad_anterior"].
									" WHERE id_empleado = $idempleado;");
}


if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {
	if ($tipo == "normal") {
		$result = $miconexion->consulta("DELETE FROM mod_sueldos WHERE id_empleado = $idempleado AND id_mod_sueldo = $idmod;");	
	}
	else if ($tipo == "aumento") {
		$result = $miconexion->consulta("DELETE FROM mod_sueldos_aumento WHERE id_empleado = $idempleado AND id_mod_sueldo_aumento = $idmod;");
	}
	if(!$result)
		echo "No se pudo eliminar el registro de la base de datos.";
	else
		echo "success";
}
	
$miconexion->desconectar();
exit();

?>