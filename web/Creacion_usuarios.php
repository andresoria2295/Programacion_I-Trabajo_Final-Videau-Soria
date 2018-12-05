<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }

  $user = $_POST['usuario'];
  $pass = password_hash($_POST['clave'], PASSWORD_BCRYPT);
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

  $sql = 'select * from users';
  $ejec_sql = $conexion->prepare($sql);
  $ejec_sql -> execute();

  $registro = array('username' => $user, 'password' => $pass, 'rol' => $rol, 'created' => date('Y-m-d H:i:s'));

  $sql = "INSERT INTO users (username, password, rol, created) VALUES (:username, :password, :rol, :created)";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Administracion_usuarios.php');
  die();
 ?>
