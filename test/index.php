<?php

include_once "../config/Database.php";
include_once "../objects/Auditoria.php";

$dbobj = new Database();
$db = $dbobj->getConnection();

$audit = new Auditoria($db);

$audit->exportAudit("2018-12-01", "2018-12-03");

