<?php
session_start();
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$nombre = $_REQUEST['nombre'];
$gerencia = $_REQUEST['gerencia'];
$ubicacion = $_REQUEST['ubicacion'];
$obra = $_REQUEST['obra'];
$empresa = $_REQUEST['empresa'];
$tipo = $_REQUEST['tipo'];
$finiquitado = $_REQUEST['finiquitado'];

if ($gerencia == "-1") {
	$query_gerencia = "";
} else {
	$query_gerencia = " AND id_gerencia = $gerencia";	
}

if ($ubicacion == "-1") {
	$query_ubicacion = "";
} else {
	$query_ubicacion = " AND ubicacion = $ubicacion";	
}

if ($obra == "-1") {
	$query_obra = "";
} else {
	$query_obra = " AND id_obra = $obra";	
}

if ($empresa == "-1") {
	$query_empresa = "";
} else {
	$query_empresa = " AND empresa_contratante = $empresa";	
}

if ($tipo == "-1") {
	$query_tipo = "";
} else {
	$query_tipo = " AND tipo_contratacion = $tipo";	
}

if ($finiquitado == "2") {
	$query_finiquitado = "";
} else {
	$query_finiquitado = " AND finiquitado = $finiquitado";
}

$rowsPerPage = 30;
$pageNum = 1;

if(isset($_REQUEST['page'])){
	$pageNum = $_REQUEST['page'];
}

$offset = ($pageNum - 1) * $rowsPerPage;

if ($offset < 0) {
	$offset = 0;	
}

$query2 = "SELECT COUNT(id_empleado) AS numrows FROM empleados WHERE (nombre LIKE '%$nombre%' OR "."
		apellido_paterno LIKE '%$nombre%' OR apellido_materno LIKE '%$nombre%')".$query_gerencia.
		$query_ubicacion.$query_obra.$query_empresa.$query_tipo.$query_finiquitado.";";

$result2 = $miconexion->consulta($query2);
$row_count = mysql_fetch_array($result2);
$numrows = $row_count['numrows'];
$maxPage = ceil($numrows/$rowsPerPage);

if ($pageNum > 1){
	$page  = $pageNum - 1;
	$first = " <a href=\"#\"  onclick='Buscar(1); return false;' title='Primera página' class='cambiapag'>".
				"<img src='images/first.png' style='vertical-align: middle;' /></a>&nbsp;&nbsp;";
	$prev  = " <a href=\"#\" onclick='Buscar($page); return false;' title='Anterior' class='cambiapag'>".
				"<img src='images/previous.png' style='vertical-align: middle;' /></a>&nbsp;&nbsp;";
}
else{
	$prev  = '&nbsp;'; // we're on page one, don't print previous link
	$first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage){
	$page = $pageNum + 1;
	$next = "&nbsp;&nbsp;<a href=\"#\" onclick='Buscar($page); return false;' title='Siguiente' class='cambiapag'>".
				"<img src='images/next.png' style='vertical-align: middle;' /></a> ";
	$last = "&nbsp;&nbsp;<a href=\"#\" onclick='Buscar($maxPage); return false;' title='Última página' class='cambiapag'>".
				"<img src='images/last.png' style='vertical-align: middle;' /></a> ";
}
else{
	$next = '&nbsp;'; // we're on the last page, don't print next link
	$last = '&nbsp;'; // nor the last page link
}

$nav  = '';
$response = "<p style='text-align: center'>";
for($page = 1; $page <= $maxPage; $page++){
	if ($page == $pageNum){
		$nav .= " $page ";
	}
	else{
		$nav .= " <a href=\"$self?page=$page\">$page</a> ";
	}
}

$paginas = $first.$prev." Página $pageNum de $maxPage ($numrows registros) ".$next.$last;
$response .= $paginas."</p>";

$query = "SELECT * FROM empleados WHERE (nombre LIKE '%$nombre%' OR "."
		apellido_paterno LIKE '%$nombre%' OR apellido_materno LIKE '%$nombre%')".$query_gerencia.
		$query_ubicacion.$query_obra.$query_empresa.$query_tipo.$query_finiquitado.
		" ORDER BY nombre ASC LIMIT ".
		$offset.", ".$rowsPerPage.";";

$result = $miconexion->consulta($query);
	
if (mysql_num_rows($result)!=0) {

	//Generar codigo de las tablas
	$response .= "<table id='report' width='100%'>\n";
	$response .= "	<tr>\n".
				"		<th style='padding-left: 0px; padding-right: 0px; width: 30px;'></th>\n".
				"		<th style='width: 290px;'>Nombre</th>\n".
				"		<th style='width: 120px;'>Coordinaci&oacute;n / Gerencia</th>\n".
				"		<th style='width: 90px;'>Estado Foraneidad/ Compensación</th>\n".
				"		<th style='width: 20px;'></th>\n".
				"	</tr>\n";
	$c = 0;
	while($row = mysql_fetch_array($result)) {
		if ($c % 2 == 0)
			$class="filapar";
		else
			$class="filaimpar";			
		$c++;
		$response .= "	<tr id='".$row["id_empleado"]."'>\n";
		$response .= "		<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .="<a href='#' onclick='return iniModificar(".$row["id_empleado"].
						");' title='Modificar Foraneidad/Compensación'><img src='images/form_edit.png' /></a>";
		}					
		$response .="</td>";
		$response .= "		<td class='$class'>\n".
					"		".htmlentities($row["nombre"])." ".htmlentities($row["apellido_paterno"]).
					" ".htmlentities($row["apellido_materno"])."\n".
					"		</td>\n".
					"		<td class='$class'>\n";
		if ($row["id_gerencia"] != NULL) {
			$result_gerencia = $miconexion->consulta("SELECT gerencias.nombre from gerencias, empleados ".
											"WHERE gerencias.id_gerencia = empleados.id_gerencia ".
											"AND gerencias.id_gerencia = ".$row["id_gerencia"].";");
			$row_gerencia = mysql_fetch_array($result_gerencia);
			$response .="		".htmlentities($row_gerencia["nombre"])."\n";
		}
		$response .= "		<td class='$class'>\n";
		switch ($row["estado_foraneidad"]) {
			case 0:
				$response .= "Baja\n";
				break;
			case 1:
				$response .= "Alta\n";
				break;
		}		
		$response .="		</td>\n";

		$response .= "		<td class='$class'><div class='arrow'></div></td>\n".
					"	</tr>\n".
					"	<tr id='info_".$row["id_empleado"]."'>\n".
            		"		<td class='$class' colspan='6'>\n".
					"		</td>\n".
					"	</tr>\n";					
	}
				
				
	$response .= "</table>\n";
	$response.= "<p style='text-align: center; padding-top: 10px;'>".$paginas."</p>";
	
	echo $response;
}
else {
	echo "<h1 style='text-align: center;'>".
		" <br />No se encontr&oacute; ning&uacute;n registro que coincida con la b&uacute;squeda.".
		"</h1>\n";
}
$miconexion->desconectar();
exit();

?>