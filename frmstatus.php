<?php 
//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmstatus'";
$Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}

//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

    case '<< Primero':
     
     $Sql="SELECT * FROM $_SESSION[TbNombre] ORDER BY $_SESSION[TbNombre].staid ASC LIMIT 1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
      $TxtId=$Registro['staid'];
		  $TxtDescripcion=$Registro['stades'];
         }
     break;

case '< Anterior':
    $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE staid=$TxtId-1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
      $TxtId=$Registro['staid'];
		  $TxtDescripcion=$Registro['stades'];         
      }
         
     break;

case 'Siguiente >':
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE staid=$TxtId+1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
      $TxtId=$Registro['staid'];
		  $TxtDescripcion=$Registro['stades'];
         }
     break;

case 'Último >>':
     $Sql="SELECT * FROM $_SESSION[TbNombre] ORDER BY $_SESSION[TbNombre].staid DESC LIMIT 1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
        $TxtId=$Registro['staid'];
		    $TxtDescripcion=$Registro['stades'];         
         }
     break;  
     
case 'Buscar':
     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM $_SESSION[TbNombre] WHERE staid='$TxtId'";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
      $TxtId=$Registro['staid'];
		  $TxtDescripcion=$Registro['stades'];
         }
         else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?php 
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':
     $sql="SELECT * FROM $_SESSION[TbNombre] WHERE stades='$TxtDescripcion';";
     $Resultado = mysqli_query($Conexion,$sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
       $sql="INSERT INTO tbstatus VALUES('','$TxtDescripcion');";
     mysqli_query($Conexion,$sql);
     ?>
       <script>alert ("Los datos fueron registrados con �xito!!!");</script>
     <?php 
     }else{
     ?>
       <script>alert ("Este Status ya est� registrado, en el "<?php $TxtId?>" !!!");</script>
     <?php 
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE tbstatus SET `stades`='$TxtDescripcion' WHERE staid='$TxtId'";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     ?>
     <script>alert ("Los datos fueron modificado con �xito!!!")</script>
     <?php 
     break;
}

if ($BtnAccion=='Limpiar'){
         $TxtId='';
         $TxtDescripcion='';
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
<body>

<form action="<?php $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre] ?>" method="post">
      <fieldset>

          <legend> <?php  echo $_SESSION['FrmDescripcion'] ?> </legend>

          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php echo $TxtId ?>"
                 maxlength="3" 
                 placeholder="Id Status"/><br />

          <label>STATUS:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<?php echo $TxtDescripcion ?>"
                 maxlength="35" 
                 placeholder="Descripci&oacute;n del men&uacute;"/><br />

          <hr />
          <div align="center">
               <input type="submit" name="BtnAccion" value="<< Primero"/>
               <input type="submit" name="BtnAccion" value="< Anterior"/>
               <input type="submit" name="BtnAccion" value="Siguiente >"/>
               <input type="submit" name="BtnAccion" value="&Uacute;ltimo >>" />
          </div>
          
          <div align="center">
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






