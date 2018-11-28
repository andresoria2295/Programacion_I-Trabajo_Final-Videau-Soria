<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Administracion de usuarios
    </title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <?php
      session_start();
     ?>
     <div class="container-fluid">
       <div class="row">
         <div class="col-md-2">
         </div>
         <div class="col-md-8">
           <h4>Listado de usuarios registrados: </h4>
           <table border="2">
             <?php
               $servidor = 'localhost';
               $usuario = 'root';
               $clave = '31081995AndSor';
               $base = 'transporte';

               $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

               $sql = 'select * from chofer';
               $ejec_sql = $conexion -> prepare($sql);
               $ejec_sql -> execute();

               while($fila = $ejec_sql -> fetch(PDO::FETCH_ASSOC)){
                 echo "<tr>";
                 foreach($fila as $campo){
                   echo "<td>";
                   echo $campo;
                   echo "</td>";
                 }
                 echo "</tr>";
               }
              ?>
           </table>
           <br><br>
           <a href="New_user.html">Agregar nuevo usuario</a>
         </div>
         <div class="col-md-2">
         </div>
       </div>
     </div>
  </body>
</html>
