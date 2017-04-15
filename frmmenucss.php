<?php
// INICIO DE SESSION DEL USUARIO
//session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

//VARIABLES DEL FORMULARIO
$FrmNombre="Menu";
$FrmDescripcion="Menú";
$TbNombre="tbtipomenu";
$TbNombre1="tbmenu";
?>


<!DOCTYPE html>
<html lang="es">
     
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />   

<style>
</style>
</head>
<body>
	
<?php
	// 3. CONSTRUIR CONSULTA DE LOS TIPOS DE MENU
	$Sql="SELECT * FROM $TbNombre WHERE tipsta='1'";
	// 4 EJECUTAR LA CONSULTA
	$Resultado = mysqli_query($conectar,$Sql) or die( "Error en $Sql: " . mysqli_error() );
	// 5 RECORRER EL RESULTADO
	while ($Registro = mysqli_fetch_array($Resultado)){
	echo "<div class='dropdown'><button class='dropbtn'>$Registro[tipdes]</button>";
	//echo "<div class='dropdown'><button class='dropbtn'>$Registro[tipdes]</button>";
	// 3. CONSTRUIR CONSULTA MENUS
	$Sql1="SELECT * FROM $TbNombre1 WHERE mensta='1' AND mentip=$Registro[tipid]";
	// 4 EJECUTAR LA CONSULTA
	$Resultado1 = mysqli_query($conectar,$Sql1) or die( "Error en $Sql1: " . mysqli_error() );
	// 5 RECORRER EL RESULTADO
	echo "<div class='dropdown-content'>";
	while ($Registro1 = mysqli_fetch_array($Resultado1)){ echo "<a href='$Registro1[mennom].php'>$Registro1[mendes]</a>"; }
    echo "</div></div>";
	}
?>
		
</body>
</html>

