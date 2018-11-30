<?php
  session_start();

  if (empty($_SESSION['usuario'])) {
    header('location: Retorno_login.php');
    exit;
  }
  
  $id = $_POST['driver_id'];
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

  $sql = "select * from chofer";
  $ejec_sql = $conexion -> prepare($sql);
  $ejec_sql -> execute();

  $registro = array('chofer_id' => $id, 'nombre' => $name, 'apellido' => $surname, 'documento' => $dni, 'email' => $email, 'vehiculo_id'=> $vehicle_id, 'sistema_id'=> $system_id);

  $sql = "UPDATE chofer SET nombre = :nombre, apellido = :apellido, documento = :documento, email = :email, vehiculo_id = :vehiculo_id, sistema_id = :sistema_id WHERE chofer_id = :chofer_id";
  $ejec_sql = $conexion-> prepare($sql);
  $ejec_sql -> execute($registro);

  header('location: Administracion_usuarios.php');
 ?>
