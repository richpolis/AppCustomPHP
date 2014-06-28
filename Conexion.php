<?php

class DB_mysql {
    /* variables de conexi�n */

    var $BaseDatos;
    var $Servidor;
    var $Usuario;
    var $Clave;





    /* identificador de conexi�n y consulta */
    var $Conexion_ID = 0;
    var $Consulta_ID = 0;



    /* n�mero de error y texto error */
    var $Errno = 0;
    var $Error = "";

    /* M�todo Constructor: Cada vez que creemos una variable

      de esta clase, se ejecutar� esta funci�n */

    function DB_mysql($bd = "asesores_DB", $host = "localhost", $user = "asesores", $pass = "sarahi") {

        $this->BaseDatos = $bd;

        $this->Servidor = $host;

        $this->Usuario = $user;

        $this->Clave = $pass;
    }

    /* Conexi�n a la base de datos */

    function conectar($bd, $host, $user, $pass) {



        if ($bd != "")
            $this->BaseDatos = $bd;

        if ($host != "")
            $this->Servidor = $host;

        if ($user != "")
            $this->Usuario = $user;

        /* if ($pass != "") */ $this->Clave = $pass;



        // Conectamos al servidor

        $this->Conexion_ID = mysql_connect($this->Servidor, $this->Usuario, $this->Clave);

        if (!$this->Conexion_ID) {

            $this->Error = "Ha fallado la conexi�n.";

            return 0;
        }



        //seleccionamos la base de datos

        if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {

            $this->Error = "Imposible abrir " . $this->BaseDatos;

            return 0;
        }



        /* Si hemos tenido �xito conectando devuelve

          el identificador de la conexi�n, sino devuelve 0 */

        return $this->Conexion_ID;
    }

    function desconectar() {
        mysql_close($this->Conexion_ID);
    }

    /* Ejecuta un consulta */

    function consulta($sql = "") {



        if ($sql == "") {

            $this->Error = "No ha especificado una consulta SQL";

            return 0;
        }



//ejecutamos la consulta

        $this->Consulta_ID = @mysql_query($sql, $this->Conexion_ID);



        if (!$this->Consulta_ID) {

            $this->Errno = mysql_errno();

            $this->Error = mysql_error();
        }

        /* Si hemos tenido �xito en la consulta devuelve

          el identificador de la conexi�n, sino devuelve 0 */

        return $this->Consulta_ID;
    }

    /* Devuelve el n�mero de campos de una consulta */

    function numcampos() {



        return mysql_num_fields($this->Consulta_ID);
    }

    /* Devuelve el n�mero de registros de una consulta */

    function numregistros() {

        return mysql_num_rows($this->Consulta_ID);
    }

    /* Devuelve el nombre de un campo de una consulta */

    function nombrecampo($numcampo) {

        return mysql_field_name($this->Consulta_ID, $numcampo);
    }

    /* Muestra los datos de una consulta */

    function verconsulta() {



        echo "<table border=1>\n";



// mostramos los nombres de los campos

        for ($i = 0; $i < $this->numcampos(); $i++) {

            echo "<td><b>" . $this->nombrecampo($i) . "</b></td>\n";
        }

        echo "</tr>\n";

// mostrarmos los registros



        while ($row = mysql_fetch_row($this->Consulta_ID)) {

            echo "<tr> \n";

            for ($i = 0; $i < $this->numcampos(); $i++) {

                echo "<td>" . $row[$i] . "</td>\n";
            }

            echo "</tr>\n";
        }
    }

}

//fin de la Clse DB_mysql
?>


