<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATAR LAS VARIABLES DEL FORMULARIO

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$CmbEmpresas = isset($_REQUEST['CmbEmpresas']) ? $_REQUEST['CmbEmpresas'] : NULL;
$CmbTipoDocumentos = isset($_REQUEST['CmbTipoDocumentos']) ? $_REQUEST['CmbTipoDocumentos'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmconsultadocumentosempresas'";
$Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}
	  
//FUNCIONES
function query($Sql) {
global $Conexion;

    echo "<table>"; //<!--TABLA DE CONSULTA DE EMPRESAS-->
    // 4 EJECUTAR LA CONSULTA
    $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
    // 5. VERIFICA SI ENCONTRO REGISTROS
    $Registro=mysqli_fetch_array($Resultado);
    if(mysqli_num_rows($Resultado)>0){

    echo "<tr>"; //<!--ENCABEZADO DE LA CONSULTA-->
    echo "<th>#</th>";
    echo "<th>Id</th>";
    echo "<th>Empresa</th>";
    echo "<th>Tipo Documento</th>";
    echo "<th>Campo Documento</th>";
    echo "<th>Campo Valor</th>";
    echo "</tr>";
    $i=0;
	// 5 RECORRER EL RESULTADO DE LA CONSULTA
    do{
    $i=$i+1;
	echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$Registro['empid']."</td>";  //<!-- ID EMPRESA -->
    echo "<td>".$Registro['empnom']."</td>";   //<!-- NOMBRE EMPRESA -->
    echo "<td>".$Registro['tipdes']."</td>";  //<!-- DESCRIPCION -->
    echo "<td>".$Registro['camdes']."</td>";  //<!-- DESCRIPCION DEL CAMPO -->
    echo "<td>".$Registro['valcam']."</td>";  //<!-- VALOR DEL CAMPO -->
    echo "</tr>"; 
    }while($Registro=mysqli_fetch_array($Resultado));
        } else {
         ?><script>alert ("No existen registros con esa condici�n!!!");</script>
		 <?php }
         return $Sql;

  echo"</table>";
  mysqli_close($Conexion);}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?php echo $_SESSION['FrmDescripcion'] ?></title>
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />

</head>

<body>

<form action="<?php $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre] ?>" method="post">
      <fieldset>
        <legend><?php echo $_SESSION['FrmDescripcion'] ?></legend>
          <table>
            <tr>
              <th>Empresas</th>
              <th>Tipo Documento</th>
            </tr>
            <tr>
              <td>
                <select name="CmbEmpresas">
                  <option value="0">Seleccione</option>
                  <?php // 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $Sql="SELECT * FROM $_SESSION[TbNombre] ORDER BY $_SESSION[TbNombre].empnom ASC;";
                  // 4 EJECUTAR LA CONSULTA
                  $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
                  // 5 RECORRER EL RESULTADO
                  while ($Registro = mysqli_fetch_array($Resultado)) {
                    echo "<option value='$Registro[empid]'>$Registro[empnom]</option>";}?>
                </select>
              </td>
              <td>
                <select name="CmbTipoDocumentos">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $Sql="SELECT * FROM tbtipodocumentos ORDER BY tbtipodocumentos.tipdes ASC;";
                // 4 EJECUTAR LA CONSULTA
                $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
                // 5 RECORRER EL RESULTADO
                while ($Registro = mysqli_fetch_array($Resultado)) {
                  echo "<option  value='$Registro[tipid]'>$Registro[tipdes]</option>";}?>
                </select>
              </td>
			</tr>
			<tr>
             <div align="center">
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
             </div>
         </tr>
          
          
          </table>
     <hr />

 <?php // 3. CONSTRUIR CONSULTA

    $Consulta = '';
    
	if($CmbEmpresas != 0){
      $Consulta = $Consulta." AND $_SESSION[TbNombre].empid= '$CmbEmpresas'";}
    
	if($CmbTipoDocumentos != 0){
		$Consulta= $Consulta." AND tbtipodocumentos.tipid='$CmbTipoDocumentos'";}
		
		$Sql="SELECT DISTINCT * FROM $_SESSION[TbNombre],tbtipodocumentos,tbcampos,tbcamposval WHERE
          $_SESSION[TbNombre].empid=tbcamposval.empid AND tbcamposval.camid=tbcampos.camid AND
          tbcampos.camid=tbcamposval.camid AND tbcamposval.tipid=tbtipodocumentos.tipid AND
          $_SESSION[TbNombre].empsta=1 AND tbtipodocumentos.tipsta=1 AND tbcampos.camsta=1 AND 
          tbcamposval.valsta=1 $Consulta ORDER BY 	
          $_SESSION[TbNombre].empnom,tbtipodocumentos.tipdes,tbcampos.camid  ASC";

   query($Sql);
?>

</body>
<script>

function cambiartipodocumento(que){

    valorid=eval(que);
    cadena='Alexis';
    <?php  echo 'cadena';
    $Val = "<script> document.write(valorid) </script>";
    $Resultado = mysqli_query("SELECT * FROM tbtipodocumentos;");
    echo 'cadena+="<option value='.$Row[0].'>'.$Row[2].'</option>";';
    while($Row = mysqli_fetch_array($Resultado)){

        echo 'cadena+="<option value='.$Row[0].'>'.$Row[2].'</option>";';}?>

    document.getElementById('localidad').innerHTML="<select name="localidad">"+cadena+"</select>";
}
</script>

</table>
    <a href='frmmenucss.php'><img src='imagenes/back.gif' border="0"></a>
</html>