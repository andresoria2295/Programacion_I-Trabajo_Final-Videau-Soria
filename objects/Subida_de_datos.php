<?php
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $dni = $_POST['dni'];
  $email = $_POST['email'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $sql = 'select * from persona';
  $ejec_sql = $conexion->prepare($sql);
  $ejec_sql -> execute();

  $registro = array('nombre' => $name, 'apellido' => $surname, 'documento'=> $dni, 'email'=> $email);

  $sql = "INSERT INTO persona (nombre, apellido, documento, email) VALUES (:nombre, :apellido, :documento, :email)";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Administracion_usuarios.php');
  die();
 ?>
