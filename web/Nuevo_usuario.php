<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Creación de registro
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/forms_style.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1">
          <br>
          <form class="" action="Administracion_usuarios.php" method="POST">
            <button type="submit" class="btn btn-outline-info">Atrás</button>
          </form>
        </div>
        <div class="col-md-2">
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
          <h2>Creación de registro</h2>
          <h5>Completar los siguientes campos</h5>
          <br><br>
          <form class="formulario" action="Creacion_usuarios.php" method="POST">
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
            <div class="form-row">
              <input class="form-check-input" type="radio" id="inlineFormCheck" name="rol" value="1">
              <label class="form-check-label" for="inlineFormCheck">Administrador</label>
            </div>
            <div class="form-row">
              <input class="form-check-input" type="radio" id="inlineFormCheck" name="rol" value="0">
              <label class="form-check-label" for="inlineFormCheck">Usuario</label>
            </div>
              <br>
              <button type="submit" class="btn btn-outline-primary">Aceptar</button>
              <br><br>
          </form>
          <br><br><br>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-1">
          <br>
          <form class="quit" action="Login.html" method="POST">
            <button type="submit" class="btn btn-outline-secondary">Salir</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
