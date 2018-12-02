<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $id = $_GET['user_id'];
  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $registro = array('user_id' => $id);

  $sql = "DELETE FROM usuario WHERE user_id = :user_id";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($id);
  echo "$id";
  //header('location: Administracion_usuarios.php');
 ?>
