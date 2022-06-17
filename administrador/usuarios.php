<?php
require_once('../base_de_datos.php');
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

if($accion='Borrar') {
    $stmt=$con->prepare("DELETE FROM usuarios WHERE id_usuario=:id");
    $stmt->bindParam(':id',$txtID);
    $stmt->execute();
}

$stmt=$con->prepare("SELECT * FROM usuarios");
$stmt->execute();
$lista_usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include('template/cabecera.php');?>
<div class="col-md-12" >
    <table class="table table-border bg-body bg-opacity-75">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_usuarios as $usu) { ?>
            <tr>
                <td><?= $usu['ID_USUARIO']; ?></td>
                <td><?= $usu['USUARIO']; ?></td>
                <td><?= $usu['NOMBRE']; ?></td>
                <td><?= $usu['APELLIDOS']; ?></td>
                <td><?= $usu['EMAIL']; ?></td>
                <td>
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?= $usu['ID_USUARIO']; ?>">
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
                </td>
            </tr>    
            <?php } ?>       
        </tbody>
    </table>
</div>

<?php include('template/pie.php');?>