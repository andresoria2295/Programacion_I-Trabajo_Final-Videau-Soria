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
        <div class="col-md-1">
          <br>
          <form class="" action="Registro_choferes.php" method="POST">
            <button type="submit" class="btn btn-outline-info">Atrás</button>
          </form>
        </div>
        <div class="col-md-2">
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

           $conexion = new PDO("mysql: host=".$servidor."; dbname=".$base, $usuario, $clave);
              
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
                  echo "<input type=\"hidden\" class=\"form-control\" name=\"chofer_id\" id=\"chofer_id\" value=\"$fila[chofer_id]\">"; //envio de user_id
                
                  echo "<div class=\"form-row\">";
                   echo "<div class=\"form-group col-md-10\">";
                     echo "<label for=\"system_id\">Medio de transporte</label>";
                    
                    echo "<input type=\"text\" class=\"form-control\" name=\"system_id\" id=\"system_id\" value=\"$fila[sistema_id]\">";
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
          ?>
          <button type="submit" class="btn btn-outline-primary">Aceptar</button>
        </form>
        <br><br>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-1">
        <form class="quit" action="Login.html" method="POST">
          <button type="submit" class="btn btn-outline-secondary">Salir</button>
        </form>
      </div>
     </div>
   </div>
  </form>
 </body>
</html>
