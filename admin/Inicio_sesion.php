<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <?php
    session_start();

    $servidor = "localhost";
    $usuario = "root";
    $clave = "31081995AndSor";
    $base = "transporte";

    $user = $_POST["usuario"];
    $password = $_POST["clave"];

    $_SESSION['usuario'] = $user;

    $conectar = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

    $query = "SELECT * FROM usuario WHERE username = :usuario AND password = :clave";
    $stmt = $conectar->prepare($query);

    // Bind
    $stmt->bindParam(":usuario", $user);
    $stmt->bindParam(":clave", $password);

    //echo json_encode(array("mensaje"=>$user));
    //echo json_encode(array("mensaje"=>$password));
    $stmt->execute();

    $cantidad = $stmt->rowCount();

    if($cantidad > 0){
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          if($row["rol"] == "1"){
            header('location: Administracion.php');
          }else if($row["rol"] == "0"){
            header('location: Usuario.php');
          }else{
            header('location: Retorno_login.php');
          }
      }
    }else {
      header('location: Retorno_login.php');
    }
    ?>
  </body>
</html>
