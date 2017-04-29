<?php
//INICIO DE SESSION DE USUARIO
//session_start();

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON mysqli
//2. CONECTAR CON BD
require_once("conexion.php");

//VARIABLES DEL FORMULARIO
$FrmNombre="TipoDocumentos";
$FrmDescripcion="Tipo de Documentos";
$TbNombre="tbtipodocumentos";


// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion=isset($_REQUEST['BtnAccion'])? $_REQUEST['BtnAccion']: NULL;
$TxtId=isset($_REQUEST['TxtId'])? $_REQUEST['TxtId'] : NULL;
$TxtDescripcion=isset($_REQUEST['TxtDescripcion'])? $_REQUEST['TxtDescripcion']: NULL;
$CmbStatus=isset($_REQUEST['CmbStatus'])? $_REQUEST['CmbStatus']: NULL;


//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $TbNombre WHERE tipid='$TxtId';";
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
         <?php
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':

     $Sql="SELECT * FROM $TbNombre WHERE docdes='$TxtDescripcion';";
     $Resultado=mysqli_query($conectar,$Sql);
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
     $Sql="INSERT INTO $TbNombre VALUES('',
                                         '$TxtDescripcion',
                                         '$CmbStatus');";
     mysqli_query($conectar,$Sql);
     ?>
       <script>alert ("Los datos fueron registrados con éxito!!!");</script>
     <?php
     }else{
     ?>
       <script>alert ("Este <?php echo $FrmDescripcion;?> ya está registrado!!!");</script>
     <?php
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $Sql="UPDATE $TbNombre SET `tipdes`='$TxtDescripcion',
                                 `tipsta`='$CmbStatus' WHERE tipid='$TxtId'";

     //4. Ejecutar la consulta
     $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error() );
     ?>
     <script>alert ("Los datos fueron modificado con éxito!!!")</script>
     <?php
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
<title><?php echo $FrmDescripcion ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="generator" content="Bluefish 2.2.7" >
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />


<script type="text/javascript">

function validar(form){
          if (form.TxtDescripcion.value==0){
               alert('Debe introducir la descripción del <?php echo $FrmDescripcion?>');
               form.TxtDescripcion.focus();
               return false;}

               else if (form.CmbStatus.value==0){
                 alert('Debe introducir un Status');
                 form.CmbStatus.focus();
                 return false;}

          else {return true;}
}

function validabuscar(form){
    if (TxtId.value==0 ){
       alert('Debe introducir el Código del <?php echo $FrmDescripcion?>');
       return false;}
    else {

      return true;}
}

</script>
</head>
<body bgcolor="#FFFFFF">

<form action="<?php  $PHP_SELF ?>" name="Frm.<?php  echo $FrmNombre ?>" method="post">
      <fieldset>

          <legend> <?php  echo $FrmDescripcion ?> </legend>

          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php  echo $TxtId; ?>"
                 size="6"
                 maxlength="6" /><br />

          <label>DESCRIPCIÓN:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<?php  echo $TxtDescripcion; ?>"
                 size="60"
                 maxlength="60" /><br />

          <label>STATUS:</label>
          <select name="CmbStatus">
          <option value="0">Seleccione</option>
          <?php //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
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

      <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>

</form>
</body>

</html>






