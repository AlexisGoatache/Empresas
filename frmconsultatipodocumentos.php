<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL y con la BD
require_once("conexion.php");

// RESCATAR LAS VARIABLES DEL FORMULARIO

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$CmbTipoDocumentos = isset($_REQUEST['CmbTipoDocumentos']) ? $_REQUEST['CmbTipoDocumentos'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmconsultatipodocumentos'";
$Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}

//$FrmNombre="ConsultaTipoDocumentos";
//$FrmDescripcion="Consulta Tipo de Documentos";
//$TbNombre="tbtipodocumentos";

  
//FUNCIONES
function query($Sql) {
	global $conectar;
	
    echo "<table>"; //<!--TABLA DE CONSULTA DE EMPRESAS-->
    // 4 EJECUTAR LA CONSULTA
    $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
    // 5. VERIFICA SI ENCONTRO REGISTROS
    $Registro=mysqli_fetch_array($Resultado);
    if(mysqli_num_rows($Resultado)>0){

    echo "<tr>"; //<!--ENCABEZADO DE LA CONSULTA-->
    echo "<th>#</th>";
    echo "<th>Id</th>";
    echo "<th>Tipo Documento</th>";
    echo "<th>Status</th>";
    echo "</tr>";
    $i=0;
	// 5 RECORRER EL RESULTADO DE LA CONSULTA
    do{
    $i=$i+1;
	echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$Registro['tipid']."</td>";  //<!-- ID -->
    echo "<td>".$Registro['tipdes']."</td>";  //<!-- DESCRIPCION -->
    echo "<td>".$Registro['stades']."</td>";   //<!-- STATUS -->
    echo "</tr>"; 
    }while($Registro=mysqli_fetch_array($Resultado));
        } else {
         ?><script>alert ("No existen registros con esa condición!!!");</script>
		 <?php }
         return $Sql;

  echo"</table>";
  mysqli_close($conectar);}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<title><?php echo $_SESSION['FrmDescripcion'] ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="Bluefish 2.2.7" >
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
<script type="text/javascript">
</script>

</head>

<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre]?>" method="post">
      <fieldset>
        <legend><?php echo $_SESSION['FrmDescripcion'] ?></legend>
          <table>
            <tr>
              <th>Tipo Documento</th>
              <th>Status</th>
            </tr>
           <tr>
             <div align=center>
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
             </div>
           </tr>
            <tr>
              <td>
                <select name="CmbTipoDocumentos">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $Sql="SELECT * FROM $_SESSION[TbNombre]";
                // 4 EJECUTAR LA CONSULTA
                $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                // 5 RECORRER EL RESULTADO
                while ($Registro = mysqli_fetch_array($Resultado)) {
                  echo "<option  value='$Registro[tipid]'>$Registro[tipdes]</option>";}?>
                </select>
              </td>
              <td>
                <select name="CmbStatus">
                  <option value="0">Seleccione</option>
                  <?php // 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $Sql="SELECT * FROM tbstatus;";
                  // 4 EJECUTAR LA CONSULTA
                  $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                  // 5 RECORRER EL RESULTADO
                  while ($Registro = mysqli_fetch_array($Resultado)) {
                    echo "<option value='$Registro[staid]'>$Registro[stades]</option>";}?>
                </select>
              </td>
			</tr>
          </table>
     <hr />

 <?php // 3. CONSTRUIR CONSULTA

    $Consulta = '';
    
	if($CmbStatus != 0){
      $Consulta = $Consulta." AND tbstatus.staid= '$CmbStatus'";}
    
	if($CmbTipoDocumentos != 0){
		$Consulta= $Consulta." AND tbtipodocumentos.tipid='$CmbTipoDocumentos'";}
		
		$Sql="SELECT * FROM $_SESSION[TbNombre],tbstatus WHERE
			tbtipodocumentos.tipsta=tbstatus.staid $Consulta ORDER BY $_SESSION[TbNombre].tipid ASC;";

			query($Sql);
?>

</body>
</table>
    <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>
</html>