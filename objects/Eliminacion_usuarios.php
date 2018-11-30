<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }
  
  $id = $_GET['chofer_id'];
  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $registro = array('chofer_id' => $id);

  $sql = "DELETE FROM chofer WHERE chofer_id = :chofer_id";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);
  echo "$id";
  //header('location: Administracion_usuarios.php');
 ?>
