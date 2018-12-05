<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $name = $_POST['name'];
  $country = $_POST['country'];
  $id = $_POST['sistema_id'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $registro = array('nombre' => $name, 'pais_procedencia' => $country, 'sistema_id' => $id);

  $sql = "UPDATE sistema_transporte SET nombre = :nombre, pais_procedencia = :pais_procedencia WHERE sistema_id = :sistema_id";
  $ejec_sql = $conexion-> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Registro_sist_transporte.php');
 ?>
