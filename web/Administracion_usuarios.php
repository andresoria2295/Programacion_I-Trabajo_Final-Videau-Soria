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
         <div class="col-md-1">
           <br>
           <form class="" action="Administracion.php" method="POST">
             <button type="submit" class="btn btn-outline-info">Atrás</button>
           </form>
         </div>
         <div class="col-md-1">
         </div>
         <div class="col-md-8">
           <br>
           <?php
               echo "Administrador acreditado: {$_SESSION['usuario']}";
            ?>
           <br><br><br>
           <h4>Listado de usuarios registrados: </h4>
           <br>
           <table border="3">
             <?php
               $servidor = 'localhost';
               $usuario = 'root';
               $clave = '31081995AndSor';
               $base = 'transporte';

               $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

               $sql = 'select user_id, username, created, updated, rol  from users';
               $ejec_sql = $conexion -> prepare($sql);
               $ejec_sql -> execute();

              echo "<tr>";
                echo "<td>";
                echo "ID usuario";
                echo "</td>";
                echo "<td>";
                echo "Nombre de usuario";
                echo "</td>";
                echo "<td>";
                /*echo "Contraseña";
                echo "</td>";
                echo "<td>";*/
                echo "Fecha de creación";
                echo "</td>";
                echo "<td>";
                echo "Fecha de edición";
                echo "</td>";
                echo "<td>";
                echo "Rol";
                echo "</td>";
                echo "<td>";
                echo "";
                echo "</td>";
                echo "<td>";
                echo "";
                echo "</td>";
                echo "</tr>";
                while($fila = $ejec_sql -> fetch(PDO::FETCH_ASSOC)){
                 echo "<tr>";
                 foreach($fila as $campo){
                   echo "<td>";
                   //echo $campo;
                   if (($campo == "1") && ($fila["rol"] == "1")) {
                     echo "Administrador";
                   }else if ($campo == "0"){
                     echo "Usuario";
                   }else{
                     echo "$campo";
                   }
                   echo "</td>";
                 }
                 echo "<td>";
                 echo "<a href='Eliminacion_usuarios.php?user_id=".$fila['user_id']."'>Eliminar</a>";
                 //echo "<form class=\"delete_driver\" action=\"Eliminacion_usuarios.php\" method=\"POST\">";
                 //echo "<button type=\"submit\" name=\"chofer_id\" class=\"btn btn-danger\">Eliminar</button>";
                 //echo "</form>";
                 echo "</td>";
                 echo "<td>";
                 echo "<a href='Carga_usuario.php?user_id=".$fila['user_id']."'>Editar</a>";
                 //echo "<form class=\"update_driver\" action=\"Carga_usuario.php\" method=\"POST\">";
                 //echo "<button type=\"submit\" name=\"editado\" class=\"btn btn-success\">Editar</button>";
                 //echo "</form>";
                 echo "</td>";
                 echo "</tr>";
               }
              ?>
           </table>
           <br>
           <form class="create_driver" action="Nuevo_usuario.php" method="POST">
             <button type="submit" class="btn btn-outline-primary">Agregar nuevo usuario</button>
             <br>
           </form>
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
  </body>
</html>
