<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador del sitio web</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="../js/validacion.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $url;?>/administrador">
                <img src="/proyecto/img/logo negro.png" width="130" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-center" id="navbarColor02">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url;?>/administrador/galeria.php">GALERÍA</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url;?>/administrador/productos.php">PRODUCTOS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url;?>/administrador/usuarios.php">USUARIOS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url;?>/administrador/mensajes.php">MENSAJES</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url;?>">VER SITIO WEB</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url;?>/cerrar_sesion.php">SALIR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
    <br/>
        <div class="row">
