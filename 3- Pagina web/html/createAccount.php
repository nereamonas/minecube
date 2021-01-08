<?php

session_set_cookie_params (0, "/"); //nundik aurrera egon behar den kautotuta
session_start();

require_once("conexion_bd.php");

if (isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password2'])&&isset($_POST['email'])){
  $erab=$_POST['username'];
  $stmt = $mysqli-> prepare("SELECT * FROM usuarios WHERE usuario=?");
  $stmt->bind_param("s", $erab);
  if (!$stmt->execute()) {
    echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
  }
  if (!($emaitza = $stmt->get_result())) { //para coger el valor porque stmt puede tener mas de uno
    echo "Falló la obtención del conjunto de resultados: (" . $stmt->errno . ") " . $stmt->error;
  }
  if($emaitza->num_rows==0){ 
    if ($_POST['password']==$_POST['password2']){
      $hasPasahitza=hash('sha256',$_POST['password']);
      $stmt = $mysqli-> prepare("INSERT INTO usuarios (usuario, email, pass) VALUES(?,?,?)");
      $stmt->bind_param("sss", $_POST['username'], $_POST['email'], $hasPasahitza);
      $stmt->execute();


      $uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
      $uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $_SESSION['erabiltzaile']=$erab; 
      header ("Location: http://$uneko_zerbitzaria$uneko_karpeta/home.php");
      exit();
    }else{  # las contraseñas no son iguales
      die(header("location:createAccount.php?passinvalid=true"));
    }
  }else{   # el usuario ya está en uso
    die(header("location:createAccount.php?usuarioenuso=true"));
  }
}
?>




<!doctype html>
<html lang="es">
<head>
    <title>Crear Cuenta</title>

    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="static/css/createAccount.css" th:href="@{/css/login.css}">

</head>
<body>
    
    <div class="modal-dialog">
        <div class="col-sm-12 main-section">
            <div class="modal-content">
                <div class="col-12 text-center user-img">
                    <img src="static/img/avatar.jpg" th:src="@{/img/avatar.jpg}"/>
                </div>
                <div class="col-12 text-center titulo">
                    <label for="crearcuenta" class="form-label">Crear cuenta</label>
                </div>
<!-- <form class="form-signin" action="index.php" method="post">
                <form class="col-12" th:action="@{/login}" method="get"> -->
                <form class="form-signin" action="createAccount.php" method="post">
                    <div class="form-group">
       	       <label for="username" class="form-label">Nombre de usuario:</label>
       	       <div class="form-group" id="usuario">
	               <input type="text" class="form-control" id="username" placeholder="Usuario" name="username" required></div>
        	       <div class="invalid-feedback">
	                  El nombre de usuario es obligatorio.
	                </div>
	              
	            </div>
	
	            <div class="form-group">
	              <label for="email" class="form-label">Correo electronico:</label>
	              <div class="form-group" id="email">
	               <input type="email" class="form-control" id="email" placeholder="yo@ejemplo.com" name="email" required></div>
	              <div class="invalid-feedback">
	                Por favor, inserta un email valido.
 	             </div>
	            </div>

 	           <div class="form-group">
	              <label for="password" class="form-label">Contraseña:</label>
	              <div class="form-group" id="contrasena">
	              <input type="password" class="form-control" id="password" placeholder="********" name="password" required></div>
	              <div class="invalid-feedback">
	                Por favor, ingresa una contraseña.
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="password2" class="form-label">Repite la contraseña:</label>
	              <div class="form-group" id="contrasena">
	              <input type="password" class="form-control" id="password" placeholder="********" name="password2" required></div>
	              <div class="invalid-feedback">
	                Por favor, ingresa una contraseña.
	              </div>
	              <br>
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Registrarse</button>
                    
                    <div class="col-12 text-center iniciasesion" onclick="location.href='index.php';">
                       <a href="#">Ya tienes cuenta?<br></a>
                       <br>
                    </div>
<form>
   
    <?php if(isset($_GET["usuarioenuso"])):?>
        <div class="alert alert-danger text-center">El usuario ya está en uso</div>
    <?php endif; ?>

    <?php if(isset($_GET["passinvalid"])):?>
        <div class="alert alert-danger text-center">Las contraseñas no coinciden</div>
    <?php endif; ?>
</form>                
            </div>
        </div>
    </div>
</body>
</html>

