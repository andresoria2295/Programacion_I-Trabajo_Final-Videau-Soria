<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Nuevo registro
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <br>
          <?php
            session_start();

            if (empty($_SESSION['usuario'])) {
              header('location: Retorno_login.php');
              exit;
            }

            echo "Administrador acreditado: {$_SESSION['usuario']}";
            ?>
          <br><br><br>
          <h2>Creación de registro usuario</h2>
          <h5>Completar los siguientes campos</h5>
          <br><br>
          <form class="formulario" action="Inicio_sesion.php" method="POST">
            <div class="form-group">
              <label for="usuario">Nombre de usuario: </label>
              <input type="text" class="form-control" name="usuario" id="user" aria-describedby="emailHelp">
              <small id="emailHelp" class="form-text text-muted"></small>
            </div>
            <div class="form-group">
              <label for="clave">Contraseña: </label>
              <input type="password" class="form-control" name="clave" id="pass">
              <small id="passwordHelp" class="form-text text-muted">Requerimiento mínimo de 8 caracteres.</small>
            </div>
            <br>
              <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Aceptar</button>
            <br><br>
          </form>
          <br><br><br>
        </div>
        </div>
        <div class="col-md-3">
        </div>
  </body>
</html>
