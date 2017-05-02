<?php 

// INICIO DE SESSION DEL USUARIO
//session_start();

//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// VARIABLES DEL FORMULARIO
$FrmNombre="ConsultaMenu";
$FrmDescripcion="Consulta de Menú";
$TbNombre="tbmenu";

// RESCATAR LAS VARIABLES DEL FORMULARIO
  
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$CmbTipoMenu = isset($_REQUEST['CmbTipoMenu']) ? $_REQUEST['CmbTipoMenu'] : NULL;
$CmbStatus = isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;  

//FUNCIONES

function query($sql) {
global $conectar;

    echo "<table>";// <!--TABLA DE CONSULTA DE DISPOSITIVOS-->
        // 4 EJECUTAR LA CONSULTA
        $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error($conectar) );
        // 5. VERIFICA SI ENCONTRO REGISTROS
        $registro=mysqli_fetch_array($resultado);
        if(mysqli_num_rows($resultado)>0){

        echo"<tr>";// <!--ENCABEZADO DE LA CONSULTA-->
        echo"<th>#</th>";
        echo"<th>Id</th>";
        echo"<th>Nombre</th>";
        echo"<th>Descripción</th>";
        echo"<th>Tipo de Menú</th>";
        echo"<th>Status</th>";
        echo"</tr>";

          $i=0;
          // 5 RECORRER EL RESULTADO DE LA CONSULTA
          do{
            $i=$i+1;
            echo"<tr>";
            echo"<td>".$i."</td>";
            echo"<td>".$registro['menid']."</td>";
            echo"<td>".$registro['mennom']."</td>";
            echo"<td>".$registro['mendes']."</td>";
            echo"<td>".$registro['tipdes']."</td>";
            echo"<td>".$registro['stades']."</td>";

      echo"</tr>"; 
                  }while($registro=mysqli_fetch_array($resultado));
        } else {
         ?>
         <script>alert ("No existen registros con esa condición!!!");</script>
         <?php }

         return $sql;
  echo"</table>";
  mysql_close($conectar);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><?php  echo $FrmDescripcion ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="Bluefish 2.2.7" >
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
<script type="text/javascript">
</script>


</head>

<body bgcolor="#FFFFFF">

<form action="<?php  $PHP_SELF ?>" name="<?php  echo "Frm".$FrmNombre ?>" method="post">
      <fieldset>

        <legend><?php  echo $FrmDescripcion ?></legend>

          <table>

            <tr>
              <th>Tipo de Menú</th>
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
                <select name="CmbTipoMenu">
                <option value="0">Seleccione</option>
                <?php // 3. CONSTRUIR CONSULTA TIPO DE DOCUMENTO
                $sql="SELECT * FROM tbtipomenu;";
                // 4 EJECUTAR LA CONSULTA
                $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                // 5 RECORRER EL RESULTADO
                while ($registro = mysqli_fetch_array($resultado)) {
                  echo "<option  value='$registro[tipid]'>$registro[tipdes]</option>";}?>
                </select>
              </td>

              <td>
                <select name="CmbStatus">
                  <option value="0">Seleccione</option>
                  <?php // 3. CONSTRUIR CONSULTA DE EMPRESAS
                  $sql="SELECT * FROM tbstatus;";
                  // 4 EJECUTAR LA CONSULTA
                  $resultado = mysqli_query($conectar,$sql) or die( "Error en Sql: " . mysqli_error($conectar) );
                  // 5 RECORRER EL RESULTADO
                  while ($registro = mysqli_fetch_array($resultado)) {
                    echo "<option value='$registro[staid]'>$registro[stades]</option>";}?>
                </select>
              </td>

          </table>
     <hr />



  <?php // 3. CONSTRUIR CONSULTA

    $consulta = '';
    if($CmbTipoMenu != 0){
      $consulta= $consulta." AND tbmenu.mentip='$CmbTipoMenu'";}

    if($CmbStatus != 0){
      $consulta = $consulta." AND tbstatus.staid= '$CmbStatus'";}

    $sql="SELECT * FROM tbmenu,tbtipomenu,tbstatus WHERE
          tbmenu.mensta=tbstatus.staid AND tbmenu.mentip=tbtipomenu.tipid $consulta ORDER BY $TbNombre.menid asc;";

   query($sql);
  ?>

</body>
</table>

    <a href='frmmenucss.php'><img src='imagenes/back.gif' border=0></a>

</html>