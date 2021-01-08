<?php

session_set_cookie_params (0, "/"); //nundik aurrera egon behar den kautotuta
session_start();

 

if (isset($_SESSION['erabiltzaile'])){ //!=null
  $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
  $uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/home.php");
  exit(); 
} 

require_once("conexion_bd.php");

if (isset($_POST['username'])&&isset($_POST['password'])){
  $erab=$_POST['username'];
  $hasPasahitza=hash('sha256',$_POST['password']);
  $stmt = $mysqli-> prepare("SELECT * FROM usuarios WHERE usuario=? AND pass=?"); 
  $stmt->bind_param("ss", $erab, $hasPasahitza);
  if (!$stmt->execute()) {
    echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
  }
  if (!($emaitza = $stmt->get_result())) { //para coger el valor porque stmt puede tener mas de uno
    echo "Falló la obtención del conjunto de resultados: (" . $stmt->errno . ") " . $stmt->error;
  }
  if($emaitza->num_rows==1){
    $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
    $uneko_karpeta = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
    $_SESSION['erabiltzaile']=$erab; 
    header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/home.php");
    exit(); 
  }else{
    die(header("location:index.php?loginFailed=true"));
  }
}

?>


<!DOCTYPE html>
<html lang="es" xmlns:th="http://www.thymeleaf.org">
<head>
    <title>Inicia sesión</title>

    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="static/css/login.css" th:href="@{/css/login.css}">

</head>
<body>
    <div class="modal-dialog text-center">
        <div class="col-sm-8 main-section">
            <div class="modal-content">
                <div class="col-12 user-img">
                    <img src="static/img/avatar.jpg" th:src="@{/img/avatar.jpg}"/>
                </div>
                <div class="col-12 text-center titulo">
                    <label for="iniciasesion" class="form-label">Inicia sesión</label>
                </div>
<!-- <form class="form-signin"  action="index.php" method="POST"> 
                <form class="col-12" th:action="@{/login}" method="get"> -->
                <form class="form-signin" action="index.php" method="post">
                    <div class="form-group" id="user-group">
                        <input type="text" class="form-control" placeholder="Nombre de usuario" name="username"required/>
                        <div class="invalid-feedback">
	                 Inserta un nombre de usuario
 	                </div>
                    </div>
                    <div class="form-group" id="contrasena-group">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password"required/>
                         <div class="invalid-feedback">
	                 Inserta una contraseña
 	                </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg" ><i class="fas fa-sign-in-alt"> </i> Entrar </button>
                </form>
                <div class="col-12 forgot" onclick="location.href='createAccount.php';">
                    <a href="#">Aún no tienes cuenta?<br></a>
                    <br>
                </div>
                
                <form>
   
    		<?php if(isset($_GET["loginFailed"])):?>
        		<div class="alert alert-danger">El usuario o contraseña no son correctos</div>
    		<?php endif; ?>
		</form>
        </div>
      </div>
   </div>
</body>
</html>

