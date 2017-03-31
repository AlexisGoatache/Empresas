<?

// INICIO DE SESSION DEL USUARIO
//session_start();

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

function query($sql) {?>

    <table> <!--TABLA DE CONSULTA DE DISPOSITIVOS-->
        <?// 4 EJECUTAR LA CONSULTA
        $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
        // 5. VERIFICA SI ENCONTRO REGISTROS
        $registro=mysql_fetch_array($resultado);
        if(mysql_num_rows($resultado)>0){?>

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
                  }while($registro=mysql_fetch_array($resultado));
        } else {
         ?>
         <script>alert ("No existen registros con esa condición!!!");</script>
         <?}

         return $sql;

  echo"</table>";
  mysql_close($conectar);}

?>
<!DOCTYPE html>
<html lang="es">

<head>
<title><? echo $FrmDescripcion ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
<script type="text/javascript">
</script>


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
                  $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
                  // 5 RECORRER EL RESULTADO
                  while ($registro = mysql_fetch_array($resultado)) {
                    echo "<option value='$registro[empid]'>$registro[empnom]</option>";}?>
                </select>
              </td>

              <td>
                <select name="CmbTipoDocumentos">
                <option value="0">Seleccione</option>
                <?// 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $sql="SELECT * FROM tbtipodocumentos;";
                // 4 EJECUTAR LA CONSULTA
                $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
                // 5 RECORRER EL RESULTADO
                while ($registro = mysql_fetch_array($resultado)) {
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

</body>
</table>

    <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>

</html>