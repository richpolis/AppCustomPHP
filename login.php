<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Registro de Usuario</title>
<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" />
<?php 

@ require_once ('header.php'); 
echo "<h1>Registro de Usuario</h1>";
@ require_once ('header2.php');

?>
<script type="text/javascript" src="js/login.js"></script>
<article class="clearfix">
<div id="texto">
<div id="login">
  <h1>Ingresa a Personal INCA</h1>
  <form id="form1" name="form1" action="dologin.php" method="post">
    <p>
      <label for="username">Nombre de Usuario: </label>
      <input type="text" name="username" id="username" />
    </p>
    <p>
      <label for="password">Contrase&ntilde;a: </label>
      <input type="password" name="password" id="password" />
    </p>
    <p>
      <input type="submit" id="loginbtn" name="loginbtn" value="Enviar" />
      <input type="hidden" id="pag" value="<?php if (isset($_GET["pag"])) echo $_GET["pag"]; ?>" />
    </p>
  </form>
    <div id="message"></div>
</div>

</div>
</article>
  
<?php 
@ require_once ('footer.php');
?>     