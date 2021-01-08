<?php

$mysqli = new mysqli("127.0.0.1", "root", "test", "myDb", 6033); //no se cual es user y cual bd
if ($mysqli->connect_errno) {
  echo "Error al conectarse a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

?>
