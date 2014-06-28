<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Usuarios</title>
<link rel="stylesheet" href="../css/login.css" type="text/css" media="screen" />
<?php 

@ require_once ('header.php');
echo "<script type='text/javascript' src='js/usuarios.js'></script>";
echo "<script type='text/javascript' src='js/jquery.validate.js'></script>";
echo "<script type='text/javascript' src='js/jExpand.js'></script>";
@ require_once ('header1.php');
echo "<h1>Usuarios</h1>\n";

@ require_once ('header2.php');


if(!isset($_SESSION["uloged"]) || $_SESSION['nivel'] != 0){
  echo "<SCRIPT LANGUAGE=\"JavaScript\">
	   <!--
	   window.location=\"login.php?pag=".
	   substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)."\";
	   // -->
	   </script>";
} else {

include ("../Acceso.php");
?>

<!-- BUSQUEDA DE USUARIOS -->
<article class="clearfix" id="datos">

  <h1>Usuario con todos los derechos</h1>
  <form id="usuario0" name="usuario0" action="modificarUsuarios.php" method="post">
    <div class="linea">
      <div class="etiqueta" for="nombre0">Nombre: </div>
      <input type="text" name="nombre0" id="nombre0" required="required" style="width: 250px;" 
      <?php
	  	$result = $miconexion->consulta("SELECT * FROM monitos WHERE nivel = 0;");
        $row = mysql_fetch_array($result);
		echo " value='".htmlentities($row["nombre"])."'";
	  ?>      
      />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="id0">ID: </div>
      <input type="text" name="id0" id="id0" required="required" 
      <?php
		echo " value='".htmlentities($row["id_monito"])."'";
	  ?> 
      />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="password0">Contrase&ntilde;a actual: </div>
      <input type="password" name="password0" id="password0" required="required" />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="newpassword0">Nueva contrase&ntilde;a: </div>
      <input type="password" name="newpassword0" id="newpassword0" required="required" />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="cnewpassword0">Confirmar nueva contrase&ntilde;a: </div>
      <input type="password" name="cnewpassword0" id="cnewpassword0" required="required" />
    </div>
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Guardar" />
    </div>
  </form>
  
  <div class="linea">
  <hr />
  </div>
  
  <h1>Usuario de solo consulta</h1>
  <form id="usuario1" name="usuario1" action="modificarUsuarios.php" method="post">
    <div class="linea">
      <div class="etiqueta" for="nombre0">Nombre: </div>
      <input type="text" name="nombre1" id="nombre1" style="width: 250px;" required="required"
      <?php
	  	$result = $miconexion->consulta("SELECT * FROM monitos WHERE nivel = 1;");
        $row = mysql_fetch_array($result);
		echo " value='".htmlentities($row["nombre"])."'";
	  ?> 
      />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="id1">ID: </div>
      <input type="text" name="id1" id="id1" required="required" 
       <?php
		echo " value='".htmlentities($row["id_monito"])."'";
	  ?>
      />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="newpassword1">Nueva contrase&ntilde;a: </div>
      <input type="password" name="newpassword1" id="newpassword1" required="required" />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="cnewpassword1">Confirmar nueva contrase&ntilde;a: </div>
      <input type="password" name="cnewpassword1" id="cnewpassword1" required="required" />
    </div>
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Guardar" />
    </div>
  </form>
  
  <div class="linea">
  <hr />
  </div>
  
  <h1>Usuario general</h1>
  <form id="usuario2" name="usuario2" action="modificarUsuarios.php" method="post">
    <div class="linea">
      <div class="etiqueta" for="nombre2">Nombre: </div>
      <input type="text" name="nombre2" id="nombre2" style="width: 250px;" required="required"  
      <?php
	  	$result = $miconexion->consulta("SELECT * FROM monitos WHERE nivel = 2;");
        $row = mysql_fetch_array($result);
		echo " value='".htmlentities($row["nombre"])."'";
	  ?>      
      />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="id2">ID: </div>
      <input type="text" name="id2" id="id2" required="required" 
      <?php
		echo " value='".htmlentities($row["id_monito"])."'";
	  ?>
      />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="newpassword2">Nueva contrase&ntilde;a: </div>
      <input type="password" name="newpassword2" id="newpassword2" required="required" />
    </div>
    
    <div class="linea">
      <div class="etiqueta" for="cnewpassword2">Confirmar nueva contrase&ntilde;a: </div>
      <input type="password" name="cnewpassword2" id="cnewpassword2" required="required" />
    </div>
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Guardar" />
    </div>
  </form>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     