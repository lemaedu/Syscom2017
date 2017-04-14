<?php

session_start();

$_SESSION['s_usuario'] = NULL;
$_SESSION['s_rol'] = NULL;
$_SESSION['s_id_rol'] = NULL;
$_SESSION['s_estado'] = NULL;
$_SESSION['s_id_usuario'] = NULL;
$_SESSION['s_tiempo'] = NULL;

session_destroy();
header("location:index.php");
?>