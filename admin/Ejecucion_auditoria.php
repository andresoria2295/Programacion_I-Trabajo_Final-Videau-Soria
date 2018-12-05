<?php
  include_once "../config/Database.php";
  include_once "../objects/Auditoria.php";

  $database = new Database();
  $db = $database->getConnection();

  $audit = new Auditoria($db);

  $fecha_1 = $_POST["date_1"];
  $fecha_2 = $_POST["date_2"];

  //echo "$fecha_1";
  //echo "$fecha_2";

  $audit->exportAudit($fecha_1, $fecha_2);
  header('location: Auditoria_exportada.php');
 ?>
