<?
//INICIO DE SESSION DE USUARIO
session_start();

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="TipoMenu";
$FrmDescripcion="Tipo de Menú";
$TbNombre="tbtipomenu";

// RESCATAR LAS VARIABLES DEL FORMULARIO
$TxtId=$_REQUEST['TxtId'];
$TxtDescripcion=$_REQUEST['TxtDescripcion'];
$CmbStatus=$_REQUEST['CmbStatus'];
$BtnAccion=$_REQUEST['BtnAccion'];

//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM $TbNombre WHERE tipid='$TxtId';";
     //4. Ejecutar la consulta
     $resultado=mysql_query($sql);
     // 5. verificar si lo encontro
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)>0){
         //6. recuperar registros
         $TxtId=$registro['tipid'];
         $TxtDescripcion=$registro['tipdes'];
         $CmbStatus=$registro['tipsta'];
         } else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':

     $sql="SELECT * FROM $TbNombre WHERE tipdes='$TxtDescripcion';";
     $resultado=mysql_query($sql);
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)==0){
     $sql="INSERT INTO $TbNombre VALUES('',
                                         '$TxtDescripcion',
                                         '$CmbStatus');";
     mysql_query($sql);
     ?>
       <script>alert ("Los datos fueron registrados con éxito!!!");</script>
     <?
     }else{
     ?>
       <script>alert ("Este <? echo $FrmDescripcion;?> ya está registrado!!!");</script>
     <?
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE $TbNombre SET `tipdes`='$TxtDescripcion',
                                 `tipsta`='$CmbStatus' WHERE tipid='$TxtId'";

     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     ?>
     <script>alert ("Los datos fueron modificado con éxito!!!")</script>
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
<title><? echo $FrmDescripcion ?></title>
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
          if (form.TxtDescripcion.value==0){
               alert('Debe introducir la descripción del <? echo $FrmDescripcion ?>');
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
       alert('Debe introducir el Código del Status');
       return false;}
    else {

      return true;}
}

</script>
</head>
<body bgcolor="#FFFFFF">

<form action="<? $PHP_SELF ?>" name="Frm.<? echo $FrmNombre ?>" method="post">
      <fieldset>

          <legend> TIPO DE MENÚ </legend>

          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<? echo $TxtId; ?>"
                 size="6"
                 maxlength="6" /><br />

          <label>DESCRIPCIÓN:</label>
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
          $sql="SELECT * FROM tbstatus;";
          // 4 ejecutar la consulta
          $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
          // 5 recorrer el resultado
          while ($registro = mysql_fetch_array($resultado)) {
              if ($CmbStatus==$registro['staid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$registro[staid]\" $x>$registro[stades]</option>";}?>
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






