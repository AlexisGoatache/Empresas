<?php

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATAR LAS VARIABLES DEL FORMULARIO
$BtnAccion=isset($_REQUEST['BtnAccion'])? $_REQUEST['BtnAccion']: NULL;
$CmbTipoDocumentos=isset($_REQUEST['CmbTipoDocumentos'])?$_REQUEST['CmbTipoDocumentos']: NULL;
$CmbCampoDocumentos=isset($_REQUEST['CmbCampoDocumentos'])?$_REQUEST['CmbCampoDocumentos']: NULL;
$CmbStatus=isset($_REQUEST['CmbStatus'])?$_REQUEST['CmbStatus']: NULL;
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmconsultatipodocdetalle'";
$Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}  
	
//FUNCIONES

function query($Sql) {
	global $Conectar;
	
    echo "<table>"; //<!--TABLA DE CONSULTA DE EMPRESAS-->
    // 4 EJECUTAR LA CONSULTA
    $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
    // 5. VERIFICA SI ENCONTRO REGISTROS
    $Registro=mysqli_fetch_array($Resultado);
    if(mysqli_num_rows($Resultado)>0){

    echo "<tr>"; //<!--ENCABEZADO DE LA CONSULTA-->
    echo "<th>#</th>";
    echo "<th>Id</th>";
    echo "<th>Tipo Documento</th>";
    echo "<th>Campo</th>";
	echo "<th>Status</th>";
	echo "</tr>";
    $i=0;
	// 5 RECORRER EL RESULTADO DE LA CONSULTA
    do{
    $i=$i+1;
	echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$Registro['tipid']."</td>";  //<!-- ID -->
    echo "<td>".$Registro['tipdes']."</td>";   //<!-- TIPO DOCUMENTO -->
	 echo "<td>".$Registro['camdes']."</td>";   //<!-- CAMPO -->
    echo "<td>".$Registro['stades']."</td>";  //<!-- DESCRIPCION -->
    echo "</tr>"; 
    }while($Registro=mysqli_fetch_array($Resultado));
        } else {
         ?><script>alert ("No existen registros con esa condici�n!!!");</script>
		 <?php }
         return $Sql;

  echo"</table>";
  mysqli_close($Conectar);}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?php echo $_SESSION['FrmDescripcion'] ?></title>
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
</head>

<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre] ?>" method="post">
      <fieldset>

        <legend><?php echo $_SESSION['FrmDescripcion'] ?></legend>

          <table>

            <tr>
              <th>Tipo Documento</th>
              <th>Campos Documentos</th>
			  <th>Status</th>
            </tr>

           <tr>
             <div align="center">
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
             </div>
           </tr>

            <tr>

              <td>
                <select name="CmbTipoDocumentos">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $Sql="SELECT * FROM tbtipodocumentos ORDER BY tbtipodocumentos.tipdes ASC;";
                // 4 EJECUTAR LA CONSULTA
                $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
                // 5 RECORRER EL RESULTADO
                while ($Registro = mysqli_fetch_array($Resultado)) {
                  echo "<option  value='$Registro[tipid]'>$Registro[tipdes]</option>";}?>
                </select>
              </td>

              <td>
                <select name="CmbCampoDocumentos">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $Sql="SELECT * FROM tbcampos ORDER BY tbcampos.camdes ASC;";
                // 4 EJECUTAR LA CONSULTA
                $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
                // 5 RECORRER EL RESULTADO
                while ($Registro = mysqli_fetch_array($Resultado)) {
                  echo "<option  value='$Registro[camid]'>$Registro[camdes]</option>";}?>
                </select>
              </td>			  
			  
              <td>
                <select name="CmbStatus">
                  <option value="0">Seleccione</option>
                  <?php // 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $Sql="SELECT * FROM tbstatus ORDER BY tbstatus.stades ASC;";
                  // 4 EJECUTAR LA CONSULTA
                  $Resultado = mysqli_query($Conectar,$Sql) or die( "Error en Sql: " . mysqli_error($Conectar) );
                  // 5 RECORRER EL RESULTADO
                  while ($Registro = mysqli_fetch_array($Resultado)) {
                    echo "<option value='$Registro[staid]'>$Registro[stades]</option>";}?>
                </select>
              </td>

          </table>
     <hr />

 <?php // 3. CONSTRUIR CONSULTA

    $Consulta = '';
    
	if($CmbTipoDocumentos != 0){
		$Consulta= $Consulta." AND tbtipodocumentos.tipid='$CmbTipoDocumentos'";}
		
	if($CmbCampoDocumentos != 0){
		$Consulta= $Consulta." AND $TbNombre.camid='$CmbCampoDocumentos'";}		
	
	if($CmbStatus != 0){
      $Consulta = $Consulta." AND tbstatus.staid= '$CmbStatus'";}
	
		$Sql="SELECT * FROM $_SESSION[TbNombre],tbtipodocumentos,tbstatus WHERE
			tbtipodocumentos.tipsta=tbstatus.staid $Consulta ORDER BY 
			tbtipodocumentos.tipdes,$_SESSION[TbNombre].camdes ASC;";
		query($Sql);
?>

<script>

</script>

</body>
</table>

    <a href='frmmenucss.php'><img src='imagenes/back.gif' border="0"></a>

</html>