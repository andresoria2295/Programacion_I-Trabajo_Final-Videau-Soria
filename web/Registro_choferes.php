<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      Registro de choferes
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
         </div>
         <div class="col-md-10">
           <br>
           <?php
               echo "Usuario acreditado: {$_SESSION['usuario']}";
            ?>
           <br><br><br>
           <h4>Listado de choferes registrados: </h4>
           <br>
           <table border="3">
             <?php
               $servidor = 'localhost';
               $usuario = 'root';
               $clave = '31081995AndSor';
               $base = 'transporte';

               $conexion = new PDO("mysql: host=$servidor; dbname=$base", $usuario, $clave);

               //$sql = 'select a.chofer_id, a.apellido, a.nombre as nombre_persona, a.documento, a.email, a.vehiculo_id, b.nombre as nombre_sistema, a.created, b.updated from chofer a left join sistema_transporte b on a.sistema_id = b.sistema_id';
               $sql = 'select chofer.chofer_id, chofer.apellido, chofer.nombre as nombre_chofer, chofer.documento, chofer.email, vehiculo.patente, sistema_transporte.nombre as nombre_sistema_transporte, chofer.created, chofer.updated FROM transporte.chofer LEFT JOIN vehiculo ON chofer.vehiculo_id = vehiculo.vehiculo_id LEFT JOIN sistema_transporte ON chofer.sistema_id = sistema_transporte.sistema_id ORDER BY apellido ASC';
               $ejec_sql = $conexion -> prepare($sql);
               $ejec_sql -> execute();

              echo "<tr>";
                echo "<td>";
                echo "ID chofer";
                echo "</td>";
                echo "<td>";
                echo "Apellido";
                echo "</td>";
                echo "<td>";
                echo "Nombre";
                echo "</td>";
                echo "<td>";
                echo "Documento";
                echo "</td>";
                echo "<td>";
                echo "Email";
                echo "</td>";
                echo "<td>";
                echo "Vehiculo";
                echo "</td>";
                echo "<td>";
                echo "Empresa";
                echo "</td>";
                echo "<td>";
                echo "Fecha de creación";
                echo "</td>";
                echo "<td>";
                echo "Fecha de edición";
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
                   echo $campo;
                   echo "</td>";
                 }
                 echo "<td>";
                 echo "<a href='Eliminacion_choferes.php?chofer_id=".$fila['chofer_id']."'>Eliminar</a>";
                 //echo "<form class=\"delete_driver\" action=\"Eliminacion_usuarios.php\" method=\"POST\">";
                 //echo "<button type=\"submit\" name=\"chofer_id\" class=\"btn btn-danger\">Eliminar</button>";
                 //echo "</form>";
                 echo "</td>";
                 echo "<td>";
                 echo "<a href='Carga_chofer.php?chofer_id=".$fila['chofer_id']."'>Editar</a>";
                 //echo "<form class=\"update_driver\" action=\"Carga_usuario.php\" method=\"POST\">";
                 //echo "<button type=\"submit\" name=\"editado\" class=\"btn btn-success\">Editar</button>";
                 //echo "</form>";
                 echo "</td>";
                 echo "</tr>";
               }
              ?>
           </table>
           <br>
           <form class="create_driver" action="Nuevo_chofer.php" method="POST">
             <button type="submit" class="btn btn-outline-primary">Agregar nuevo chofer</button>
             <br>
           </form>
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
