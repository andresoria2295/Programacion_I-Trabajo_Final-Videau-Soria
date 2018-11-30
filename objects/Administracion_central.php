<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Panel de Administración
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <br><br>
    <?php
      session_start();
     ?>
     <div class="container-fluid">
       <div class="row">
         <div class="col-md-3">
         </div>
         <div class="col-md-6" class="central">
           <form class="adm_user" action="Administracion_usuarios.php" method="POST">
             <h3>Panel de Administración</h3>
             <br>
             <button type="submit" class="btn btn-secondary btn-lg btn-block">Administración de Usuarios</button>
             <br>
           </form>
           <form class="audit_register" action="Registro_auditoria.php" method="POST">
             <button type="submit" class="btn btn-secondary btn-lg btn-block">Registros de Auditoría</button>
             <br>
           </form>
           <form class="audit_export" action="Exportacion_auditoria.php" method="POST">
             <button type="submit" class="btn btn-secondary btn-lg btn-block">Exportación de Auditoría</button>
           </form>
          </div>
          <div class="col-md-3">
          </div>
        </div>
     </div>
  </body>
</html>
