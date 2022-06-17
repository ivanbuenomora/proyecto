<?php 
    // primero se inica la sesion
    session_start();
    // eliminamos esta sesion
    session_unset();
    // destruimos la sesion
    session_destroy();
    // redireccionamos al usuario
    $url="http://".$_SERVER['HTTP_HOST']."/proyecto";
    header('Location: '.$url);
?>