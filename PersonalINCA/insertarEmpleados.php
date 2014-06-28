<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$idempleado = $_REQUEST['id'];
$nombre = utf8_decode(trim($_REQUEST['nombre']));
$apellidop = utf8_decode(trim($_REQUEST['apellidop']));
$apellidom = utf8_decode(trim($_REQUEST['apellidom']));
$puesto = utf8_decode(trim($_REQUEST['puesto']));
$jefe_inmediato = $_REQUEST['jefe_inmediato'];
$coordinacion_gerencia = $_REQUEST['coordinacion_gerencia'];
$ubicacion = $_REQUEST['ubicacion'];
$obra_lugar = $_REQUEST['obra_lugar'];
$fecha_ingreso = $_REQUEST['fecha_ingreso'];
$empresa_contratante = $_REQUEST['empresa_contratante'];
$tipo_contratacion = $_REQUEST['tipo_contratacion'];
$sueldo_bruto_mensual = utf8_decode(trim($_REQUEST['sueldo_bruto_mensual']));
$porcentaje_imss = utf8_decode(trim($_REQUEST['porcentaje_imss']));
$fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
$estado_civil = $_REQUEST['estado_civil'];
$lugar_de_origen = utf8_decode(trim($_REQUEST['lugar_de_origen']));
$domicilio_actual = utf8_decode($_REQUEST['domicilio_actual']);
$email = utf8_decode(trim($_REQUEST['email']));
$nacionalidad = $_REQUEST['nacionalidad'];
$grado_de_estudios = $_REQUEST['grado_de_estudios'];
$rfc = $_REQUEST['rfc'];
$curp = $_REQUEST['curp'];
$tel = utf8_decode(trim($_REQUEST['tel']));
$extension = utf8_decode(trim($_REQUEST['extension']));
$archivo_alta = utf8_decode(trim($_REQUEST['archivo_alta']));
$accion = $_REQUEST['accion'];
$eliminar_archivo = $_REQUEST['eliminar_archivo'];

if (!is_numeric($sueldo_bruto_mensual)) {
	echo "El sueldo mensual bruto no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}
if (!is_numeric($porcentaje_imss)) {
	echo "El porcentaje al IMSS no es un n&uacute;mero.";
	$miconexion->desconectar();
	exit();
}

$arr = explode('/', $fecha_ingreso);
$fecha_ingreso = $arr[2].'-'.$arr[1].'-'.$arr[0];

$arr = explode('/', $fecha_nacimiento);
$fecha_nacimiento = $arr[2].'-'.$arr[1].'-'.$arr[0];


if ($jefe_inmediato == "-1") 
	$jefe_inmediato = "NULL";
	
if ($coordinacion_gerencia == "-1") 
	$coordinacion_gerencia = "NULL";
	
if ($obra_lugar == "-1") 
	$obra_lugar = "NULL";
	
if ($archivo_alta == "") 
	$archivo_alta = "NULL";

if ($accion == "insertar") {
	$result = $miconexion->consulta("SELECT MAX(id_empleado) from empleados");
	$row = mysql_fetch_row($result);
	$idempleado = $row[0]+1;
	
	if ($archivo_alta != "NULL"){
		$ext = substr($archivo_alta, strrpos($archivo_alta, '.'));
		$nombre_archivo = "'alta_empleado_".$idempleado.$ext."'";
	}
	else{
		$nombre_archivo = $archivo_alta;
	}
	
	$query = "INSERT INTO empleados (".
			"id_empleado, nombre, apellido_paterno, apellido_materno, puesto, jefe_inmediato, id_gerencia, ".
			"ubicacion, obra_lugar, fecha_ingreso, empresa_contratante, tipo_contratacion, sueldo_bruto_mensual, ".
			"porcentaje_imss, fecha_nacimiento, estado_civil, lugar_de_origen, domicilio, email, nacionalidad, ".
			"grado_de_estudios, rfc, curp, tel, extension, finiquitado, fecha_finiquito, monto_finiquito, ".
			"archivo_alta, archivo_finiquito, ultimo_recibo, penultimo_recibo, recibos_faltantes, foraneidad_monto, ".
			"apoyo_mensual_transporte, estado_foraneidad, archivo_alta_foraneidad, archivo_baja_foraneidad) ".
			"VALUES ($idempleado, '$nombre', '$apellidop', '$apellidom', '$puesto', $jefe_inmediato, $coordinacion_gerencia, ".
			"$ubicacion, $obra_lugar, '$fecha_ingreso', $empresa_contratante, $tipo_contratacion, $sueldo_bruto_mensual,".
			" $porcentaje_imss, '$fecha_nacimiento', $estado_civil, '$lugar_de_origen', '$domicilio_actual', '$email', "
			."'$nacionalidad', $grado_de_estudios, '$rfc', '$curp', '$tel', '$extension', 0, NULL, NULL, $nombre_archivo, ".
			"NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL);";
			
} else if ($accion == "modificar") {
	
	if ($archivo_alta != "NULL"){
		$ext = substr($archivo_alta, strrpos($archivo_alta, '.'));
		$nombre_archivo = ", archivo_alta = 'alta_empleado_".$idempleado.$ext."'";
	}
	else{
		if ($eliminar_archivo == "1") {
			$nombre_archivo = ", archivo_alta = ".$archivo_alta;
		}
		else{
			$nombre_archivo = "";
		}
		
	}
	
	$query = "UPDATE empleados SET ".
			"nombre = '$nombre', apellido_paterno = '$apellidop', apellido_materno = '$apellidom', puesto = '$puesto',".
			" jefe_inmediato = $jefe_inmediato, id_gerencia = $coordinacion_gerencia, ".
			"ubicacion = $ubicacion, obra_lugar = $obra_lugar, fecha_ingreso = '$fecha_ingreso', ".
			"empresa_contratante = $empresa_contratante, tipo_contratacion = $tipo_contratacion, ".
			"sueldo_bruto_mensual = $sueldo_bruto_mensual, ".
			"porcentaje_imss = $porcentaje_imss, fecha_nacimiento = '$fecha_nacimiento', ".
			"estado_civil = $estado_civil, lugar_de_origen = '$lugar_de_origen', ".
			"domicilio = '$domicilio_actual', email = '$email', nacionalidad = '$nacionalidad', ".
			"grado_de_estudios = $grado_de_estudios, rfc = '$rfc', curp = '$curp', ".
			"tel = '$tel', extension = '$extension'$nombre_archivo WHERE id_empleado = $idempleado;";
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