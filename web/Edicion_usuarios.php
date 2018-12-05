<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $user = $_POST['usuario'];
  $pass = $_POST['clave'];
  $rol = $_POST['rol'];
  $id = $_POST['usuario_id'];

  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);
/*
  $sql = "select * from usuario";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute();
*/
  $registro = array('username' => $user, 'password' => $pass, 'rol' => $rol, 'user_id' => $id);

  $sql = "UPDATE users SET username = :username, password = :password, rol = :rol WHERE user_id = :user_id";
  $ejec_sql = $conexion-> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Administracion_usuarios.php');
 ?>
