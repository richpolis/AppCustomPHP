<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" />
<meta name="Robots" content="index, follow" />
<meta name="Description" content="Base de datos del Personal de INCA." />

<link rel="icon" href="images/favicon.png" type="image/png">

<link rel="stylesheet" href="css/estilos.css" type="text/css" media="screen" />
<link rel='stylesheet' href='css/colorbox.css' type='text/css' />
 <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
 <script type="text/javascript" src="js/cta-javascript.js"></script>
 <script type='text/javascript' src='js/jquery.colorbox.js'></script>
 
 

</head>
<body>
	<div id="headerstretch">
		<div id="navstretch">
			<header class="clearfix">
            <?php		  
			  //echo 'Session ID is: ' . session_id() . "<br/>\n";

			  if(isset($_SESSION["nivel"]) && $_SESSION["nivel"] < 2){				
			  ?>
                <a href="./PersonalINCA"><img src="./images/logoBDP.png" id="logo" title="Base de Datos Personal" width="497" height="143" style="padding-top: 50px;"></a>
              <?php
			  	} else {
			  ?>
				<a href="#"><img src="./images/logoBDP.png" id="logo" width="497" height="143" style="padding-top: 50px;"></a>
              <?php
				}
			  ?>
              <div style="display: inline; float:right">
              <nav id="nav1">
              <?php		  
			  if(isset($_SESSION["uloged"]) && (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cerrarsesion.php")){				
			  ?>
                  <ul>
                      <li id="inicio"><a href="./index.php">Inicio</a></li>
                      <li id="estruct_org"><a href="./estructura.php">Estructura Organizacional</a></li>
                      <li id="organigramas"><a href="./organigramas.php">Organigramas</a></li>
                      <li id="compensaciones"><a href="./compensaciones.php">Compensaciones INCA</a></li>
                      <li id="honorarios"><a href="./honorarios.php">Recibos de honorarios</a></li>                   
                  </ul>
              <?php
			  	}
			  ?>
              </nav>
              <nav id="nav2">
              <?php		  
			  if(isset($_SESSION["uloged"]) && (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cerrarsesion.php")){				
			  ?>
                  <ul>
                      <li id="tipo_contrat"><a href="./contratacion.php">Tipo de Contrataci&oacute;n INCA</a></li>
                      <li id="sueldos"><a href="./sueldos.php">Sueldos del Personal</a></li>
                      <li id="personal"><a href="./personal.php">Personal INCA</a></li>
                      <li id="faltas"><a href="./faltas.php">Control de Faltas</a></li>
                      <li id="formatos"><a href="./formatos.php">Formatos Personal</a></li>
                  </ul>
              <?php
			  	}
			  ?>
              </nav>
              </div>
              <div id="usuario">
              <?php		  
			  //echo 'Session ID is: ' . session_id() . "<br/>\n";

			  if(isset($_SESSION["uloged"]) && (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cerrarsesion.php")){
			  	echo "Registrado como <b>".$_SESSION["nombre"]."</b>";
				
			  ?>
                <img  style="vertical-align: middle;" src="./images/man.png" width="23" height="45" align="absmiddle"> 
              <?php
			  	}
			  ?>
        	  </div>
			</header>
		</div>
        
        
		<div id="subbanner">
        	<div id="titulo">