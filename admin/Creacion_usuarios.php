<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $user = $_POST['usuario'];
  $pass = $_POST['clave'];
  $rol = $_POST['rol'];

/*
  if(isset($_POST["role"])){
    $rol = "1";
  }else {
    $rol = "0";
  }
*/
  $servidor = 'localhost';
  $usuario = 'root';
  $clave = '31081995AndSor';
  $base = 'transporte';

  $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

  $sql = 'select * from usuario';
  $ejec_sql = $conexion->prepare($sql);
  $ejec_sql -> execute();

  $registro = array('username' => $user, 'password' => $pass, 'rol' => $rol);

  $sql = "INSERT INTO usuario (username, password, rol) VALUES (:username, :password, :rol)";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Administracion_usuarios.php');
  die();
 ?>
