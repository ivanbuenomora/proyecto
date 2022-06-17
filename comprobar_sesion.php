<?php
    // iniciamos la sesion
    session_start();

    // si existe la variable usuario dentro de nuestra sesion vamos a hacer una consulta
    if (isset($_SESSION['usuario'])) {
        $stmt = $con->prepare('SELECT id_usuario, usuario, nombre, apellidos, email, password FROM usuarios WHERE usuario = :usuario');

        $stmt->bindParam(':usuario',$_SESSION['usuario']);

        $stmt->execute();

        // almacenamos los resultados en la variable results
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        // creamos la variable usuario vacia
        $user=null;

        // comprobamos que results es mayor que 0 para saber si hay datos o no
        if(is_countable($results) > 0){
            // almacenamos en la variable usuario el resultado
            $user = $results;
        }
    }
?>