<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $patent = $_POST['patente'];
  $patent_year = $_POST['patente_anio'];
  $production_year = $_POST['fabric_anio'];
  $brand = $_POST['nombre_marca'];
  $model = $_POST['mod'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $sql = 'select * from vehiculo';
  $ejec_sql = $conexion->prepare($sql);
  $ejec_sql -> execute();

  $registro = array('patente' => $patent, 'anho_patente' => $patent_year, 'anho_fabricacion' => $production_year, 'marca' => $brand, 'modelo' => $model);

  $sql = "INSERT INTO vehiculo (patente, anho_patente, anho_fabricacion, marca, modelo) VALUES (:patente, :anho_patente, :anho_fabricacion, :marca, :modelo)";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Registro_vehiculos.php');
  die();
 ?>
