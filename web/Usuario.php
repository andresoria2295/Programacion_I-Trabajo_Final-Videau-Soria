<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Plataforma de transporte
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
             <button type="submit" class="btn btn-secondary btn-lg btn-block">Registro de choferes</button>
             <br>
           </form>
           <form class="audit_register" action="Registro_vehiculos.php" method="POST">
             <button type="submit" class="btn btn-secondary btn-lg btn-block">Registros de vehiculos</button>
             <br>
           </form>
           <form class="audit_export" action="Registro_sist_transporte.php" method="POST">
             <button type="submit" class="btn btn-secondary btn-lg btn-block">Sistemas de transporte</button>
           </form>
          </div>
          <div class="col-md-3">
          </div>
        </div>
     </div>
  </body>
</html>
