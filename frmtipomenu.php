<?

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");


// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmtipomenu'";
$Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}
//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

    case '<< Primero':
     
     $Sql="SELECT * FROM $_SESSION[TbNombre] ORDER BY $_SESSION[TbNombre].tipid ASC LIMIT 1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
         $TxtId=$Registro['tipid'];
         $TxtDescripcion=$Registro['tipdes'];
         $CmbStatus=$Registro['tipsta'];
         }
     break;

case '< Anterior':
    $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE tipid=$TxtId-1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
         $TxtId=$Registro['tipid'];
         $TxtDescripcion=$Registro['tipdes'];
         $CmbStatus=$Registro['tipsta'];
      }
         
     break;

case 'Siguiente >':
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE tipid=$TxtId+1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
         $TxtId=$Registro['tipid'];
         $TxtDescripcion=$Registro['tipdes'];
         $CmbStatus=$Registro['tipsta'];
       }
     break;

case 'Último >>':
     $Sql="SELECT * FROM $_SESSION[TbNombre] ORDER BY $_SESSION[TbNombre].tipid DESC LIMIT 1";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
      //6. recuperar registros
         $TxtId=$Registro['tipid'];
         $TxtDescripcion=$Registro['tipdes'];
         $CmbStatus=$Registro['tipsta'];       }
     break; 

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE tipid='$TxtId';";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
         $TxtId=$Registro['tipid'];
         $TxtDescripcion=$Registro['tipdes'];
         $CmbStatus=$Registro['tipsta'];
         } else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':

     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE tipdes='$TxtDescripcion';";
     $Resultado=mysqli_query($Sql);
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
     $Sql="INSERT INTO $_SESSION[TbNombre] VALUES('',
                                         '$TxtDescripcion',
                                         '$CmbStatus');";
     mysqli_query($Sql);
     ?>
       <script>alert ("Los datos fueron registrados con �xito!!!");</script>
     <?
     }else{
     ?>
       <script>alert ("Este <? echo $_SESSION['FrmDescripcion'];?> ya est� registrado!!!");</script>
     <?
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $Sql="UPDATE $_SESSION[TbNombre] SET `tipdes`='$TxtDescripcion',
                                 `tipsta`='$CmbStatus' WHERE tipid='$TxtId'";

     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
     ?>
     <script>alert ("Los datos fueron modificado con �xito!!!")</script>
     <?
     break;
}

if ($BtnAccion=='Limpiar'){
         $TxtId='';
         $TxtDescripcion='';
         $CmbStatus='';
     unset($BtnAccion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><? echo $_SESSION['FrmDescripcion'] ?></title>
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
</head>
<body>

<form action="<? $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre] ?>" method="post">
      <fieldset>

          <legend> <?php  echo $_SESSION['FrmDescripcion'] ?> </legend>

          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<? echo $TxtId; ?>"
                 maxlength="6" 
                 placeholder="Id Tipo Men&uacute;"/><br />

          <label>DESCRIPCI&Oacute;N:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<? echo $TxtDescripcion; ?>"
                 maxlength="60" 
                 placeholder="Descripci&oacute;n Men&uacute;"/><br />

          <label>STATUS:</label>
          <select name="CmbStatus">
          <option value="0">Seleccione</option>
          <?//carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbstatus;";
          // 4 ejecutar la consulta
          $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
          // 5 recorrer el resultado
          while ($Registro = mysqli_fetch_array($Resultado)) {
              if ($CmbStatus==$Registro['staid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[staid]\" $x>$Registro[stades]</option>";}?>
          </select><br />

          <hr />
          <div align="center">
               <input type="submit" name="BtnAccion" value="<< Primero"/>
               <input type="submit" name="BtnAccion" value="< Anterior"/>
               <input type="submit" name="BtnAccion" value="Siguiente >"/>
               <input type="submit" name="BtnAccion" value="&Uacute;ltimo >>" />
          </div>

          <div align="center">
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Agregar"/>
               <input type="submit" name="BtnAccion" value="Modificar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
          </div>

      </fieldset>

      <a href='frmmenucss.php'><img src='imagenes/back.gif' border="0"></a>
           

</form>
<script>

</script>

</body>

</html>