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
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  
  
//FUNCIONES
function query($Sql) {
global $conectar,$Consulta;

    echo "<table>"; //<!--TABLA DE CONSULTA DE EMPRESAS-->
    // 4 EJECUTAR LA CONSULTA
    $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
    // 5. VERIFICA SI ENCONTRO REGISTROS
    $Registro=mysqli_fetch_array($Resultado);
    if(mysqli_num_rows($Resultado)>0){

    echo "<tr>"; //<!--ENCABEZADO DE LA CONSULTA-->
    echo "<th>#</th>";
    echo "<th>Id</th>";
    echo "<th>Empresa</th>";
    echo "<th>Estatus</th>";
    echo "</tr>";
    $i=0;
	// 5 RECORRER EL RESULTADO DE LA CONSULTA
    do{
    $i=$i+1;
	echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$Registro['empid']."</td>";  //<!-- ID EMPRESA -->
    echo "<td>".$Registro['empnom']."</td>";   //<!-- NOMBRE EMPRESA -->
    echo "<td>".$Registro['stades']."</td>";  //<!-- ESTATUS -->
    echo "</tr>"; 
    }while($Registro=mysqli_fetch_array($Resultado));
        } else {
         ?><script>alert ("No existen registros con esa condici�n!!!");</script>
		 <?php }
         return $Sql;

  echo"</table>";
  mysqli_close($conectar);}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<title><?php echo $FrmDescripcion ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="Bluefish 2.2.7" >
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
<script type="text/javascript">

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

</head>

<body bgcolor="#FFFFFF">

<form action="<?php $PHP_SELF ?>" name="<?php echo "Frm".$FrmNombre ?>" method="post">
      <fieldset>
        <legend><?php echo $FrmDescripcion ?></legend>
          <table>
            <tr>
              <th>Empresas</th>
              <th>Estatus</th>
            </tr>
            <tr>
              <td>
                <select name="CmbEmpresas" onchange='cambiartipodocumento(this.value)'>
                  <option value="0">Seleccione</option>
                  <?php // 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $Sql="SELECT * FROM tbempresas ORDER BY tbempresas.empnom ASC;";
                  // 4 EJECUTAR LA CONSULTA
                  $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                  // 5 RECORRER EL RESULTADO
                  while ($Registro = mysqli_fetch_array($Resultado)) {
                    echo "<option value='$Registro[empid]'>$Registro[empnom]</option>";}?>
                </select>
              </td>
              <td>
                <select name="CmbStatus">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $Sql="SELECT * FROM tbstatus ORDER BY tbstatus.stades ASC;";
                // 4 EJECUTAR LA CONSULTA
                $Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                // 5 RECORRER EL RESULTADO
                while ($Registro = mysqli_fetch_array($Resultado)) {
                  echo "<option  value='$Registro[staid]'>$Registro[stades]</option>";}?>
                </select>
              </td>
			</tr>
			<tr>
             <div align=center>
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
             </div>
         </tr>
          
          
          </table>
     <hr />

 <?php // 3. CONSTRUIR CONSULTA

    $Consulta = '';
    
	if($CmbEmpresas != 0){
      $Consulta = $Consulta." AND $TbNombre.empid= '$CmbEmpresas'";}
    
	if($CmbStatus != 0){
		$Consulta= $Consulta." AND tbstatus.staid='$CmbStatus'";}
		
		$Sql="SELECT * FROM $TbNombre,tbstatus WHERE
          $TbNombre.empsta=tbstatus.staid $Consulta ORDER BY 				 
          $TbNombre.empnom  ASC";

   query($Sql);
?>

</body>
</table>
    <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>
</html>