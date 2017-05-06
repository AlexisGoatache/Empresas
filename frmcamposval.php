<?php
//INICIO DE SESSION DE USUARIO
//session_start();

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSql
//2. CONECTAR CON BD
require_once("conexion.php");

//RESCATE DE VARIABLES

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$CmbTipId = isset($_REQUEST['CmbTipId']) ? $_REQUEST['CmbTipId'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;  
$TxtId = isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;  
$CmbCamId = isset($_REQUEST['CmbCamId']) ? $_REQUEST['CmbCamId'] : NULL;  
$TxtValor = isset($_REQUEST['TxtValor']) ? $_REQUEST['TxtValor'] : NULL;
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmcamposval'";
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
     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE camid='$TxtId';";
     //4. Ejecutar la consulta
     $Resultado=mysqli_query($conectar,$Sql);
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
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

     $Sql="SELECT * FROM $_SESSION[TbNombre] WHERE valid='$CmbTipId'";
     $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
	 $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
     $Sql="INSERT INTO $_SESSION[TbNombre] VALUES('',
                                        '$CmbTipId',
                                        '$TxtDescripcion',
                                        '$CmbStatus');";
     mysqli_query($conectar,$Sql);
     ?>
       <script>alert ("Los datos fueron registrados con �xito!!!");</script>
     <?php
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Este <?php echo $FrmDescripcion;?> ya est� registrado!!!");</script>
     <?php
     }
     break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $Sql="UPDATE $_SESSION[TbNombre] SET `tipid`='$CmbTipId',
                                `camdes`='$TxtDescripcion',
                                `camsta`='$CmbStatus' WHERE camid='$TxtId'";

     //4. Ejecutar la consulta
     $Resultado = mysqli_query($conectar,$Sql) or die( "Error en $Sql: " . mysqli_error($conectar) );
     ?>
     <script>alert ("Los datos fueron modificado con �xito!!!")</script>
     <?php
     break;
}

if ($BtnAccion=='Limpiar'){
         $TxtId='';
         $CmbTipId='';
         $CmbCamId='';
         $TxtValor='';
         $CmbStatus='';
     unset($BtnAccion);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><?php echo $_SESSION['FrmDescripcion'] ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />


</head>
<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="Frm.<?php echo $FrmNombre ?>" method="post">
      <fieldset>

          <legend> <?php echo $_SESSION['FrmDescripcion'] ?> </legend>

          <label>Id:</label>
          <input type="text"
                 name="TxtId"
                 value="<?php echo $TxtId; ?>"
                 size="6"
                 maxlength="6" /><br />

         <label>Tipo de Documento:</label>
          <select name="CmbTipId" onChange="CamposDocumento(this.form);">
          <option value="0">Seleccione</option>
          <?php //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbtipodocumentos WHERE tipsta='1';";
          // 4 ejecutar la consulta
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en $Sql: " . mysqli_error() );
          // 5 recorrer el Resultado
          while ($Registro = mysqli_fetch_array($Resultado)) {
              if ($CmbTipId==$Registro['tipid']){$x='Selected'; }else{$x='';}
                echo "<option value=\"$Registro[tipid]\" $x>$Registro[tipdes]</option>";}?>
          </select><br />

          <label>Campo:</label>
          <select name="CmbCamId">
          <option value="0">Seleccione</option>
          <?php //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $TipDoc = "<script> document.write(TipDoc) </script>";
		  echo "$TipDoc";
		  //$Sql="SELECT * FROM tbcamposdoc WHERE camsta='1'";
          // 4 ejecutar la consulta
          //$Resultado = mysqli_query($conectar,$Sql) or die( "Error en $Sql: " . mysqli_error() );
          // 5 recorrer el Resultado
          //while ($Registro = mysqli_fetch_array($Resultado)) {
          //    if ($CmbCamId==$Registro['camid']){$x='Selected'; }else{$x='';}
          //      echo "<option value=\"$Registro[camid]\" $x>$Registro[camdes]</option>";}?>
          </select><br />

		  
          <label>Valor:</label>
          <input type="text"
                 name="TxtValor"
                 value="<?php echo $TxtValor; ?>"
                 size="60"
                 maxlength="60" /><br />

          <label>Status:</label>
          <select name="CmbStatus" >
          <option value="0">Seleccione</option>
          <?php //carga el combo con status de dispositivos
          // 3. CONSTRUIR CONSULTA
          $Sql="SELECT * FROM tbstatus";
          // 4 ejecutar la consulta
          $Resultado = mysqli_query($conectar,$Sql) or die( "Error en $Sql: " . mysqli_error($conectar) );
          // 5 recorrer el Resultado
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

<script>

function validar(form){
         if (form.CmbTipId.value==0){
            alert('Debe introducir un tipo del <?php echo $FrmDescripcion?>');
            form.CmbTipId.focus();
            return false;}

         else if (form.TxtValor.value==0){
           alert('Debe introducir Valor del <?php echo $FrmDescripcion?>');
           form.TxtValor.focus();
           return false;}

           else if (form.CmbCamId.value==0){
             alert('Debe introducir un Campo');
             form.CmbCamId.focus();
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

function CamposDocumento(form){	
var TipDoc = form.CmbTipId.value;
var CamposDocumento = form.CmbCamId.selectedIndex
	var arrayResult = mysqli_select_query ("SELECT * FROM tbcamposdoc WHERE tipid=TipDoc AND camsta='1'");
	for (i=0; i< arrayResult.length i++) {
		form.CmbCamId.options[i].text = arrayResult[i][0];
		var fila = arrayResult[i];
		var columna = arrayResult[i][0];
	}
	}
</script>

</body>

</html>