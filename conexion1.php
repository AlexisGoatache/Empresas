<?

function conectar(){
  //1. CONECTAR MYSQL CON EL MANEJADOR DE BD
  mysql_connect ('localhost','root','oh43ts7259i9q18');
  //2. SELECCIONAR LA BD
  mysql_select_db('bdempresas');}

function desconectar(){
    mysql_close();}
?>


