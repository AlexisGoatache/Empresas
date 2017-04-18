<?

function conectar(){
  //1. CONECTAR MYSQL CON EL MANEJADOR DE BD
  mysqli_connect ('localhost','root','oh43ts7259i9q18');
  //2. SELECCIONAR LA BD
  mysqli_select_db('bdempresas');}

function desconectar(){
    mysql_close();}
?>


