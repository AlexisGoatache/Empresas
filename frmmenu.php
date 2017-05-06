<?php 

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtNombre = isset($_REQUEST['TxtNombre']) ? $_REQUEST['TxtNombre'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;
$CmbTipo = isset($_REQUEST['CmbTipo']) ? $_REQUEST['CmbTipo'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;
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

//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar1':

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE menid='$TxtId'";
     //4. Ejecutar la consulta
     $Resultado=mysqli_query($conectar,$Sql);
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
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

     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE mendes='$TxtDescripcion';";
     $Resultado=mysqli_query($conectar,$sql);
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
     $sql="INSERT INTO $_SESSION[TbNombre] VALUES('',
                                        '$TxtNombre',
                                        '$TxtDescripcion',
                                        '$CmbTipo',
                                        '$CmbStatus');";
     mysqli_query($conectar,$sql);
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
     $sql="UPDATE $_SESSION[TbNombre] SET  `mennom`='$TxtNombre',
                              `mendes`='$TxtDescripcion',
                              `mentip`='$CmbTipo',
                              `mensta`='$CmbStatus' WHERE menid='$TxtId'";

     //4. Ejecutar la consulta
     $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error($conectar) );
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

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<title><?php echo $_SESSION['FrmDescripcion']?></title>
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
</head>
<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre] ?>" method="post">
      <fieldset>
          <legend> <?php  echo $_SESSION['FrmDescripcion'] ?> </legend>
				<label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php echo $TxtId ?>"
                 size="5"
                 maxlength="3" 
                 placeholder="Id Men&uacute;"/><br />
                 
          	<label>NOMBRE:</label>
          <input type="text"
                 name="TxtNombre"
                 value="<?php echo $TxtNombre ?>"
                 size="35"
                 maxlength="35" 
                 placeholder="Nombre del Men&uacute;"/><br />

          	<label>DESCRIPCI&Oacute;N:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<?php echo $TxtDescripcion ?>"
                 size="35"
                 maxlength="35" 
                 placeholder="Descripci&oacute; del Men&uacute;"/><br />


          <label>TIPO MEN&Uacute;:</label>
          <select name="CmbTipo">
          <option value="0">Seleccione</option>
          <?php
          $Sql="SELECT * FROM tbtipomenu";
          // 4 ejecutar la consulta
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
          while ($Registro = mysqli_fetch_array($Resultado)) {
              if ($CmbTipo==$Registro['tipid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[tipid]\" $x>$Registro[tipdes]</option>";}?>
          </select><br />
          
          <label>STATUS:</label>
          <select name="CmbStatus" >
          <option value="0">Seleccione</option>
          <?php 
          $Sql="SELECT * FROM tbstatus";
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
          while ($Registro = mysqli_fetch_array($Resultado)) {
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
      
      <a href='frmmenucss.php'><img src='imagenes/back.gif' border="0"></a>

</form>

<script>

function validar(form){

          if (form.TxtDescripcion.value==0 ){
               alert('Debe introducir la descripci�n del Status');
               form.TxtDescripcion.focus();
               return false;}

else {return true;}
}

function validabuscar(form){
    if (form.TxtId.value==0 ){
       alert('Debe introducir el C�digo del Status');
       return false;}
    else {

      return true;}
}

</script>

</body>

</html>






