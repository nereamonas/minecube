<?php

session_set_cookie_params(0,"/");
session_start();

session_destroy();

$uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
$uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); 
$login_orria = 'index.php';
header("Location: http://$uneko_zerbitzaria$uneko_karpeta/$login_orria");

?>
