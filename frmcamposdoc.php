<?php 
//INICIO DE SESSION DE USUARIO
//session_start();

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSql
//2. CONECTAR CON BD
require_once("conexion.php");

//VARIABLES DEL FORMULARIO
$FrmNombre="CamposDocumento";
$FrmDescripcion="Campo del Documento";
$TbNombre="tbcamposdoc";

//RESCATE DE VARIABLES
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$CmbTipId = isset($_REQUEST['CmbTipId']) ? $_REQUEST['CmbTipId'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;  
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;  

//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $TbNombre WHERE camid='$TxtId';";
     //4. Ejecutar la consulta
     $Resultado=mySql_query($Sql);
     // 5. verificar si lo encontro
     $Registro=mySql_fetch_array($Resultado);
     if(mySql_num_rows($Resultado)>0){
         //6. recuperar Registros
         $CmbTipId=$Registro['tipid'];
         $TxtDescripcion=$Registro['camdes'];
         $CmbStatus=$Registro['camsta'];
         } else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?php 
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':

     $Sql="SELECT * FROM $TbNombre WHERE tipid='$CmbTipId' AND camdes='$TxtDescripcion';";
     $Resultado=mySql_query($Sql);
     $Registro=mySql_fetch_array($Resultado);
     if(mySql_num_rows($Resultado)==0){
     $Sql="INSERT INTO $TbNombre VALUES('',
                                        '$CmbTipId',
                                        '$TxtDescripcion',
                                         '$CmbStatus');";
     mySql_query($Sql);
     ?>
       <script>alert ("Los datos fueron registrados con �xito!!!");</script>
     <?php 
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Este <?php  echo $FrmDescripcion;?> ya est� registrado!!!");</script>
     <?php 
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $Sql="UPDATE $TbNombre SET `tipid`='$CmbTipId',
                                `camdes`='$TxtDescripcion',
                                `camsta`='$CmbStatus' WHERE camid='$TxtId'";

     //4. Ejecutar la consulta
     $Resultado = mySql_query($Sql) or die( "Error en $Sql: " . mySql_error() );
     ?>
     <script>alert ("Los datos fueron modificado con �xito!!!")</script>
     <?php 
     break;
}

if ($BtnAccion=='Limpiar'){
         $TxtId='';
         $CmbTipId='';
         $TxtDescripcion='';
         $CmbStatus='';
     unset($BtnAccion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?php  echo $FrmDescripcion ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />

<style type="text/css">
.fila{background-color:#ffffcc;}
.filaalterna{background-color:#ffcc99;}
.fdg_sortable {cursor:pointer;text-decoration:underline;color:#00c;}
</style> 

<script type="text/javascript">

function validar(form){
         if (form.CmbTipId.value==0){
            alert('Debe introducir un tipo del <?php echo $FrmDescripcion?>');
            form.CmbTipId.focus();
            return false;}

         else if (form.TxtDescripcion.value==0){
           alert('Debe introducir la descripci�n del <?php echo $FrmDescripcion?>');
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
       alert('Debe introducir el C�digo del <?php echo $FrmDescripcion?>');
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

          <label>Id:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php  echo $TxtId; ?>"
                 size="6"
                 maxlength="6" /><br />

          <label>Tipo de campo:</label>
          <select name="CmbTipId">
          <option value="0">Seleccione</option>
          <?php //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbtipodocumentos WHERE tipsta='1';";
          // 4 ejecutar la consulta
          $Resultado = mySql_query($Sql) or die( "Error en $Sql: " . mySql_error() );
          // 5 recorrer el Resultado
          while ($Registro = mySql_fetch_array($Resultado)) {
              if ($CmbTipId==$Registro['tipid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[tipid]\" $x>$Registro[tipdes]</option>";}?>
          </select><br />


          <label>Descripci�n:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<?php  echo $TxtDescripcion; ?>"
                 size="60"
                 maxlength="60" /><br />

          <label>Status:</label>
          <select name="CmbStatus">
          <option value="0">Seleccione</option>
          <?php //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbstatus";
          // 4 ejecutar la consulta
          $Resultado = mySql_query($Sql) or die( "Error en $Sql: " . mySql_error() );
          // 5 recorrer el Resultado
          while ($Registro = mySql_fetch_array($Resultado)) {
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





