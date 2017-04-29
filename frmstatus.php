<?php 

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="Status";
$FrmDescripcion="Estatus";
$TbNombre="tbstatus";

// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;


//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':

     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM $TbNombre WHERE staid='$TxtId'";
     //4. Ejecutar la consulta
     $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error() );
     // 5. verificar si lo encontro
     $registro=mysqli_fetch_array($resultado);
     if(mysqli_num_rows($resultado)>0){
         //6. recuperar registros
       $TxtId=$registro['staid'];
		 $TxtDescripcion=$registro['stades'];
         }
         else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?php 
         $BtnAccion='Limpiar';}
     break;

case 'Agregar':
     $sql="SELECT * FROM $TbNombre WHERE stades='$TxtDescripcion';";
     $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error() );
     $registro=mysqli_fetch_array($resultado);
     if(mysqli_num_rows($resultado)==0){
       $sql="INSERT INTO tbstatus VALUES('','$TxtDescripcion');";
     mysqli_query($conectar,$sql);
     ?>
       <script>alert ("Los datos fueron registrados con éxito!!!");</script>
     <?php 
     }else{
     ?>
       <script>alert ("Este Status ya está registrado, en el "<?php $TxtId?>" !!!");</script>
     <?php 
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE tbstatus SET `stades`='$TxtDescripcion' WHERE staid='$TxtId'";
     //4. Ejecutar la consulta
     $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error() );
     ?>
     <script>alert ("Los datos fueron modificado con éxito!!!")</script>
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






