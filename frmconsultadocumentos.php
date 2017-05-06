<?

// INICIO DE SESSION DEL USUARIO
//session_start();

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
$Sql="SELECT * FROM tbmenu WHERE mennom='frmconsultadocumentos'";
$Resultado = mysqli_query($conectar,$Sql) or die( "Error en Sql: " . mysqli_error($conectar) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}  
  
//FUNCIONES

function query($sql) {
global $conectar;	?>


    <table> <!--TABLA DE CONSULTA DE DISPOSITIVOS-->
        <?// 4 EJECUTAR LA CONSULTA
        $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error($conectar) );
        // 5. VERIFICA SI ENCONTRO REGISTROS
        $registro=mysqli_fetch_array($resultado);
        if(mysqli_num_rows($resultado)>0){?>

          <tr> <!--ENCABEZADO DE LA CONSULTA-->
            <th>#</th>
            <th>Id</th>
            <th>Empresa</th>
            <th>Tipo Documento</th>
            <th>Campo Documento</th>
            <th>Campo Valor</th>
          </tr>

          <?$i=0;
          // 5 RECORRER EL RESULTADO DE LA CONSULTA
          do{
            $i=$i+1;?>
            <tr>
            <td><?echo $i?></td>             <!-- NRO. DE DISPOSITIVOS -->
            <td><?echo $registro[empid]?> </td>  <!-- ID DISPOSITIVO -->
            <td><?echo $registro[empnom]?></td>   <!-- DESCRIPCION DEL DISPOSITIVO -->
            <td><?echo $registro[tipdes]?></td>  <!-- MARCA -->
            <td><?echo $registro[camdes]?></td>  <!-- MODELO -->
            <td><?echo $registro[valcam]?></td>  <!-- SERIAL -->
      </tr><?
                  }while($registro=mysqli_fetch_array($resultado));
        } else {
         ?>
         <script>alert ("No existen registros con esa condici�n!!!");</script>
         <?}

         return $sql;

  echo"</table>";
  mysqli_close($conectar);}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><? echo $FrmDescripcion ?></title>
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
</head>

<body bgcolor="#FFFFFF">

<form action="<? $PHP_SELF ?>" name="<? echo "Frm".$FrmNombre ?>" method="post">
      <fieldset>

        <legend><? echo $FrmDescripcion ?></legend>

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
                <select name="CmbEmpresas">
                  <option value="0">Seleccione</option>
                  <?// 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $sql="SELECT * FROM tbempresas;";
                  // 4 EJECUTAR LA CONSULTA
                  $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                  // 5 RECORRER EL RESULTADO
                  while ($registro = mysqli_fetch_array($resultado)) {
                    echo "<option value='$registro[empid]'>$registro[empnom]</option>";}?>
                </select>
              </td>

              <td>
                <select name="CmbTipoDocumentos">
                <option value="0">Seleccione</option>
                <?// 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $sql="SELECT * FROM tbtipodocumentos;";
                // 4 EJECUTAR LA CONSULTA
                $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                // 5 RECORRER EL RESULTADO
                while ($registro = mysqli_fetch_array($resultado)) {
                  echo "<option  value='$registro[tipid]'>$registro[tipdes]</option>";}?>
                </select>
              </td>


          </table>
     <hr />



  <?// 3. CONSTRUIR CONSULTA

    $consulta = '';
    if($CmbEmpresas != 0){
      $consulta = $consulta." AND tbempresas.empid= '$CmbEmpresas'";}
    if($CmbTipoDocumentos != 0){
      $consulta= $consulta." AND tbtipodocumentos.tipid='$CmbTipoDocumentos'";}

    $sql="SELECT * FROM tbempresas,tbtipodocumentos,tbcamposdoc,tbcamposval WHERE
          tbcamposdoc.camid=tbcamposval.camid AND tbempresas.empid=tbcamposval.empid AND
          tbcamposdoc.tipid=tbtipodocumentos.tipid AND tbempresas.empsta=1 AND tbtipodocumentos.tipsta=1 AND
          tbcamposdoc.camsta=1 AND tbcamposval.valsta=1 $consulta ORDER BY $TbNombres.empid asc;";

   query($sql);
  ?>
<script>

</script>

</body>
</table>

    <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>

</html>