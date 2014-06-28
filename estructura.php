<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Estructura Organizacional</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Estructura Organizacional</h1>";
@ require_once ('header2.php');

if(!isset($_SESSION["uloged"])){
  echo "<SCRIPT LANGUAGE=\"JavaScript\">
	   <!--
	   window.location=\"login.php?pag=".
	   substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)."\";
	   // -->
	   </script>";
} else {

include ("Acceso.php");
?>

<article class="clearfix">

<img style="padding: 0px; margin: 0px; opacity: 0.8; margin-left: -30px; width: 950px;" 
	src="./organigramas/EstructuraOrganizacional.gif" title="Organigrama General INCA" />

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>   