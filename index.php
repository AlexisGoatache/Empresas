 <?php 
 //INICIAL EL ARCHIVO DE CONEXION PARA TODA LA PAGINA
require_once('conexion.php');

//INICIO DE SESION
session_unset();
//session_destroy();
session_start();
//var_dump($_SESSION);

//No chequeamos esta pagina en el navegador
session_cache_limiter('nocache,private');

// VARIABLES DEL FORMULARIO
$FrmNombre="EMPRESAS";
$FrmDescripcion="SISTEMA EMPRESAS";
$TbNombre="";

// RESCATE DE VARIABLES DEL FORMULARIO

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtUsuario = isset($_REQUEST['TxtUsuario']) ? $_REQUEST['TxtUsuario'] : NULL;
$TxtPassword = isset($_REQUEST['TxtPassword']) ? $_REQUEST['TxtPassword'] : NULL;



//Comprobacion del envio del nombre de usuario y password
    

// DESARROLLAR LOGICA DE LOS BOTONES

if ($BtnAccion=='Enviar'){

  $Sql="SELECT * FROM tbempresas WHERE empid='$TxtUsuario'";
  $Resultado = mysql_query($Sql) or die("Error en $Sql: " . mysql_error());

  if(mysql_num_rows($Resultado)>0){ //SI LA CANTIDAD DE REGISTROS ES MAYOR QUE 0
    $Registro=mysql_fetch_array($Resultado); //TRAIGO COMO ARRAY LA INF.
    if ($Registro['empcla']==$TxtPassword){
      $_SESSION['empid']=$TxtUsuario; //APERTURA LA SESION DEL USUARIO
      $_SESSION['empdes']=$Registro['empnom'];
	  ?><script>window.location='frmmenucss.php'; </script><?php
	  }else{?><script>alert('La contraseña no conincide');</script><?php } 
	  }else{?><script>alert('El usuario no existe'+'<?php echo $TxtUsuario?>');</script><?php }
	  }
  ?>	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title> EMPRESAS </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
</head>
<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="Frm.<?php echo $FrmNombre?>" method="post">

<div align="center">
<h2>...:: <?php echo $FrmDescripcion?> ::...</h2>
<table style="border:1px solid #000000;">
<tr>
  <td align="right">
    <label>Usuario:   </label>
    <input type="text"
           name="TxtUsuario"
           value="<?php echo $TxtUsuario?>"
           size="10"
           maxlength="10" /><br />
  </td>
</tr>

<tr>
  <td align="right">
    <label>Password:</label>
    <input type="password"
           name="TxtPassword"
           value="<?php echo $TxtPassword?>"
           size="10"
           maxlength="10" /><br />
  </td>
</tr>
<tr> 
  <td align="center">  <input type="submit" name="BtnAccion" value="Enviar" /> </td>
</tr>

</table>

<img src="imagenes/image001.gif" alt="" title="construccionx" width="222" height="301" border="0" />
</div>
</body>
</html>