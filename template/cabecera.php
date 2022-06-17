<?php require_once('base_de_datos.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto</title>
    <style>
        @import "css/bootstrap.css";
        @import "css/estilos.css";
        @import "css/all.css";
    </style>
    <script src="js/codigo.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="libjs/jquery.min.js"></script>
    <script src="libjs/jquery-easing.js"></script>
    
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark mb-3">

            <a class="navbar-brand" href="<?php echo $url?>">
                <img src="/proyecto/img/logo blanco.png" width="130" class="d-inline-block align-top" alt="Logo Ivan Bueno">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor02">
                
                <div class="navbar-nav text-center">                    
                        <a class="nav-item nav-link" href="<?php echo $url?>">INICIO</a>
                        <a class="nav-item nav-link" href="<?php echo $url?>/biografia.php">BIOGRAFÍA</a>
                        <a class="nav-item nav-link" href="<?php echo $url?>/galeria.php">GALERÍA</a>
                        <a class="nav-item nav-link" href="<?php echo $url?>/musica.php">MÚSICA</a>
                        <a class="nav-item nav-link" href="<?php echo $url?>/productos.php">TIENDA</a>
                        <a class="nav-item nav-link" href="<?php echo $url?>/contacto.php">CONTACTO</a>

                    <!-- si la variable usuario no está vacia significa que esta logeado -->
                    <?php if(!empty($user)): ?>                    
                        <a class="nav-item nav-link" href="<?php echo $url?>/perfil.php">PERFIL</a>    
                        <!-- si el usuario es admin01 tendra acceso al administrador del sitio -->
                        <?php if($user['usuario']=='admin01'){ ?>                      
                        <a class="nav-item nav-link" href="<?php echo $url?>/administrador/index.php">ADMINISTRADOR</a>                      
                        <?php } ?>                        
                        <a class="nav-item nav-link" href="<?php echo $url?>/cerrar_sesion.php">SALIR</a>

                    <!-- si la variable usuario esta vacia no esta logeado -->
                    <?php else: ?>
                        <a class="nav-item nav-link" href="<?php echo $url?>/iniciar_sesion.php">INICIAR SESION</a>        
                        <a class="nav-item nav-link" href="<?php echo $url?>/registrarse.php">REGISTRARSE</a>  
                    <?php endif; ?>
                </div>
                <div class="iconos navbar-nav text-center"> 
                    <a href="https://soundcloud.com/ivanbuenodj"><i class="icono-soundcloud"></i></a>
                    <a href="https://www.youtube.com/channel/UC-xOdDsikgzMmgSHgOPT8cA"><i class="icono-youtube"></i></a>
                    <a href="https://www.facebook.com/ivanbuenodj"><i class="icono-facebook"></i></a>
                </div>
            </div>
            
        </nav>
    </div>    
    <div class="container">
        

        <div class="row justify-content-center">
        