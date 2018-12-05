<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Creación de registro vehículo
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
          <h2>Creación de registro vehículo</h2>
          <h5>Completar los siguientes campos</h5>
          <br><br>
          <form class="register" action="Creacion_vehiculos.php" method="POST">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="patente">Dominio</label>
                <input type="text" class="form-control" name="patente" id="patente" placeholder="Patente del vehículo">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="patente_anio">Año de dominio</label>
                <input type="text" class="form-control" name="patente_anio" id="patente_anio" placeholder="">
              </div>
              <div class="form-group col-md-6">
                <label for="fabric_anio">Año de fabricación</label>
                <input type="text" class="form-control" name="fabric_anio" id="fabric_anio" placeholder="">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-9">
                <label for="nombre_marca">Marca</label>
                <input type="text" class="form-control" name="nombre_marca" id="nombre_marca">
              </div>
              <div class="form-group col-md-3">
                <label for="mod">Modelo</label>
                <input type="text" class="form-control" name="mod" id="mod" placeholder="">
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
