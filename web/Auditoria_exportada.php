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
          <br><br><br>
          <a href="Administracion.php">Volver a panel de administración</a>
         </div>
         <div class="col-md-1">
         </div>
       </div>
     </div>
     <?php
            include_once "../config/Database.php";
            include_once "../objects/Auditoria.php";

            $database = new Database();
            $db = $database->getConnection();

            $audit = new Auditoria($db);

            $fecha_1 = $_POST["date_1"];
            $fecha_2 = $_POST["date_2"];

            //echo "$fecha_1";
            //echo "$fecha_2";

            $audit->exportAudit($fecha_1, $fecha_2);
           ?>
  </body>
</html>
