 <?php
//1. CONECTAR MYSQL CON EL MANEJADOR DE BD
$conectar=mysqli_connect('localhost','root','','bdempresas');

function conectar(){
  //1. CONECTAR MYSQL CON EL MANEJADOR DE BD
  mysqli_connect ('localhost','root','');
  //2. SELECCIONAR LA BD
  mysqli_select_db('bdempresas');}

function desconectar(){
    mysql_close();}
?>

