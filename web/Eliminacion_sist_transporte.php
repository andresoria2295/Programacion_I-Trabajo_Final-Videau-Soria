<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $id = $_GET['sistema_id'];
  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $registro = array('sistema_id' => $id);

  $sql = "DELETE FROM sistema_transporte WHERE sistema_id = :sistema_id";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);
  //echo "$id";
  header('location: Registro_sist_transporte.php');
 ?>
