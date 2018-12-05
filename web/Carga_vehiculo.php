<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edición de registro vehículo</title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/forms_style.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
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
          <h2>Edición de registro vehículo</h2>
          <h5>Recompletar los siguientes campos</h5>
          <br><br>
          <form class="register" action="Edicion_vehiculos.php" method="POST">

          <?php
           $id = $_GET['vehiculo_id'];

           $servidor ='localhost';
           $usuario = 'root';
           $clave = '31081995AndSor';
           $base = 'transporte';

           $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

           $sql = "select * from vehiculo";
           $ejec_sql = $conexion -> prepare($sql);
           $ejec_sql -> execute();

           $registro = array("vehiculo_id" => $id);

           while($fila = $ejec_sql -> fetch(PDO::FETCH_ASSOC)){
             foreach($fila as $campo){
               if($fila['vehiculo_id'] == $id){
                 echo "<div class=\"form-row\">";
                   echo "<div class=\"form-group col-md-12\">";
                     echo "<label for=\"patente\">Dominio</label>";
                     echo "<input type=\"text\" class=\"form-control\" name=\"patente\" id=\"patente\" placeholder=\"Patente del vehículo\" value=\"$fila[patente]\">";
                   echo "</div>";
                 echo "</div>";
                 echo "<input type=\"hidden\" class=\"form-control\" name=\"vehiculo_id\" id=\"vehiculo_id\" value=\"$fila[vehiculo_id]\">"; //envio de user_id
                 echo "<div class=\"form-row\">";
                   echo "<div class=\"form-group col-md-6\">";
                     echo "<label for=\"patente_anio\">Año de dominio</label>";
                     echo "<input type=\"text\" class=\"form-control\" name=\"patente_anio\" id=\"patente_anio\" value=\"$fila[anho_patente]\">";
                   echo "</div>";
                   echo "<div class=\"form-group col-md-6\">";
                     echo "<label for=\"fabric_anio\">Año de fabricación</label>";
                    echo "<input type=\"text\" class=\"form-control\" name=\"fabric_anio\" id=\"fabric_anio\" value=\"$fila[anho_fabricacion]\">";
                   echo "</div>";
                 echo "</div>";
                 echo "<div class=\"form-row\">";
                   echo "<div class=\"form-group col-md-9\">";
                     echo "<label for=\"nombre_marca\">Marca</label>";
                     echo "<input type=\"text\" class=\"form-control\" name=\"nombre_marca\" id=\"nombre_marca\" value=\"$fila[marca]\">";
                   echo "</div>";
                   echo "<div class=\"form-group col-md-3\">";
                     echo "<label for=\"mod\">Modelo</label>";
                     echo "<input type=\"text\" class=\"form-control\" name=\"mod\" id=\"mod\" value=\"$fila[modelo]\">";
                   echo "</div>";
                 echo "</div>";
                 break;
               }
             }
           }
           /*
           echo "ID: ";
           echo "<input type=\"text\" name=\"driver_id\" value=\"$fila[chofer_id]\">";
           echo "<br><br>";
           echo "Nombre: ";
           echo "<input type=\"text\" name=\"name\" value=\"$fila[nombre]\">";
           echo "<br><br>";
           echo "Apellido: ";
           echo "<input type=\"text\" name=\"surname\" value=\"$fila[apellido]\">";
           echo "<br><br>";
           echo "Documento: ";
           echo "<input type=\"text\" name=\"dni\" value=\"$fila[documento]\">";
           echo "<br><br>";
           echo "Email: ";
           echo "<input type=\"text\" name=\"email\" value=\"$fila[email]\">";
           echo "<br><br>";
           */
          ?>
          <br>
          <button type="submit" class="btn btn-outline-primary">Aceptar</button>
        </form>
        <br><br>
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
  </form>
 </body>
</html>
