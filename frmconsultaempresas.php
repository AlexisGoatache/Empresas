<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="ConsultaEmpresas";
$FrmDescripcion="Consulta de Empresas";
$TbNombre="tbempresas";

// RESCATAR LAS VARIABLES DEL FORMULARIO

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$CmbEmpresas = isset($_REQUEST['CmbEmpresas']) ? $_REQUEST['CmbEmpresas'] : NULL;
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
    }while($Registro=mysql_fetch_array($Resultado));
        } else {
         ?><script>alert ("No existen registros con esa condición!!!");</script>
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

function cambiartipodocumento(que){

    valorid=eval(que);
    cadena='Alexis';
    <?php  echo 'cadena';
    $val = "<script> document.write(valorid) </script>";
    $resultado = mysql_query("SELECT * FROM tbtipodocumentos;");
    echo 'cadena+="<option value='.$row[0].'>'.$row[2].'</option>";';
    while($row = mysql_fetch_array($resultado)){

        echo 'cadena+="<option value='.$row[0].'>'.$row[2].'</option>";';}?>

    document.getElementById('localidad').innerHTML="<select name="localidad">"+cadena+"</select>";
}
</script>

</head>

<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="<?php echo "Frm".$FrmNombre ?>" method="post">
      <fieldset>
        <legend><?php echo $FrmDescripcion ?></legend>
          <table>
            <tr>
              <th>Empresas</th>
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
                <select name="CmbEmpresas" onchange='cambiartipodocumento(this.value)'>
                  <option value="0">Seleccione</option>
                  <?php // 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $Sql="SELECT * FROM tbempresas ORDER BY tbempresas.empnom ASC;";
                  // 4 EJECUTAR LA CONSULTA
                  $Resultado = mysql_query($Sql) or die( "Error en $Sql: " . mysql_error() );
                  // 5 RECORRER EL RESULTADO
                  while ($Registro = mysql_fetch_array($Resultado)) {
                    echo "<option value='$Registro[empid]'>$Registro[empnom]</option>";}?>
                </select>
              </td>
              <td>
                <select name="CmbTipoDocumentos">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $Sql="SELECT * FROM tbtipodocumentos ORDER BY tbtipodocumentos.tipdes ASC;";
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
    
	if($CmbEmpresas != 0){
      $Consulta = $Consulta." AND tbempresas.empid= '$CmbEmpresas'";}
    
	if($CmbTipoDocumentos != 0){
		$Consulta= $Consulta." AND tbtipodocumentos.tipid='$CmbTipoDocumentos'";}
		
		$Sql="SELECT * FROM tbempresas,tbtipodocumentos,tbcamposdoc,tbcamposval WHERE
          tbcamposdoc.camid=tbcamposval.camid AND tbempresas.empid=tbcamposval.empid AND
          tbempresas.empsta=1 AND tbtipodocumentos.tipsta=1 AND
          tbcamposdoc.camsta=1 AND tbcamposval.valsta=1 $Consulta ORDER BY $TbNombre.empnom ASC";

   query($Sql);
?>

</body>
</table>
    <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>
</html>