<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $name = $_POST['name'];
  $country = $_POST['country'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $sql = 'select * from sistema_transporte';
  $ejec_sql = $conexion->prepare($sql);
  $ejec_sql -> execute();

  $registro = array('nombre' => $name, 'pais_procedencia' => $country);

  $sql = "INSERT INTO sistema_transporte (nombre, pais_procedencia) VALUES (:nombre, :pais_procedencia)";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Registro_sist_transporte.php');
  die();
 ?>
