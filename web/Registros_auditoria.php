<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Registro de usuarios
    </title>
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
        <!-- <div class="col-md-1">
        </div> -->
        <div class="col-md-1">
          <br>
          <form class="" action="Administracion.php" method="POST">
            <button type="submit" class="btn btn-outline-info">Atrás</button>
          </form>
        </div>
         <div class="col-md-10">
           <br>
           <?php
               echo "Administrador acreditado: {$_SESSION['usuario']}";
            ?>
           <br><br><br>
           <h4>Registros de auditoria: </h4>
           <br>
           <table border="3">
             <?php
               $servidor = 'localhost';
               $usuario = 'root';
               $clave = '31081995AndSor';
               $base = 'transporte';

               $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

               $sql = 'select * from auditoria';
               $ejec_sql = $conexion -> prepare($sql);
               $ejec_sql -> execute();

               echo "<tr>";
               echo "<td>";
               echo "ID auditoria";
               echo "</td>";
               echo "<td>";
               echo "Fecha de acceso";
               echo "</td>";
               echo "<td>";
               echo "Usuario";
               echo "</td>";
               echo "<td>";
               echo "Tiempo de respuesta";
               echo "</td>";
               echo "<td>";
               echo "URL";
               echo "</td>";
               echo "<td>";
               echo "Fecha de creación";
               echo "</td>";
               echo "</tr>";
               while($fila = $ejec_sql -> fetch(PDO::FETCH_ASSOC)){
                echo "<tr>";
                foreach($fila as $campo){
                  echo "<td>";
                  echo $campo;
                  echo "</td>";
                }
              }
              ?>
           </table>
           <br>
         </div>
         <!-- <div class="col-md-">
         </div>-->
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
