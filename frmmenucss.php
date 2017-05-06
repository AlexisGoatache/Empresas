<?php
// INICIO DE SESSION DEL USUARIO
//session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmmenu'";
$Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}

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
	$Sql="SELECT * FROM tbtipomenu WHERE tipsta='1'";
	// 4 EJECUTAR LA CONSULTA
	$Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
	// 5 RECORRER EL RESULTADO
	while ($Registro = mysqli_fetch_array($Resultado)){
	echo "<div class='dropdown'><button class='dropbtn'>$Registro[tipdes]</button>";
	//echo "<div class='dropdown'><button class='dropbtn'>$Registro[tipdes]</button>";
	// 3. CONSTRUIR CONSULTA MENUS
	$Sql1="SELECT * FROM $_SESSION[TbNombre] WHERE $_SESSION[TbNombre].mensta='1' AND $_SESSION[TbNombre].mentip=$Registro[tipid]";
	// 4 EJECUTAR LA CONSULTA
	$Resultado1 = mysqli_query($conectar,$Sql1) or die( "Error en Sql: " . mysqli_error($conectar) );
	// 5 RECORRER EL RESULTADO
	echo "<div class='dropdown-content'>";
	while ($Registro1 = mysqli_fetch_array($Resultado1)){ echo "<a href='$Registro1[mennom].php'>$Registro1[mendes]</a>"; }
    echo "</div></div>";
	}
?>
		
</body>
</html>

