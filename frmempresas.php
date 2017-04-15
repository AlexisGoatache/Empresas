<?

//INICIO DE SESSION DE USUARIO
session_start();

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="";
$FrmDescripcion="";
$TbNombre="";


// RESCATAR LAS VARIABLES DEL FORMULARIO
$TxtId=$_REQUEST['TxtId'];
$TxtNombre=$_REQUEST['TxtNombre'];
$TxtPassword=$_REQUEST['TxtPassword'];
$CmbStatus=$_REQUEST['CmbStatus'];
$BtnAccion=$_REQUEST['BtnAccion'];


//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM tbempresas WHERE empid='$TxtId';";
     //4. Ejecutar la consulta
     $resultado=mysql_query($sql);
     // 5. verificar si lo encontro
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)>0){
         //6. recuperar registros
         $TxtId=$registro['empid'];
         $TxtNombre=$registro['empnom'];
         $TxtPassword=$registro['empcla'];
         $CmbStatus=$registro['empsta'];
         } else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':

     $sql="SELECT * FROM tbempresas WHERE empid='$TxtId';";
     $resultado=mysql_query($sql);
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)==0){
     $sql="INSERT INTO tbempresas VALUES('',
                                           '$TxtNombre',
                                           '$TxtPassword',
                                           '$CmbStatus');";
     mysql_query($sql);
     ?>
       <script>alert ("Los datos fueron registrados con éxito!!!");</script>
     <?
     }else{
     ?>
       <script>alert ("Esta Empresa ya está registrada!!!");</script>
     <?
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE tbempresas SET `empnom`='$TxtNombre',
                                 `empcla`='$TxtPassword',
                                 `empsta`='$CmbStatus' WHERE empid='$TxtId'";

     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     ?>
     <script>alert ("Los datos fueron modificado con éxito!!!")</script>
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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>EMPRESAS</title>
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
       alert('Debe introducir el Código de la empresa');
       return false;}
    else {
      return true;}
}

</script>
</head>
<body bgcolor="#FFFFFF">

<form action="<? $PHP_SELF ?>" name="FrmEmpresas" method="post">
      <fieldset>

          <legend> EMPRESAS </legend>
          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<? echo $TxtId; ?>"
                 size="4"
                 maxlength="4" /><br />

          <label>NOMBRE:</label>
          <input type="text"
                 name="TxtNombre"
                 value="<? echo $TxtNombre; ?>"
                 size="35"
                 maxlength="35" /><br />

          <label>PASSWORD:</label>
          <input type="password"
                 name="TxtPassword"
                 value="<? echo $TxtPassword; ?>"
                 size="50"
                 maxlength="50" /><br />

          <label>RE-PASSWORD:</label>
          <input type="password"
                 name="TxtRpassword"
                 value="<? echo $TxtRpassword; ?>"
                 size="50"
                 maxlength="50" /><br />

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






