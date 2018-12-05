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
  $id = $_POST['vehiculo_id'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $registro = array('patente' => $patent, 'anho_patente' => $patent_year, 'anho_fabricacion' => $production_year, 'marca' => $brand, 'modelo' => $model, 'vehiculo_id' => $id);

  $sql = "UPDATE vehiculo SET patente = :patente, anho_patente = :anho_patente, anho_fabricacion = :anho_fabricacion, marca = :marca, modelo = :modelo WHERE vehiculo_id = :vehiculo_id";
  $ejec_sql = $conexion-> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Registro_vehiculos.php');
 ?>
