<?php

  $user = $_POST['usuario'];
  $pass = $_POST['clave'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $sql = 'select * from users';
  $ejec_sql = $conexion->prepare($sql);
  $ejec_sql -> execute();

  $registro = array('username' => $user, 'password' => $pass);

  $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Login.html');
  die();
 ?>
