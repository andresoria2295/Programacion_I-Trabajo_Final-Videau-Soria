<?php
// show error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
// set your default time-zone
date_default_timezone_set('America/Argentina/Mendoza');
// variables used for jwt
$key = "example_key"; // secret key used to encode and decode JWT
$iss = "http://example.org";// Token issuer
$aud = "http://example.com";// Token audience/receiver
$iat = 1356999524; // Tiempo en el cual el token fue creado
$nbf = 1357000000;// Tiempo antes de que se acepte el token
// el tiempo de nbf es menor al iat para evitar problemas de region
?>