<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Panel de usuario
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <br>
    <?php
      session_start();

     if (empty($_SESSION['usuario'])) {
       header('location: Retorno_login.php');
        exit;
      }
     ?>
     <div class="container-fluid">
       <div class="row">
         <div class="col-md-3">
         </div>
         <div class="col-md-6" class="central">
           <form class="adm_user" action="Registro_choferes.php" method="POST">
             <?php
                 echo "Usuario acreditado: {$_SESSION['usuario']}";
              ?>
             <br><br><br>
             <h3>Plataforma de transporte</h3>
             <br>
             <button type="submit" class="btn btn-primary btn-lg btn-block">Registro de Choferes</button>
             <br>
           </form>
           <form class="audit_register" action="Registro_vehiculos.php" method="POST">
             <button type="submit" class="btn btn-primary btn-lg btn-block">Registro de Vehículos</button>
             <br>
           </form>
           <form class="audit_export" action="Registro_sist_transporte.php" method="POST">
             <button type="submit" class="btn btn-primary btn-lg btn-block">Sistemas de Transporte</button>
           </form>
          </div>
          <div class="col-md-3">
          </div>
        </div>
     </div>
  </body>
</html>
