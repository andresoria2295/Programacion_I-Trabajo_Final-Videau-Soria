<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Auditoria exportada
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/forms_style.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
          <br>
          <h2>Auditoria exportada</h2>
          <br>
          <?php
          include_once "../config/Database.php";
          include_once "../objects/Auditoria.php";
          $dabs = new Database();
          $conn = $dabs->getConnection();
          $audit = new Auditoria($conn);
          echo $audit->compdir;
            echo "Se ha efectuado correctamente la exportación de auditoria.";
           ?>
           <br><br>
           <a href="Administracion.php">Volver a panel de administración</a>
         </div>
         <div class="col-md-1">
         </div>
       </div>
     </div>
  </body>
</html>
