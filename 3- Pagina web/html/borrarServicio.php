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

if (isset($_GET['idServicio'])&&isset($_SESSION['erabiltzaile'])){
  $stmt = $mysqli-> prepare("select * from Mapa inner join usuarios on Mapa.id=? and Mapa.idusuario=usuarios.id and usuarios.usuario=?;"); 
  $stmt->bind_param("is", $_GET['idServicio'], $_SESSION['erabiltzaile']);
  if (!$stmt->execute()) {
    echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
  }
  if (!($emaitza = $stmt->get_result())) { //para coger el valor porque stmt puede tener mas de uno
    echo "Falló la obtención del conjunto de resultados: (" . $stmt->errno . ") " . $stmt->error;
  }
  if($emaitza->num_rows==0){
    //no es su mapa, asiq no debe dejar entrar
    $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
    $uneko_karpeta = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
    header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/misServicios.php");
    echo "MAL";
  }else{
     echo "TODO BN";
  }
}


 
//////////////////////////////////////hasta aqui tienen que tener todas para las que tengas que estar kautotuado
?>


<!DOCTYPE html>
<html lang="es" xmlns:th="http://www.thymeleaf.org">
<head>
    <title>Borrar servicio</title>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="static/css/general.css" th:href="@{/css/general.css}">
    
    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


</head>
<body>
    
    
<header>

  <!-- Navbar
  ================================================== -->

  <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
              <img src="static/img/avatar.jpg" width="38" height="30" class="d-inline-block align-top" alt="Bootstrap" loading="lazy">
            </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item active">
            <a class="nav-link" aria-current="page" href="home.php">Home</a>
          </li>
	  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#Servicios" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Servicios
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="misServicios.php">Mis Servicios</a>
              <a class="dropdown-item" href="crearServicio.php">Crear Servicio</a>
            </div>
          </li>
	  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#Perfil" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Perfil
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="verPerfil.php">Mi perfil</a>
              <a class="dropdown-item" href="editarPerfil.php">Editar perfil</a>
            </div>
          </li>
	  <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar sesión</a>
          </li>
        </ul>
        
      </div>
    </div>
  </nav>
</header>

<main>
	<br>
	<div class="col-12 text-center">
                <div class="titulo">
                    <label for="borrarServicio" class="form-label">Borrar servicio</label>
		</div>
		<div class="cuerpo">
			<label for="borrarServicio" class="form-label">Estas seguro que quieres borrar el servicio?</label>
		</div>
<!--		<a type="button"  onclick="eliminar()" class="btn btn-primary">Eliminar</a>

		<a type="button" onclick="cancelar()" class="btn btn-danger">Cancelar</a> -->
<form  method="post">
    <input type="submit" name="eliminar" value="Eliminar" class="btn btn-primary">
    <input type="submit" name="cancelar" value="Cancelar" class="btn btn-danger">
</form>
        </div>

<?php

  if (isset($_POST['cancelar'])){
    $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
    $uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/misServicios.php");
    exit(); 
  }
  if (isset($_POST['eliminar'])){
    #cogemos el puerto y el estado
    $stmt = $mysqli-> prepare("SELECT puerto FROM Mapa WHERE id=?");
    $stmt->bind_param("s", $_GET['idServicio']);
    $stmt->execute();
    $row = mysqli_fetch_assoc($stmt->get_result());
    $puerto =$row['puerto'];

    #lo eliminamos
    $mysqli->query("DELETE FROM Mapa WHERE id=".$_GET["idServicio"]);

    #eliminamos el docker
    echo shell_exec('sh static/scripts/eliminarServicio.sh '. $puerto); 
    $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
    $uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/misServicios.php");
    exit(); 
  }

?>

  
</main>          


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
          
</body>

</html>
