<?php
//INICIO DE SESSION DE USUARIO
session_start();
//VERIFICA QUE ESTE LOGUEADO
if ($_SESSION['empid']==""){
?>
<script>alert('Para entrar en esta secci�n debe estar logueado!!!');
window.location='index.php'; </script>
<?php
}
?>