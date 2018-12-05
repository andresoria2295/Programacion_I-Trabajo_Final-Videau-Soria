<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Exportación de auditoria</title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/registers_style.css" />
  </head>
  <body>
    <?php
      session_start();

     if (empty($_SESSION['usuario'])) {
       header('location: Retorno_login.php');
        exit;
      }
     ?>
     <div class="container-fluid">
       <div class="row">
         <div class="col-md-4">
         </div>
         <div class="col-md-4" class="central">
           <br>
           <form class="" action="Auditoria_exportada.php" method="POST">
             <?php
                 echo "Administrador acreditado: {$_SESSION['usuario']}";
              ?>
             <br><br><br>
             <h4>Exportación de auditoria </h4>
             <br>
             <label for="date_1">Fecha de inicio: </label>
             <input type="date" name="date_1" required>
             <br><br>
             <label for="date_2">Fecha de cierre: </label>
             <input type="date" name="date_2" required><br><br>
             <button type="submit" class="btn btn-outline-primary">Enviar</button>
           </form>
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
