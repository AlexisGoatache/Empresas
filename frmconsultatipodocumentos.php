<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="ConsultaTipoDocumentos";
$FrmDescripcion="Consulta Tipo de Documentos";
$TbNombre="tbtipodocumentos";

// RESCATAR LAS VARIABLES DEL FORMULARIO

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$CmbTipoDocumentos = isset($_REQUEST['CmbTipoDocumentos']) ? $_REQUEST['CmbTipoDocumentos'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  
  
//FUNCIONES
function query($Sql) {
    echo "<table>"; //<!--TABLA DE CONSULTA DE EMPRESAS-->
    // 4 EJECUTAR LA CONSULTA
    $Resultado = mysql_query($Sql) or die( "Error en $Sql: " . mysql_error() );
    // 5. VERIFICA SI ENCONTRO REGISTROS
    $Registro=mysql_fetch_array($Resultado);
    if(mysql_num_rows($Resultado)>0){

    echo "<tr>"; //<!--ENCABEZADO DE LA CONSULTA-->
    echo "<th>#</th>";
    echo "<th>Id</th>";
    echo "<th>Status</th>";
    echo "<th>Tipo Documento</th>";
    echo "</tr>";
    $i=0;
	// 5 RECORRER EL RESULTADO DE LA CONSULTA
    do{
    $i=$i+1;
	echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$Registro['tipid']."</td>";  //<!-- ID -->
    echo "<td>".$Registro['stades']."</td>";   //<!-- STATUS -->
    echo "<td>".$Registro['tipdes']."</td>";  //<!-- DESCRIPCION -->
    echo "</tr>"; 
    }while($Registro=mysql_fetch_array($Resultado));
        } else {
         ?><script>alert ("No existen registros con esa condici�n!!!");</script>
		 <?php }
         return $Sql;

  echo"</table>";
  mysql_close($conectar);}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<title><?php echo $FrmDescripcion ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
<script type="text/javascript">
</script>

</head>

<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="<?php echo "Frm".$FrmNombre ?>" method="post">
      <fieldset>
        <legend><?php echo $FrmDescripcion ?></legend>
          <table>
            <tr>
              <th>Status</th>
              <th>Tipo Documento</th>
            </tr>
           <tr>
             <div align=center>
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
             </div>
           </tr>
            <tr>
              <td>
                <select name="CmbStatus">
                  <option value="0">Seleccione</option>
                  <?php // 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $Sql="SELECT * FROM tbstatus;";
                  // 4 EJECUTAR LA CONSULTA
                  $Resultado = mysql_query($Sql) or die( "Error en $Sql: " . mysql_error() );
                  // 5 RECORRER EL RESULTADO
                  while ($Registro = mysql_fetch_array($Resultado)) {
                    echo "<option value='$Registro[staid]'>$Registro[stades]</option>";}?>
                </select>
              </td>
              <td>
                <select name="CmbTipoDocumentos">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $Sql="SELECT * FROM tbtipodocumentos;";
                // 4 EJECUTAR LA CONSULTA
                $Resultado = mysql_query($Sql) or die( "Error en $Sql: " . mysql_error() );
                // 5 RECORRER EL RESULTADO
                while ($Registro = mysql_fetch_array($Resultado)) {
                  echo "<option  value='$Registro[tipid]'>$Registro[tipdes]</option>";}?>
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
		
		$Sql="SELECT * FROM $TbNombre,tbstatus WHERE
			tbtipodocumentos.tipsta=tbstatus.staid $Consulta ORDER BY $TbNombre.tipid ASC;";

			query($Sql);
?>

</body>
</table>
    <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>
</html>