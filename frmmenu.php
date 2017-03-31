<?php

//INICIO DE SESSION DE USUARIO
session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="Menu";
$FrmDescripcion="Men�";
$TbNombre="tbmenu";

// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtNombre = isset($_REQUEST['TxtNombre']) ? $_REQUEST['TxtNombre'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;
$CmbTipo = isset($_REQUEST['CmbTipo']) ? $_REQUEST['CmbTipo'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;

// DESARROLLAR LA LOGICA DE LOS BOTONES
switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $TbNombre WHERE menid='$TxtId'";
     //4. Ejecutar la consulta
     $Resultado=mysql_query($sql);
     // 5. verificar si lo encontro
     $Registro=mysql_fetch_array($Resultado);
     if(mysql_num_rows($Resultado)>0){
         //6. recuperar registros
         $TxtNombre=$Registro['mennom'];
         $TxtDescripcion=$Registro['mendes'];
         $CmbTipo=$Registro['mentip'];
         $CmbStatus=$Registro['mensta'];
         } else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?php
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':

     $Sql="SELECT * FROM $TbNombre WHERE mendes='$TxtDescripcion';";
     $Resultado=mysql_query($Sql);
     $Registro=mysql_fetch_array($Resultado);
     if(mysql_num_rows($Resultado)==0){
     $sql="INSERT INTO $TbNombre VALUES('',
                                        '$TxtNombre',
                                        '$TxtDescripcion',
                                        '$CmbTipo',
                                        '$CmbStatus');";
     mysql_query($sql);
     ?>
       <script>alert ("Los datos fueron registrados con �xito!!!");</script>
     <?php
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Este Men� ya est� registrado!!!");</script>
     <?php
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE $TbNombre SET  `mennom`='$TxtNombre',
                              `mendes`='$TxtDescripcion',
                              `mentip`='$CmbTipo',
                              `mensta`='$CmbStatus' WHERE menid='$TxtId'";

     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     ?>
     <script>alert ("Los datos fueron modificado con �xito!!!")</script>
     <?php
     break;
}

if ($BtnAccion=='Limpiar'){
         $TxtId='';
         $TxtNombre='';
         $TxtDescripcion='';
         $CmbTipo='';
         $CmbStatus='';
     unset($BtnAccion);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><?php echo $FrmDescripcion?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />

<style type="text/css">
.fila{background-color:#ffffcc;}
.filaalterna{background-color:#ffcc99;}
.fdg_sortable {cursor:pointer;text-decoration:underline;color:#00c;}
</style> 

<script type="text/javascript">

function validar(form){

          if (form.TxtNombre.value==0 ){
               alert('Debe introducir el Nombre');
               form.TxtNombre.focus();
               return false;}

          else if (form.TxtDescripcion.value==0 ){
                 alert('Debe introducir una Descripci�n');
                 form.TxtDescripcion.focus();
                 return false;}

          else if (form.CmbTipo.value==0 ){
                 alert('Debe introducir un Tipo de Men�');
                 form.CmbTipo.focus();
                 return false;}

          else if (form.CmbStatus.value==0 ){
                 alert('Debe introducir un Status');
                 form.CmbStatus.focus();
                 return false;}


else {return true;}
}

function validabuscar(form){
    if (form.TxtId.value==0 ){
       alert('Debe introducir el C�digo');
       return false;}
    else {

      return true;}
}

</script>
</head>
<body bgcolor="#FFFFFF">

<form action="<?php echo $PHP_SELF ?>" name="Frm.<?php echo $FrmNombre?>" method="post">
      <fieldset>

          <legend><?php echo $FrmDescripcion?></legend>

          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php echo $TxtId?>"
                 size="4"
                 maxlength="4" /><br />

          <label>TIPO MEN�:</label>
          <select name="CmbTipo">
          <option value="0">Seleccione</option>
          <?php
		  //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbtipomenu";
          // 4 ejecutar la consulta
          $Resultado = mysql_query($Sql) or die( "Error en $Sql: " . mysql_error() );
          // 5 recorrer el resultado
          while ($Registro = mysql_fetch_array($Resultado)) {
              if ($CmbTipo==$Registro['tipid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[tipid]\" $x>$Registro[tipdes]</option>";}?>
          </select><br />

          <label>NOMBRE:</label>
          <input type="text"
                 name="TxtNombre"
                 value="<?php echo $TxtNombre ?>"
                 size="35"
                 maxlength="35" /><br />

          <label>DESCRIPCI�N:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<?php echo $TxtDescripcion ?>"
                 size="35"
                 maxlength="35" /><br />

          <label>STATUS:</label>
          <select name="CmbStatus">
          <option value="0">Seleccione</option>
                   <?php
		  //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbstatus";
          // 4 ejecutar la consulta
          $Resultado = mysql_query($Sql) or die( "Error en $Sql: " . mysql_error() );
          // 5 recorrer el resultado
          while ($Registro = mysql_fetch_array($Resultado)) {
              if ($CmbStatus==$Registro['staid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[staid]\" $x>$Registro[stades]</option>";}?>
          </select><br />
          <hr />

          <div align=center>
               <input type="submit" name="BtnAccion" value="Buscar" onclick="return validabuscar(this.form);"/>
               <input type="submit" name="BtnAccion" value="Agregar"  onclick="return validar(this.form);"/>
               <input type="submit" name="BtnAccion" value="Modificar" onclick="return validar(this.form);"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
          </div>
      </fieldset>

      <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>

</form>
</body>

</html>






