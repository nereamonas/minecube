<?php
session_set_cookie_params (0, "/"); //nundik aurrera egon behar den kautotuta
session_start();

require_once("conexion_bd.php");

if (!isset($_SESSION['erabiltzaile'])){ //==null ES PARA QUE SI NO HAY SESION NO PUEDA ENTRAR
  $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
  $uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/index.php");
  exit(); 
} 


//select de estado

  //$idServ=$_GET['idServicio'];

  $stmt = $mysqli-> prepare("SELECT estado, puerto FROM Mapa WHERE id=?");
  $stmt->bind_param("s", $_GET['idServicio']);
  $stmt->execute();
  $row = mysqli_fetch_assoc($stmt->get_result());
  $puerto =$row['puerto'];
  $estado = $row['estado'];

  if($estado==1){
    $cambio=0;
  }else{
    $cambio=1;
  }

  $stmt = $mysqli-> prepare("UPDATE Mapa SET estado=? WHERE id=?");
  $stmt->bind_param("ii", $cambio, $_GET['idServicio']);
  $stmt->execute();

  if($cambio==0){
     echo shell_exec('sh static/scripts/stopServicio.sh '. $puerto); 
  }else{
     echo shell_exec('sh static/scripts/startServicio.sh '. $puerto); 
  }

  $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
  $uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/misServicios.php");

 ?>
