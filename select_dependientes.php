<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

function generaPaises(){

    conectar();
    $consulta=mysqli_query("SELECT * FROM tbtipodocumentos WHERE tipsta=1;");
    desconectar();

    // Voy imprimiendo el primer select compuesto por los paises
    echo "<select name='tbtipodocumentos' id='tipodocumentos' onChange='cargaContenido(this.id)'>";
    echo "<option value='0'>Elige</option>";
    while($Registro=mysqli_fetch_row($Conectar,$consulta)){
        echo "<option value='".$Registro[0]."'>".$Registro[1]."</option>"; }
    echo "</select>";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>AJAX, Ejemplos: Combos (select) dependientes, codigo fuente - ejemplo</title>
<link rel="stylesheet" type="text/css" href="select_dependientes.css">
<script type="text/javascript" src="select_dependientes.js"></script>
</head>

<body>

            <div id="demo" style="width:600px;">
                <div id="demoDer">
                    <select disabled="disabled" name="estados" id="estados">
                        <option value="0">Selecciona opci&oacute;n...</option>
                    </select>
                </div>
                <div id="demoIzq"><?php generaPaises(); ?></div>
            </div>
            
</body>
</html>