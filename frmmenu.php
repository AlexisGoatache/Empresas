<?php 

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="Menu";
$FrmDescripcion="Men&uacute;";
$TbNombre="tbmenu";

// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtNombre = isset($_REQUEST['TxtNombre']) ? $_REQUEST['TxtNombre'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;
$CmbTipo = isset($_REQUEST['CmbTipo']) ? $_REQUEST['CmbTipo'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;


//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $TbNombre WHERE menid='$TxtId'";
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

     $Sql="SELECT * FROM $TbNombre WHERE mendes='$TxtDescripcion';";
     $Resultado=mysqli_query($conectar,$sql);
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
     $sql="INSERT INTO $TbNombre VALUES('',
                                        '$TxtNombre',
                                        '$TxtDescripcion',
                                        '$CmbTipo',
                                        '$CmbStatus');";
     mysqli_query($conectar,$sql);
     ?>
       <script>alert ("Los datos fueron registrados con éxito!!!");</script>
     <?php
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Este Menú ya está registrado!!!");</script>
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
     $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error() );
     ?>
     <script>alert ("Los datos fueron modificado con éxito!!!")</script>
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
<meta name="generator" content="Bluefish 2.2.7" >
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />

<script type="text/javascript">

function validar(form){

          if (form.TxtDescripcion.value==0 ){
               alert('Debe introducir la descripción del Status');
               form.TxtDescripcion.focus();
               return false;}

else {return true;}
}

function validabuscar(form){
    if (form.TxtId.value==0 ){
       alert('Debe introducir el Código del Status');
       return false;}
    else {

      return true;}
}

</script>
</head>
<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="Frm.<?php echo $FrmNombre?>" method="post">
      <fieldset>
          <legend> <?php  echo $FrmDescripcion ?> </legend>
				<label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php echo $TxtId ?>"
                 
                 size="5"
                 maxlength="3" /><br />
                 
          	<label>NOMBRE:</label>
          <input type="text"
                 name="TxtNombre"
                 value="<?php echo $TxtNombre ?>"
                 size="35"
                 maxlength="35" /><br />

          	<label>DESCRIPCI&Oacute;N:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<?php echo $TxtDescripcion ?>"
                 size="35"
                 maxlength="35" /><br />


          <label>TIPO MEN&Uacute;:</label>
          <select name="CmbTipo">
          <option value="0">Seleccione</option>
          <?php
          $Sql="SELECT * FROM tbtipomenu";
          // 4 ejecutar la consulta
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error() );
          while ($Registro = mysqli_fetch_array($Resultado)) {
              if ($CmbTipo==$Registro['tipid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[tipid]\" $x>$Registro[tipdes]</option>";}?>
          </select><br />
          
          <label>STATUS:</label>
          <select name="CmbStatus" >
          <option value="0">Seleccione</option>
          <?php 
          $Sql="SELECT * FROM tbstatus";
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error() );
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
      
      <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>

</form>
</body>

</html>






