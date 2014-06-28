<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$idmod = $_REQUEST['idmod'];
$fecha_modificacion = $_REQUEST['fecha_modificacion'];
$nuevo_sueldo = utf8_decode(trim($_REQUEST['nuevo_sueldo']));
$nuevo_porcentaje = utf8_decode(trim($_REQUEST['nuevo_porcentaje']));
$accion = $_REQUEST['accion'];
$tipo = $_REQUEST['tipo'];

if (!is_numeric($nuevo_sueldo)) {
	echo "El nuevo sueldo no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}
if (!is_numeric($nuevo_porcentaje) && $tipo == "normal") {
	echo "El porcentaje al IMSS no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}

$arr = explode('/', $fecha_modificacion);
$fecha_modificacion = $arr[2].'-'.$arr[1].'-'.$arr[0];


if ($tipo == "normal") {
	if ($accion == "insertar") {
		
		$result = $miconexion->consulta("SELECT sueldo_bruto_mensual, porcentaje_imss FROM empleados WHERE id_empleado = $idempleado");
		$row_emp = mysql_fetch_row($result);
		
		$result = $miconexion->consulta("SELECT MAX(id_mod_sueldo) FROM mod_sueldos WHERE id_empleado = $idempleado");
		$row = mysql_fetch_row($result);
		$idmodsueldo = $row[0]+1;
		
		$query = "UPDATE empleados SET sueldo_bruto_mensual = $nuevo_sueldo, porcentaje_imss = $nuevo_porcentaje WHERE id_empleado = $idempleado;";
		$miconexion->consulta($query);
		
		$query = "INSERT INTO mod_sueldos (id_mod_sueldo, id_empleado, fecha, cantidad_anterior, porcentaje_anterior) ".
				"VALUES ($idmodsueldo, $idempleado, '$fecha_modificacion', ".$row_emp[0].", ".$row_emp[1].");";
			
	} else if ($accion == "modificar") {
		
		$query = "UPDATE empleados SET sueldo_bruto_mensual = $nuevo_sueldo, porcentaje_imss = $nuevo_porcentaje WHERE id_empleado = $idempleado;";
		$result = $miconexion->consulta($query);
		
		$query = "UPDATE mod_sueldos SET fecha = '$fecha_modificacion' WHERE id_mod_sueldo = $idmod AND id_empleado = $idempleado;";
	}
	
} else if ($tipo == "aumento") {
	if ($accion == "insertar") {
		
		$result = $miconexion->consulta("SELECT sueldo_bruto_mensual FROM empleados WHERE id_empleado = $idempleado;");
		$row_emp = mysql_fetch_row($result);
		
		if ($row_emp[0] >= $nuevo_sueldo) {
			echo "El nuevo sueldo debe ser mayor al sueldo anterior de $".$row_emp[0].".";
			$miconexion->desconectar();
			exit();
		}
		
		$result = $miconexion->consulta("SELECT MAX(id_mod_sueldo_aumento) FROM mod_sueldos_aumento WHERE id_empleado = $idempleado");
		$row = mysql_fetch_row($result);
		$idmodsueldo = $row[0]+1;
		
		$query = "UPDATE empleados SET sueldo_bruto_mensual = $nuevo_sueldo WHERE id_empleado = $idempleado";
		$result = $miconexion->consulta($query);
		
		$query = "INSERT INTO mod_sueldos_aumento (id_mod_sueldo_aumento, id_empleado, fecha, cantidad_anterior) ".
				"VALUES ($idmodsueldo, $idempleado, '$fecha_modificacion', ".$row_emp[0].");";
				
		
			
	} else if ($accion == "modificar") {
		$result = $miconexion->consulta("SELECT cantidad_anterior FROM mod_sueldos_aumento ".
		"WHERE id_empleado = $idempleado AND id_mod_sueldo_aumento = $idmod");
		$row_mod = mysql_fetch_row($result);
		if ($row_mod[0] >= $nuevo_sueldo) {
			echo "El nuevo sueldo debe ser mayor al sueldo anterior de $".$row_mod[0].".";
			$miconexion->desconectar();
			exit();
		}
		
		$query = "UPDATE empleados SET sueldo_bruto_mensual = $nuevo_sueldo WHERE id_empleado = $idempleado;";
		$result = $miconexion->consulta($query);
		
		$query = "UPDATE mod_sueldos_aumento SET fecha = '$fecha_modificacion' WHERE id_mod_sueldo_aumento = $idmod AND id_empleado = $idempleado;";
	}
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