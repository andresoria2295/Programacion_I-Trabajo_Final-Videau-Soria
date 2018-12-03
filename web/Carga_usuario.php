<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edición de registro</title>
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
            echo "Administrador acreditado: {$_SESSION['usuario']}";
           ?>
          <br><br><br>
          <h2>Edición de registro</h2>
          <h5>Recompletar los siguientes campos</h5>
          <br><br>
          <form class="register" action="Edicion_usuarios.php" method="POST">

          <?php
           $id = $_GET['user_id'];

           $servidor ='localhost';
           $usuario = 'root';
           $clave = '31081995AndSor';
           $base = 'transporte';

           $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

           $sql = "select * from usuario";
           $ejec_sql = $conexion -> prepare($sql);
           $ejec_sql -> execute();

           $registro = array("user_id" => $id);

           while($fila = $ejec_sql -> fetch(PDO::FETCH_ASSOC)){
             foreach($fila as $campo){
               if($fila['user_id'] == $id){
                 echo "<div class=\"form-group\">";
                   echo "<label for=\"usuario\">Nombre de usuario: </label>";
                   echo "<input type=\"text\" class=\"form-control\" name=\"usuario\" id=\"user\" aria-describedby=\"emailHelp\" value=\"$fila[username]\">";
                   echo "<small id=\"emailHelp\" class=\"form-text text-muted\"></small>";
                 echo "</div>";
                 echo "<div class=\"form-group\">";
                   echo "<label for=\"clave\">Contraseña: </label>";
                   echo "<input type=\"password\" class=\"form-control\" name=\"clave\" id=\"pass\" value=\"$fila[password]\">";
                   echo "<small id=\"passwordHelp\" class=\"form-text text-muted\">Requerimiento mínimo de 8 caracteres.</small>";
                 echo "</div>";
                 echo "<br>";
                 echo "<input type=\"hidden\" class=\"form-control\" name=\"usuario_id\" id=\"usuario_id\" aria-describedby=\"emailHelp\" value=\"$fila[user_id]\">"; //envio de user_id
                 if($fila["rol"] == "1"){
                   echo "<div class=\"form-row\">";
                     echo "<input class=\"form-check-input\" type=\"radio\" id=\"inlineFormCheck\" name=\"rol\" value=\"1\" checked>";
                     echo "<label class=\"form-check-label\" for=\"inlineFormCheck\">Administrador</label>";
                   echo "</div>";
                   echo "<div class=\"form-row\">";
                     echo "<input class=\"form-check-input\" type=\"radio\" id=\"inlineFormCheck\" name=\"rol\" value=\"0\">";
                     echo "<label class=\"form-check-label\" for=\"inlineFormCheck\">Usuario</label>";
                   echo "</div>";
                 }else{
                   echo "<div class=\"form-row\">";
                     echo "<input class=\"form-check-input\" type=\"radio\" id=\"inlineFormCheck\" name=\"rol\" value=\"1\">";
                     echo "<label class=\"form-check-label\" for=\"inlineFormCheck\">Administrador</label>";
                   echo "</div>";
                   echo "<div class=\"form-row\">";
                     echo "<input class=\"form-check-input\" type=\"radio\" id=\"inlineFormCheck\" name=\"rol\" value=\"0\" checked>";
                     echo "<label class=\"form-check-label\" for=\"inlineFormCheck\">Usuario</label>";
                   echo "</div>";
                 }
                 echo "<br>";
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
          <button type="submit" class="btn btn-outline-primary">Aceptar</button>
        </form>
        <br><br>
      </div>
      <div class="col-md-1">
      </div>
      <div class="col-md-1">
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
