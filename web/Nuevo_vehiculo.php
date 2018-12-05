<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Creación de registro vehiculo
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/forms_style.css" />
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

            echo "Usuario acreditado: {$_SESSION['usuario']}";
            ?>
          <br><br><br>
          <h2>Creación de registro vehiculo</h2>
          <h5>Completar los siguientes campos</h5>
          <br><br>
          <form class="register" action="Creacion_vehiculos.php" method="POST">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="nombre del conductor">
              </div>
              <div class="form-group col-md-6">
                <label for="surname">Apellido</label>
                <input type="text" class="form-control" name="surname "id="surname" placeholder="apellido del conductor">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="dni">Documento</label>
                <input type="text" class="form-control" name="dni" id="dni">
              </div>
              <div class="form-group col-md-9">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Ej. pepe.honguito@gmail.com">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-10">
                <label for="system_id">Medio de transporte</label>
                <select id="system_id" name="system_id" class="form-control">
                  <option selected>seleccionar...</option>
                  <option value="1">100</option>
                  <option value="2">101</option>
                  <option value="3">102</option>
                  <option value="4">104</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label for="vehicle_id">Vehículo</label>
                <input type="text" class="form-control" id="vehicle_id" name="vehicle_id" placeholder="unidad">
              </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">Aceptar</button>
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
