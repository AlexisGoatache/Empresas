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
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE tipid='$TxtId';";
     //4. Ejecutar la consulta
     $Resultado=mysqli_query($conectar,$Sql);
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
     $Resultado = mysqli_query($Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><? echo $_SESSION['FrmDescripcion'] ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />

</head>
<body bgcolor="#FFFFFF">

<form action="<? $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre] ?>" method="post">
      <fieldset>

          <legend> <?php  echo $_SESSION['FrmDescripcion'] ?> </legend>

          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<? echo $TxtId; ?>"
                 size="6"
                 maxlength="6" /><br />

          <label>DESCRIPCI�N:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<? echo $TxtDescripcion; ?>"
                 size="60"
                 maxlength="60" /><br />

          <label>STATUS:</label>
          <select name="CmbStatus">
          <option value="0">Seleccione</option>
          <?//carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbstatus;";
          // 4 ejecutar la consulta
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
          // 5 recorrer el resultado
          while ($Registro = mysqli_fetch_array($Resultado)) {
              if ($CmbStatus==$Registro['staid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[staid]\" $x>$Registro[stades]</option>";}?>
          </select><br />

          <hr />

          <div align=center>
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Agregar"/>
               <input type="submit" name="BtnAccion" value="Modificar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
          </div>

      </fieldset>

      <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>
           

</form>
<script>

</script>

</body>

</html>






