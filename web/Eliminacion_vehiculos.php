<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $id = $_GET['vehiculo_id'];
  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $registro = array('vehiculo_id' => $id);

  $sql = "DELETE FROM vehiculo WHERE vehiculo_id = :vehiculo_id";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);
  //echo "$id";
  header('location: Registro_vehiculos.php');
 ?>
