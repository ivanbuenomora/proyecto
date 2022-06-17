<?php 
require_once('../base_de_datos.php');
include('template/cabecera.php');?>

            <div class="col-md-12 bg-body bg-opacity-75">
                <div class="jumbotron">
                    <h1 class="display-3">Administrador</h1>
                    <p class="lead">Aqui puedes administrar las tablas de galeria, productos, usuarios y mensajes</p>
                    <hr class="my-2">
                    <div class="d-flex">
                        <p class="lead m-3">
                            <a class="btn btn-primary btn-lg" href="<?= $url; ?>/administrador/galeria.php" role="button">Galeria</a>
                        </p>
                        <p class="lead m-3">
                            <a class="btn btn-primary btn-lg" href="<?= $url; ?>/administrador/productos.php" role="button">Productos</a>
                        </p>
                        <p class="lead m-3">
                            <a class="btn btn-primary btn-lg" href="<?= $url;?>/administrador/usuarios.php" role="button">Usuarios</a>
                        </p>
                        <p class="lead m-3">
                            <a class="btn btn-primary btn-lg" href="<?= $url;?>/administrador/mensajes.php" role="button">Mensajes</a>
                        </p>
                    </div>
                </div>
            </div>
            
<?php include('template/pie.php');?>        
        