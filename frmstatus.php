<?php 

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="";
$FrmDescripcion="";
$TbNombre="";

// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;


//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':

     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM tbstatus WHERE staid='$TxtId'";
     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     // 5. verificar si lo encontro
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)>0){
         //6. recuperar registros
         //$TxtId=$registro['staid'];
		 $TxtDescripcion=$registro['stades'];
         }
         else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?php 
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':
     $sql="SELECT * FROM tbstatus WHERE stades='$TxtDescripcion';";
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)==0){
       $sql="INSERT INTO tbstatus VALUES('','$TxtDescripcion');";
     mysql_query($sql);
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
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>REGISTRO DE STATUS</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />

<script type="text/javascript">

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
</head>
<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="FrmStatus" method="post">
      <fieldset>

          <legend> AGREGAR STATUS </legend>

          <label>ID:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php ($TxtId <> " " ? $TxtId : "*Proximo")?>"
                 size="5"
                 maxlength="3" /><br />

          <label>STATUS:</label>
          <input type="text"
                 name="TxtDescripcion"
                 value="<?php echo $TxtDescripcion ?>"
                 size="35"
                 maxlength="35" /><br />

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






