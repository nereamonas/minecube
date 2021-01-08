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
//////////////////////////////////////hasta aqui tienen que tener todas para las que tengas que estar kautotuado
 
  if(isset($_GET['lanzar'])){
      $stmt = $mysqli-> prepare("SELECT id FROM usuarios WHERE usuario=?");
      $stmt->bind_param("s", $_SESSION['erabiltzaile']);
      $stmt->execute();
      $id = mysqli_fetch_assoc($stmt->get_result())['id'];


      #coger puerto
      $stmt = $mysqli-> prepare("SELECT MAX(puerto) as puerto FROM Mapa");
      $stmt->execute();
      $puerto = mysqli_fetch_assoc($stmt->get_result())['puerto'];
      $puerto = $puerto + 1;




      $stmt2 = $mysqli-> prepare("INSERT INTO Mapa (nombreMapa,puerto,estado,modojuego,jugadores,spawnprotection,volar,idusuario) VALUES(?,?,?,?,?,?,?,?)");
$nombreMapa=$_GET['nombre'];
$estado=0;
$modojuego=1;
$jugadores=10;
$spawnprotection=0;
$volar=0;
      $stmt2->bind_param("siiiiiii", $nombreMapa, $puerto, $estado, $modojuego, $jugadores, $spawnprotection, $volar, $id);
      $stmt2->execute();

    #ejecutar el script de lanzamiento
    shell_exec('sh static/scripts/lanzarServicio.sh '. $puerto); # el numero ese es el port asignado

    die(header("location:crearServicio.php?creado=true"));
    }



  if(isset($_POST['crear'])){
    if($_POST['nombre']!=""){
      die(header("location:crearServicio.php?lanzar=true&nombre=".$_POST['nombre']));  # lanzamos. creando servicio

    #exit(); 
    }else{
      die(header("location:crearServicio.php?sinnombre=true"));  # no existe el nombre

    }

    }
?>


<!DOCTYPE html>
<html lang="es" xmlns:th="http://www.thymeleaf.org">
<head>
    <title>Crear Servicio</title>

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
	<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
	<br>
	<div class="col-12 text-center titulo ">
                    <label for="crearServicio" class="form-label">Creando nuevo servicio</label>
        </div>


<br>
	<div class="modal-dialog">
        <div class="col-sm-12 main-section">
            <div class="modal-content">
			
			
			<form class="form-horizontal"  method="post">
			
						
		<!--USUARIO-->

		<div class="form-group row" >
			<label class="column col-sm-12 control-label minititulos"><br>Nombre<br></label>

			<div class="column col-sm-12" >
				
				<input id="nuevoNombre" type="text" name="nombre" class="form-control" placeholder="Nombre">

			</div>

		</div>


		<div class="text-center">
			<input type="submit" onclick="abrirbotones()" name="crear" value="Crear" class="btn btn-primary">
			<a href="misServicios.php" class="btn btn-danger">Cancelar</a><br>
			<br>
			</div>

                <div class="text-center">


<label class="column col-sm-12 control-label minititulos" style="display:none" id="creadoLabel">¡Creando nuevo servicio!<br></label></div>


	
		</form>
		<br>
<form>
    <?php if(isset($_GET["sinnombre"])):?>
        <div class="alert alert-danger text-center">Tienes que escribir un nombre</div>
    <?php endif; ?>
    <?php if(isset($_GET["lanzar"])):?>
        <div class="alert alert-warning text-center">Creando servicio</div>
    <?php endif; ?> 
    <?php if(isset($_GET["creado"])):?>
        <div class="alert alert-success text-center">Servicio creado</div>
    <?php endif; ?>
</form>
		</div>
			
	</div></div></div></div>

<script> 
        function abrirbotones() {
          var creadoLabel = document.getElementById("creadoLabel");
          var nuevoNombre = document.getElementById("nuevoNombre");
          creadoLabel.style.display = "block";
}            
</script>

</main>          

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
          
</body>
</html>
