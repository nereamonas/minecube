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
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ver perfil</title>

    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    
    <!-- Custom styles for this template -->
    <link href="static/css/editarPerfil.css" rel="stylesheet">
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
	<div class="col-12 text-center titulo">
                    <label for="crearcuenta" class="form-label">Ver perfil</label>
        </div>
	<br>
	<div class="modal-dialog">
        <div class="col-sm-12 main-section">
            <div class="modal-content">
			
<?php
 $stmtt = $mysqli-> prepare("SELECT * FROM usuarios WHERE usuario=?");
       $stmtt->bind_param("s", $_SESSION['erabiltzaile']);
       $stmtt->execute();
      
       $row = mysqli_fetch_assoc($stmtt->get_result());
       
?>			
			<form class="form-horizontal" action="" method="post">
				<div class="form-group ">
					<label class="col-sm-3 control-label" style="font-weight:bold"><br>Usuario: </label>
					<label class="col-sm-8 control-label " ><?php echo $row ['usuario']; ?></label>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" style="font-weight:bold">Email: </label>
					<label class="col-sm-8 control-label " ><?php echo $row ['email']; ?></label>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" style="font-weight:bold">Contraseña: </label>
					<label class="col-sm-8 control-label " >******</label>
				</div>
			
				
			
				<div class="form-group text-center">
					<label class="col-sm-12 control-label">&nbsp;</label>
					<div class="col-sm-12">
						<a href="editarPerfil.php" class="btn btn-primary">Editar perfil</a>
						
					</div>
				</div>

				<br>
			</form>
			<br>
		</div>
	</div></div></div></div>

</main>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

      
  </body>
</html>



