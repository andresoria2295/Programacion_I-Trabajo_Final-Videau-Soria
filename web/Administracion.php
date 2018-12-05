<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Panel de Administración
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/adm_style.css" />
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
           <form class="adm_user" action="Administracion_usuarios.php" method="POST">
             <?php
                 echo "Administrador acreditado: {$_SESSION['usuario']}";
              ?>
             <br><br><br><br><br>
             <h3>Plataforma de Administración</h3>
             <br>
             <button type="submit" class="btn btn-primary btn-lg btn-block">Administración de Usuarios</button>
             <br>
           </form>
           <form class="audit_register" action="Registros_auditoria.php" method="POST">
             <button type="submit" class="btn btn-primary btn-lg btn-block">Registros de Auditoría</button>
             <br>
           </form>
           <form class="audit_export" action="Exportacion_auditoria.php" method="POST">
             <button type="submit" class="btn btn-primary btn-lg btn-block">Exportación de Auditoría</button>
           </form>
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-1">
            <form class="quit" action="Login.html" method="POST">
              <button type="submit" class="btn btn-secondary">Salir</button>
            </form>
          </div>
        </div>
     </div>
  </body>
</html>
