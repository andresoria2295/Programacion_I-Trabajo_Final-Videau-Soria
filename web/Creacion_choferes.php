<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  print_r($_POST);

  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $dni = $_POST['dni'];
  $email = $_POST['email'];
  $system_id = $_POST['system_id'];
  $vehicle_id = $_POST['vehicle_id'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);
/*
  $sql = 'select * from chofer';
  $ejec_sql = $conexion->prepare($sql);
  $ejec_sql -> execute();*/

  $registro = array('nombre' => $name, 'apellido' => $surname, 'documento' => $dni, 'email' => $email, 'vehiculo_id' => $vehicle_id, 'sistema_id' => $system_id);
  echo "<pre>";
  echo "$registro";
  echo "</pre>";
  $sql = "INSERT INTO chofer (nombre, apellido, documento, email, vehiculo_id, sistema_id) VALUES (:nombre, :apellido, :documento, :email, :vehiculo_id, :sistema_id)";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);

  //header('location: Registro_choferes.php');
  die();
 ?>
