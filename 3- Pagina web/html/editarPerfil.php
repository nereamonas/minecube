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
    if(isset($_POST['save'])){
        #Mirar si existe el usuario
       $stmtt = $mysqli-> prepare("SELECT usuario FROM usuarios WHERE usuario=?;");
       $stmtt->bind_param("s", $_POST['usuario']);
       $stmtt->execute();
      
       $row = mysqli_fetch_assoc($stmtt->get_result());

	if(($_SESSION['erabiltzaile']==$row['usuario'])|| (""==$row['usuario'])){ # significa que ese usuario no está en uso y se puede modificar correctamente.
       	    if ($_POST['password']!="******"){
        	if ($_POST['password']==$_POST['password2']){
			  $stmt = $mysqli-> prepare("UPDATE usuarios SET usuario=?,email=?,pass=? WHERE usuario=?");
		    	  $hasPasahitza=hash('sha256',$_POST['password']);
		    	  $stmt->bind_param("ssss", $_POST['usuario'], $_POST['email'],$hasPasahitza, $_SESSION['erabiltzaile']);
		    	  $stmt->execute();

		          #$uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
	        	#$uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	        	$_SESSION['erabiltzaile']=$_POST['usuario']; 
      
	        	#header("Location: http://$uneko_zerbitzaria$uneko_karpeta/index.php"); 
                	die(header("location:editarPerfil.php?editado=true"));

		  }else{
		    #echo "Las contraseñas no son iguales";
                     #echo '<script language="javascript">alert("Las contraseñas no son iguales");</script>';
		    die(header("location:editarPerfil.php?passinvalid=true"));
		  }
	      }else{
	  	$stmt = $mysqli-> prepare("UPDATE usuarios SET usuario=?,email=? WHERE usuario=?");
    	  	$stmt->bind_param("sss", $_POST['usuario'], $_POST['email'], $_SESSION['erabiltzaile']);
    	  	$stmt->execute();
		#$uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
	        #$uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	        $_SESSION['erabiltzaile']=$_POST['usuario']; 
      
	        #header("Location: http://$uneko_zerbitzaria$uneko_karpeta/index.php"); 
                die(header("location:editarPerfil.php?editado=true"));
               }
        }else{
	     #echo "Ese usuario ya está en uso, elige otro"; 
	     #echo '<script language="javascript">alert("Ese usuario ya está en uso, elige otro");</script>'; 
             die(header("location:editarPerfil.php?usuarioenuso=true"));  
        }
      
     }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Editar perfil</title>
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
	<div class="col-12 text-center titulo">
                    <label for="crearcuenta" class="form-label">Editar perfil</label>
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
					<label class="col-sm-12 control-label"><br>Usuario</label>
					<div class="col-sm-12">
						<input type="text" name="usuario" id="usuario" value="<?php echo $row ['usuario']; ?>" class="form-control" placeholder="Usuario" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label">Email</label>
					<div class="col-sm-12">
						<input type="text" name="email" id="email" value="<?php echo $row ['email']; ?>" class="form-control" placeholder="Email" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label">Contraseña</label>
					<div class="col-sm-12">
						<input type="password" name="password" id="password" value="******" class="form-control" placeholder="Password" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label">Repite contraseña</label>
					<div class="col-sm-12">
						<input type="password" name="password2" id="password2" value="******" class="form-control" placeholder="Password2" required>
					</div>
				</div>
				
			
				<div class="form-group text-center">
					<label class="col-sm-12 control-label">&nbsp;</label>
					<div class="col-sm-12">
						<input type="submit" name="save" class="btn btn-primary" value="Guardar datos">
						<a href="index.php" class="btn btn-danger">Cancelar</a>
						
					</div>
				</div>

<form>
   
    <?php if(isset($_GET["usuarioenuso"])):?>
        <div class="alert alert-danger text-center">El usuario ya está en uso</div>
    <?php endif; ?>

    <?php if(isset($_GET["passinvalid"])):?>
        <div class="alert alert-danger text-center">Las contraseñas no coinciden</div>
    <?php endif; ?>

    <?php if(isset($_GET["editado"])):?>
        <div class="alert alert-success text-center">Datos actualizados</div>
    <?php endif; ?>
</form>
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

