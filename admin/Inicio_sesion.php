<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <?php
    session_start();

    // Include objects
    include_once "../config/Database.php";
    include_once "../objects/Usuario.php";

    $databaseObject = new Database();
    $db = $databaseObject->getConnection();

    $usr = new Usuario($db);

    $usr->username = $_POST["usuario"];
    $usr->password = $_POST["clave"];

    $_SESSION['usuario'] = $usr->username;

    if($usr->exists() && password_verify($_POST["clave"], $usr->getHash())){
      
      if($usr->isAdmin()){
        header('location: Administracion.php');
      }else{
        header('location: Retorno_login.php');
      }
    }else{
      header('location: Retorno_login.php');
    }
    
    ?>
  </body>
</html>
