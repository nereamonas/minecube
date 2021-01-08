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
?>


<!DOCTYPE html>
<html lang="es" xmlns:th="http://www.thymeleaf.org">
<head>
    <title>Mis servicios</title>

    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="static/css/misServicios.css" th:href="@{/css/misServicios.css}">
<style>
body{
    background: url(static/img/fondoCubosBlancos.jpeg) no-repeat center center fixed;
    background-size: cover;
}
.btn {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 8px 12px;
  font-size: 12px;
  cursor: pointer;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}


</style>


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
                    <label for="crearcuenta" class="form-label">Mis servicios</label>
        </div>



	<div class="container">
                <div class="row"  style="margin-top: 50px;">
                <div class="col-md-12 text-center">
                          <div class="outer-form">
                    <table id="miTabla" class="table table-striped">
                          <thead style="color: black; font-weight: bold; background-color: white; " >
                            <tr>
                              <th  class="head">Estado</th>
                              <th  class="head">Id</th>
                              <th  class="head">Nombre Mapa</th>
                              <th  class="head">Puerto</th>
			      <th  class="head">Modo de juego</th>
			      <th  class="head">Jugadores</th>
			      <th  class="head">Spaw protection</th>
			      <th  class="head">Volar </th>
                              <th  class="head">Configuración</th>
                            </tr>
                          </thead>

                          <tbody style="border:1px solid transparent; background-color:#ffffff; color:#A1A6AB; text-align: center;">
                            
<?php
//CONSULTA conseguir id
  $stmt = $mysqli-> prepare("SELECT id FROM usuarios WHERE usuario=?");
  $stmt->bind_param("s", $_SESSION['erabiltzaile']);
  $stmt->execute();
  $id = mysqli_fetch_assoc($stmt->get_result())['id'];

  $consulta = "SELECT id, nombreMapa, puerto, estado, modojuego, jugadores, spawnprotection,volar FROM Mapa WHERE idusuario=" . $id;
  $resultado = $mysqli->query($consulta);
  
  while ($row = $resultado->fetch_assoc()) {
//while ($row = mysqli_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>";

    echo "<label class='switch'>";
    echo "<input type='checkbox' name='checkEstado' onChange='cambiarEstado(this);'";
      if($row['estado']==1){ echo "checked";}
    echo ">  <!-- Estado. checked si queremos q este activo-->";
    echo "<span class='slider round'></span>";
    echo "</label>";

    echo "</td>";
    echo "<td style='padding: 14px;'>" . $row['id'] . "</td> <!-- Id -->";
    echo "<td>" . $row['nombreMapa'] . "</td>  <!-- Nombre -->";
    echo "<td>" . $row['puerto'] . "</td>   <!-- IP -->";
    if($row['modojuego']==1){
	echo "<td> Supervivencia </td>   <!-- Modo de juego-->";
    }elseif($row['modojuego']==2){
	echo "<td> Creativo </td>   <!-- Modo de juego-->";
    }elseif($row['modojuego']==3){
	echo "<td> Aventura </td>   <!-- Modo de juego-->";
    }elseif($row['modojuego']==4){
	echo "<td> Hardcore </td>   <!-- Modo de juego-->";
    }
    #echo "<td>" . $row['modojuego'] . "</td>   <!-- Modo de juego-->";
    echo "<td>" . $row['jugadores'] . "</td>   <!-- Jugadores-->";
    echo "<td>" . $row['spawnprotection'] . "</td>   <!-- Spawn protection-->";
    echo "<td>   <!-- Volar-->";
?>
<input type="checkbox" class="select-all checkbox" name="select-all" id="check" <?php if($row['volar']==1){ echo "checked";} ?> disabled/>  <!-- si en la bd esta true se pone checked sino nada -->
			      </td>  
                              <td>    <!-- botones de editar y borrar  onclick="location.href='editarServicio.php';<? $_SESSION['idServicio']=$row['id'] ?>"-->

                                <button class="btn" type="submit" name="editar" onclick="editar(this);" style="BORDER: rgb(59,131,189) 1px dashed; BACKGROUND-COLOR: rgb(59,131,189)" value="Editar"><i class="fa fa-edit"></i></button>

				<button class="btn" type="submit" name="borrar" onclick="eliminar(this)" style="BORDER: rgb(250,0,0) 1px dashed; BACKGROUND-COLOR: rgb(250,0,0)" value="Eliminar"><i class="fa fa-trash"></i></button>

    </td>
<?php
  }
?>              
                            </tr>
<script>

//document.querySelector('#miTabla').onclick = function(ev) {
   // ev.target <== td element
   // ev.target.parentElement <== tr
//   var index = ev.target.parentElement.rowIndex;
//   alert(index);
//}

function editar(ele){
  var id = cogerId(ele);
  window.location.href='editarServicio.php?idServicio='+id;
}

function eliminar(ele){
  var id = cogerId(ele);
  window.location.href='borrarServicio.php?idServicio='+id;
}

function cogerId(ele){
var table = document.getElementById('miTabla');
var row = ele.closest('tr');
return table.rows[row.rowIndex].cells[1].innerHTML;
}

function cambiarEstado(ele){
  var id = cogerId(ele);
  window.location.href='cambiarEstado.php?idServicio='+id;

}

</script>


                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
		<br>
	      <button class="btn btn-primary" onclick="location.href='crearServicio.php';" style="font-size: 15px;" type="submit">Crear un nuevo servicio</button>
          </div>

  


  
</main>          
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
          
</body>
</html>
