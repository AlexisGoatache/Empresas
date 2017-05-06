<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATAR LAS VARIABLES DEL FORMULARIO

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;
$TxtNombre = isset($_REQUEST['TxtNombre']) ? $_REQUEST['TxtNombre'] : NULL;
$TxtPassword = isset($_REQUEST['TxtPassword']) ? $_REQUEST['TxtPassword'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmempresas'";
$Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}

//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){
case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE $_SESSION[TbNombre].empid='$TxtId';";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($conectar,$Sql) or die( "Error en $Sql: " . mysqli_error($conectar) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
         $TxtId=$Registro['empid'];
         $TxtNombre=$Registro['empnom'];
         $TxtPassword=$Registro['empcla'];
         $CmbStatus=$Registro['empsta'];
         } else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?
         $BtnAccion='Limpiar';}
     break;
case 'Agregar':
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE empid='$TxtId';";
     $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
     $Sql="INSERT INTO tbempresas VALUES('',
                                           '$TxtNombre',
                                           '$TxtPassword',
                                           '$CmbStatus');";
     mysqli_query($conectar,$Sql);
     ?>
       <script>alert ("Los datos fueron registrados con �xito!!!");</script>
     <?
     }else{
     ?>
       <script>alert ("Esta Empresa ya est� registrada!!!");</script>
     <?
     }
     break;
case 'Modificar':
     //3. Contruir la consulta (Query)
     $Sql="UPDATE tbempresas SET `empnom`='$TxtNombre',
                                 `empcla`='$TxtPassword',
                                 `empsta`='$CmbStatus' WHERE empid='$TxtId'";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error() );
     ?>
     <script>alert ("Los datos fueron modificado con �xito!!!")</script>
     <?
     break;
}
if ($BtnAccion=='Limpiar'){
         $TxtId='';
         $TxtNombre='';
         $TxtPassword='';
         $CmbStatus='';
     unset($BtnAccion);
}
?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<title><?php echo $FrmDescripcion?></title>
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
</head>
<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre]?>" method="post">
      <fieldset>

          <legend> <?php  echo $_SESSION['FrmDescripcion'] ?> </legend>
          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php echo $TxtId; ?>"
                 size="4"
                 maxlength="4" 
                 placeholder="Id Empresa"/><br />

          <label>NOMBRE:</label>
          <input type="text"
                 name="TxtNombre"
                 value="<?php echo $TxtNombre; ?>"
                 size="35"
                 maxlength="35" 
                 placeholder="Nombre de la empresa"/><br />

          <label>PASSWORD:</label>
          <input type="password"
                 name="TxtPassword"
                 value="<?php echo $TxtPassword; ?>"
                 size="50"
                 maxlength="50" /><br />

          <label>RE-PASSWORD:</label>
          <input type="password"
                 name="TxtRpassword"
                 value="<?php echo $TxtRpassword; ?>"
                 size="50"
                 maxlength="50" /><br />

          <label>STATUS:</label>
          <select name="CmbStatus">
          <option value="0">Seleccione</option>
          <?php
          $Sql="SELECT * FROM tbstatus;";
          // 4 ejecutar la consulta
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error() );
          // 5 recorrer el resultado
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
    if (form.TxtNombre.value==0 ){
       alert('Debe introducir el Nombre de la Empresa');
       return false;}
    else if (form.TxtPassword.value==0 ){
           alert('Debe introducir un Password');
           return false;}
    else if (form.TxtPassword.value==form.TxtRPassword.value ){
           alert('El Password debe coincidir');
           return false;}
    else {
      return true;}
}
function validabuscar(form){
    if (form.TxtId.value==0 ){
       alert('Debe introducir el C�digo de la empresa');
       return false;}
    else {
      return true;}
}
</script>
</body>
</html>