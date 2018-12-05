<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Creación de sistema de transporte
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/forms_style.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <br>
          <?php
            session_start();

            if (empty($_SESSION['usuario'])) {
              header('location: Retorno_login.php');
              exit;
            }

            echo "Usuario acreditado: {$_SESSION['usuario']}";
            ?>
          <br><br><br>
          <h2>Creación de sistema de transporte</h2>
          <h5>Completar los siguientes campos</h5>
          <br><br>
          <form class="register" action="Creacion_sist_transporte.php" method="POST">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Sistema de transporte">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="country">País de procedencia</label>
                <input type="text" class="form-control" name="country" id="country" placeholder="">
              </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">Aceptar</button>
          </form>
          <br><br><br>
        </div>
        <div class="col-md-3">
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
