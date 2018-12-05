<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edición de sistema de transporte</title>
    <link href="bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/forms_style.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1">
          <br>
          <form class="" action="Registro_sist_transporte.php" method="POST">
            <button type="submit" class="btn btn-outline-info">Atrás</button>
          </form>
        </div>
        <div class="col-md-3">
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
          <h2>Edición de sistema de transporte</h2>
          <h5>Recompletar los siguientes campos</h5>
          <br><br>
          <form class="register" action="Edicion_sist_transporte.php" method="POST">

          <?php
           $id = $_GET['sistema_id'];

           $servidor ='localhost';
           $usuario = 'root';
           $clave = '31081995AndSor';
           $base = 'transporte';

           $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

           $sql = "select * from sistema_transporte";
           $ejec_sql = $conexion -> prepare($sql);
           $ejec_sql -> execute();

           $registro = array("sistema_id" => $id);

           while($fila = $ejec_sql -> fetch(PDO::FETCH_ASSOC)){
             foreach($fila as $campo){
               if($fila['sistema_id'] == $id){
                 echo "<div class=\"form-row\">";
                   echo "<div class=\"form-group col-md-12\">";
                     echo "<label for=\"name\">Nombre</label>";
                     echo "<input type=\"text\" class=\"form-control\" name=\"name\" id=\"name\" placeholder=\"Sistema de transporte\" value=\"$fila[nombre]\">";
                   echo "</div>";
                 echo "</div>";
                 echo "<input type=\"hidden\" class=\"form-control\" name=\"sistema_id\" id=\"sistema_id\" value=\"$fila[sistema_id]\">"; //envio de user_id
                 echo "<div class=\"form-row\">";
                   echo "<div class=\"form-group col-md-12\">";
                     echo "<label for=\"country\">País de procedencia</label>";
                     echo "<input type=\"text\" class=\"form-control\" name=\"country\" id=\"country\" value=\"$fila[pais_procedencia]\">";
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
