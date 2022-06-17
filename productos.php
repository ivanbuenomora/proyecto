<?php include("template/cabecera.php") ?>

<?php

$stmt=$con->prepare("SELECT * FROM productos ORDER BY id_producto DESC");
$stmt->execute();
$lista_productos=$stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($user)): ?>

    <div class="jumbotron">
        <h1 class="display-6">Productos Iván Bueno</h1>
        <hr class="my-3">
    </div>

    <?php foreach($lista_productos as $producto) { ?>

    <div class="col-md-3">

        <div class="card mb-3 imagen-prod">

            <img class="card-img-top imagen-prod" src="img/<?= $producto['RUTA_IMAGEN']; ?>" alt="">
            
            <div class="card-body">
                <h4 class="card-title"><?= $producto['NOMBRE_PROD']; ?></h4>
                <p><?= $producto['DESCRIPCION']; ?></p>
                <p><?= $producto['PRECIO']; ?>€</p>
                <!-- <a name="" id="" class="btn btn-primary" href="#" role="button">Añadir al carrito</a> -->
                <button class="btn btn-primary" type="button">Añadir al carrito</button>
            </div>

        </div>

        
    </div>

    <?php } ?>

<?php else: ?>  

<div class="alert alert-secondary col-md-5">
   <p>Para tener acceso a la tienda debe de <a href="iniciar_sesion.php" class="alert-link">iniciar sesion</a> o <a href="registrarse.php" class="alert-link">registrarse</a>.</p>
</div>

<?php endif; ?>

<?php include("template/pie.php") ?>