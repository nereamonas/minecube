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

  if(isset($_POST['save'])){
    if(isset($_POST['checkVolar'])){
      $volar=1;
    }else{
      $volar=0;
    }

    $stmt = $mysqli-> prepare("UPDATE Mapa SET modojuego=?,jugadores=?,spawnprotection=?,volar=? WHERE id=?");
    $stmt->bind_param("iiiis", $_POST['exampleRadios'], $_POST['jugadores'],$_POST['spawn'], $volar, $_GET["idServicio"]);
    $stmt->execute();

    #conseguir el estado y el puerto
       $stmtt = $mysqli-> prepare("SELECT puerto, estado FROM Mapa WHERE id=?");
       $stmtt->bind_param("s", $_GET['idServicio']);
       $stmtt->execute();
      
       $row = mysqli_fetch_assoc($stmtt->get_result());
       
       $puerto =$row['puerto'];
       $estado = $row['estado'];


    shell_exec('sudo bash static/scripts/editarServicio.sh '.$_POST['exampleRadios'].' '.$_POST['jugadores'].' '.$_POST['spawn'].' '.$volar.' '.$puerto.' '.$estado);

    die(header("location:editarServicio.php?idServicio=".$_GET['idServicio']."&editado=true"));
   
//NO VA LA REDIRECCION --> PHP Warning:  Cannot modify header information - headers already sent by (output started at /var/www/html/editarServicio.php:123) in /var/www/html/editarServicio.php on line 198, referer: http://localhost/editarServicio.php
  #$uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
  #$uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  #header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/misServicios.php");
  #exit();
  }

?>


<!DOCTYPE html>
<html lang="es" xmlns:th="http://www.thymeleaf.org">
<head>
    <title>Editar servicio</title>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="static/css/editarServicio.css" th:href="@{/css/editarServicio.css}">
    
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
                    <label for="editarServicio" class="form-label">Editar servicio</label>
        </div>
	
	<br>
	<div class="modal-dialog">
        <div class="col-sm-12 main-section">
            <div class="modal-content">
<?php
 // $consulta = "SELECT id, mapa, nombre, ip, estado, modojuego, jugadores, spawnprotection,volar FROM Mapa WHERE id=" . $_SESSION['idServicio'];
 // $resultado = $mysqli->query($consulta);
  $stmt = $mysqli-> prepare("SELECT modojuego, jugadores, spawnprotection,volar FROM Mapa WHERE id=?");
  $stmt->bind_param("s", $_GET["idServicio"]);
  $stmt->execute();
  $row = mysqli_fetch_assoc($stmt->get_result());
?>			
			
			<form class="form-horizontal" action="" method="post">
				<div class="form-group ">
					<label class="col-sm-12 control-label"><br>Modo de juego</label>
					<div class="col-sm-12">
						<div class="form-check">
							  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" <?php if($row['modojuego']==1){ echo "checked";}?>> <!-- el que salga que está en la base de datos se le pone el checked este -->
							  <label class="form-check-label" for="exampleRadios1">
							    Supervivencia
							  </label>
						</div>
						<div class="form-check">
							  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="2" <?php if($row['modojuego']==2){ echo "checked";}?>>
							  <label class="form-check-label" for="exampleRadios2">
							    Creativo
							  </label>
						</div>
						<div class="form-check">
							  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="3" <?php if($row['modojuego']==3){ echo "checked";}?>>
							  <label class="form-check-label" for="exampleRadios3">
							    Aventura
							  </label>
						</div>
						<div class="form-check">
							  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="4" <?php if($row['modojuego']==4){ echo "checked";}?>>
							  <label class="form-check-label" for="exampleRadios4">
							    Hardcore
							  </label>
						</div>
						
					</div>
				</div>
				<div class="form-group">
					<br>
					<label class="col-sm-12 control-label">Cantidad de jugadores</label>
              				<div class="col-sm-12">
					            <input type="range" class="slider" min="1" max="20" step="1" value="<?php echo $row['jugadores'];?>" id="range" name="jugadores"> <!-- el value=tall es el numero q este guardado en la base de datos -->
						    <div class=" text-center ">
							<span id="value"></span>
   				          </div>
				</div>
				<script>
					var slider = document.getElementById("range");
					var output = document.getElementById("value");
					output.innerHTML = slider.value;

					slider.oninput = function() {
					  output.innerHTML = this.value;
					}
			        </script>


				<div class="form-group">
					<br>
					<label class="col-sm-12 control-label">Spawn protection</label>
					  <div class="col-sm-12">
					            <input type="range" class="slider" min="0" max="16" step="1" value="<?php echo $row['spawnprotection'];?>" id="range2" name="spawn"> <!-- el value=tall es el numero q este guardado en la base de datos -->
						    <div class=" text-center ">
							<span id="value2"></span> </div>
   				          </div>
				</div>
				<script>
					var slider2 = document.getElementById("range2");
					var output2 = document.getElementById("value2");
					output2.innerHTML = slider2.value;

					slider2.oninput = function() {
					  output2.innerHTML = this.value;
					}
				</script>

				<div class="form-group">
					<label class="col-sm-12 control-label">Volar</label>
					<div class="col-sm-12">
						<div class="form-check form-check-inline">
							  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="checkVolar" <?php if($row['volar']==1){ echo "checked";}?> > <!-- lo mismo. si en la bd sale q esta en true, se pone ese checked. sino nada-->
							  <label class="form-check-label" for="inlineCheckbox1">Volar</label>
						</div>
					</div>
				</div>
			
				<div class="form-group text-center">
					<label class="col-sm-12 control-label">&nbsp;</label>
					<div class="col-sm-12">
						<input type="submit" onclick="abrirbotones()" name="save" class="btn btn-primary" value="Guardar cambios" action="misServicios.php">
						<a href="misServicios.php" class="btn btn-danger">Cancelar</a>
						
					</div>
<label class="column col-sm-12 control-label minititulos" id="creadoLabel" style="display:none" ><br>¡Editando servicio!<br></label>		

			</form>
<form>
   
    <?php if(isset($_GET["editado"])):?>
        <br><div class="alert alert-success text-center">Datos actualizados</div>
    <?php endif; ?>
</form>

		</div>

	</div></div></div></div>

<script>

	function abrirbotones() {
	  var creadoLabel = document.getElementById("creadoLabel");
	  creadoLabel.style.display = "block";
	} 
</script>



</main>          

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
          
</body>
</html>
