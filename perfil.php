<?php include("template/cabecera.php") ?>

<div class="jumbotron">
    <h1 class="display-6">Informacion de usuario</h1>
    <hr class="my-3">
</div>
<div class="col-md-12 bg-body bg-opacity-50 lead" >
    <div class="col-md-6">
        <p>ID: <strong><?= $user['id_usuario']; ?></strong></p>
        <p>Usuario: <strong><?= $user['usuario']; ?></strong></p>
        <p>Nombre: <strong><?= $user['nombre']; ?></strong></p>
    </div>
    <div class="col-md-6">
        <p>Apellidos: <strong><?= $user['apellidos']; ?></strong></p>
        <p>Email: <strong><?= $user['email']; ?></strong></p>
    </div>
    <!-- <table class="table table-border">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $user['id_usuario']; ?></td>
                <td><?= $user['usuario']; ?></td>
                <td><?= $user['nombre']; ?></td>
                <td><?= $user['apellidos']; ?></td>
                <td><?= $user['email']; ?></td>
            </tr>          
        </tbody>
    </table> -->
</div>

<?php include("template/pie.php") ?>