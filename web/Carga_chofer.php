<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edición de registro chofer</title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/forms_style.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
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
          <h2>Edición de registro chofer</h2>
          <h5>Recompletar los siguientes campos</h5>
          <br><br>
          <form class="register" action="Edicion_choferes.php" method="POST">

          <?php
           $id = $_GET['chofer_id'];

           $servidor ='localhost';
           $usuario = 'root';
           $clave = '31081995AndSor';
           $base = 'transporte';

           $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

           $sql = "select * from chofer";
           $ejec_sql = $conexion -> prepare($sql);
           $ejec_sql -> execute();

           $registro = array("chofer_id" => $id);

           while($fila = $ejec_sql -> fetch(PDO::FETCH_ASSOC)){
             foreach($fila as $campo){
               if($fila['chofer_id'] == $id){

                echo "<div class=\"form-row\">";
                  echo "<div class=\"form-group col-md-6\">";
                    echo "<label for=\"name\">Nombre</label>";
                    echo "<input type=\"text\" class=\"form-control\" name=\"name\" id= \"name\" value=\"$fila[nombre]\">";
                  echo "</div>";
                  echo "<div class=\"form-group col-md-6\">";
                    echo "<label for=\"surname\">Apellido</label>";
                    echo "<input type=\"text\" class=\"form-control\" name=\"surname\" id=\"surname\" value=\"$fila[apellido]\">";
                  echo "</div>";
                echo "</div>";
                echo "<div class=\"form-row\">";
                  echo "<div class=\"form-group col-md-3\">";
                    echo "<label for=\"dni\">Documento</label>";
                    echo "<input type=\"text\" class=\"form-control\" name=\"dni\" id=\"dni\" value=\"$fila[documento]\">";
                  echo "</div>";
                  echo "<div class=\"form-group col-md-9\">";
                    echo "<label for=\"email\">Email</label>";
                    echo "<input type=\"text\" class=\"form-control\" name=\"email\" id=\"email\" value=\"$fila[email]\">";
                  echo "</div>";
                 echo "</div>";
                  echo "<input type=\"hidden\" class=\"form-control\" name=\"usuario_id\" id=\"usuario_id\" aria-describedby=\"emailHelp\" value=\"$fila[user_id]\">"; //envio de user_id
                 echo "<div class=\"form-row\">";
                   echo "<div class=\"form-group col-md-10\">";
                     echo "<label for=\"system_id\">Medio de transporte</label>";
                     echo "<select id=\"transp\" name=\"system_id\" class=\"form-control\">";
                       echo "<option selected=\"selected\" value=\"$fila[sistema_id]\">$fila[sistema_id]</option>";
                       echo "<option value=\"1\">100</option>";
                       echo "<option value=\"2\">101</option>";
                       echo "<option value=\"3\">102</option>";
                       echo "<option value=\"4\">104</option>";
                     echo "</select>";
                   echo "</div>";
                   echo "<div class=\"form-group col-md-2\">";
                     echo "<label for=\"vehicle_id\">Vehículo</label>";
                     echo "<input type=\"text\" class=\"form-control\" name=\"vehicle_id\" id=\"vehicle_id\" placeholder=\"unidad\" value=\"$fila[vehiculo_id]\">";
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
          <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Aceptar</button>
        </form>
        <br><br>
      </div>
      <div class="col-md-3">
      </div>
     </div>
   </div>
  </form>
 </body>
</html>
