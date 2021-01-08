<?php
session_set_cookie_params (0, "/"); //nundik aurrera egon behar den kautotuta
session_start();
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
    <title>Home</title>

    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

    </style>
<style>
body{
    background: url(static/img/fondoCubosBlancos.jpeg) no-repeat center center fixed;
    background-size: cover;
}
* {
  box-sizing: border-box;
}

/* Create four equal columns that floats next to each other */
.column {
  float: left;
  width: 25%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
  text-align: center;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>

    
    <!-- Custom styles for this template -->
    <link href="static/css/home.css" rel="stylesheet">
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
<!-- Carrusel
  ================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
       <img src="static/img/uno.jpeg" th:src="@{/img/uno.jpeg}"/>

        <div class="container">
          <div class="carousel-caption text-start">
            <h1 style="color:black" align="right">BIENVENID@ A MINECUBE</h1><br>
            <p style="max-width:500px;color:black;margin-left: 50%;" align="right">Aquí podrás crear tantos servidores del juego Minecraft como desees. ¡Empieza a jugar a uno de los juegos mas famosos del mundo!</p><br>
            <p><a class="btn btn-lg btn-primary" style="margin-left: 84%;" align="right" href="misServicios.php" role="button">Ver servicios</a><br></p>
          </div>
        </div>
    </div>
    <div class="carousel-item" style="background-color:white;">>
      <img src="static/img/dos.png" th:src="@{/img/dos.png}"/>

        <div class="container">
          <div class="carousel-caption">
            <h1 style="color:black">Contrata un nuevo servicio </h1><br>
            <p style="max-width:500px;color:black;margin-left: 23%;" align="center">Quieres contratar un nuevo servicio? No lo dudes, aquí te damos la oportunidad de crear todos los servicio que quieras.</p><br>
            <p><a class="btn btn-lg btn-primary" href="crearServicio.php" role="button">Nuevo servicio<br></a><br></p><br>
          </div>
        </div>
    </div>
    <div class="carousel-item">
      <img src="static/img/tres.png" th:src="@{/img/tres.png}"/>
      <div class="container">
          <div class="carousel-caption text-end te">
            <h1 style="color:black;margin-left: 10%;" align="left"> Accede a tus servicios<br></h1><br>
            <p class="text-center col-sm-6 " style="color:black;margin-left: 8%;">Te damos la oportunidad de manejar, crear, editar y borrar tantos servicios minecraft como desees.</p><br>
            <p><a class="btn btn-lg btn-primary" style="max-width:500px;margin-left: -64%;" align="left" href="misServicios.php" role="button">Mis servicios</a><br><br><br></p>
          </div>
        </div>
      </div>
    </div>
  <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <!--<span class="visually-hidden">Previous</span>-->
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <!--<span class="visually-hidden">Next</span> -->
  </a>
</div>



  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">
    <h2 class="featurette-heading text-center">Modos de juego </h2>
    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="column">
        <img class="bd-placeholder-img rounded-circle" width="140" height="140" aria-label="Placeholder: 140x140" src="static/img/supervivencia.png" th:src="@{/img/supervivencia.png}"/>       
        <h2>Supervivencia</h2>
        <p>Consiste en obtener recursos del mundo para así poder sobrevivir en este. El jugador debe obtener los materiales necesarios para fabricar otros bloques, herramientas, armas, decoración, y cosas que lo ayuden a progresar en su partida.</p>
        
      </div><!-- /.col-lg-4 -->
      <div class="column">
        <img class="bd-placeholder-img rounded-circle" width="140" height="140" aria-label="Placeholder: 140x140" src="static/img/creativo.png" th:src="@{/img/creativo.png}"/>       
        <h2>Creativo</h2>
        <p>Permite tener recursos infinitos en el mundo y volar libremente. El jugador no puede recibir daño ni morir, salvo caiga al vacío, ni posee barras de hambre, armadura, experiencia, salud o aire. Además, puede romper bloques instantáneamente.</p>
        
      </div><!-- /.col-lg-4 -->
      <div class="column">
	<img class="bd-placeholder-img rounded-circle" width="140" height="140" aria-label="Placeholder: 140x140" src="static/img/aventura.png" th:src="@{/img/aventura.png}"/>     
        <h2>Aventura</h2>
        <p>Es muy parecido al modo supervivencia, pues posee casi todos los detalles de esta. Sin embargo, se pueden notar diferencias notorias respecto al modo supervivencia. </p>
        
      </div><!-- /.col-lg-4 -->
      <div class="column">
       <img class="bd-placeholder-img rounded-circle" width="140" height="140" aria-label="Placeholder: 140x140" src="static/img/hardcore.png" th:src="@{/img/hardcore.png}"/>       
        <h2>Hardcore</h2>
        <p>Parecido al modo supervivencia. Pero, el jugador solo tiene una vida, por lo que si muere ya no puede reaparecer, pudiendo solo espectar el mundo o elegir irse de él, y la dificultad está bloqueada a extremo. </p>
     
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Volar </h2>
        <p class="lead">El volar es una mecánica exclusiva de los modos creativo y espectador, pero te damos la opción de cambiar los permisos facilmente para poder volar en el resto de modos de juego. Esta habilidad le permite a los jugadores transportarse de un lugar a otro sin tener que tocar el suelo. </p>
      </div>
      <div class="col-md-5">
        <img width="500" height="300" aria-label="Placeholder: 500x300" src="static/img/volar.png" th:src="@{/img/volar.png}"/>

      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Jugadores</h2>
        <p class="lead">Vive aventuras con un total de hasta 20 jugadores.</p>
      </div>
      <div class="col-md-5 order-md-1">
         <img width="480" height="280" aria-label="Placeholder: 480x280" src="static/img/jugadores.jpeg" th:src="@{/img/jugadores.jpeg}"/>

      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Spawn protection</h2>
        <p class="lead">Si quieres determinar el radio de la protección de aparición, tendrás la oportunidad de establecerlo a tu antojo. Podrás darle un valor entre 0 y 16, donde 0 significa que no tendrá proteccion, tan solo protegerá el bloque sobre el que aparecemos. El 1 protegerá una zona de 3x3, manteniendo el centro sobre el punto en el que aparecemos. El 2 lo hará en una zona de 5x5, el 3 de 7x7, etc.</p>
      </div>
      <div class="col-md-5">
        <img width="500" height="400" aria-label="Placeholder: 500x400" src="static/img/spawn.png" th:src="@{/img/spawn.png}"/>

      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->


  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; 2020-2021 Company, Inc. Minecube &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
</main>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

      
  </body>
</html>
