<?php
require_once('../base_de_datos.php');
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

if($accion='Borrar') {
    $stmt=$con->prepare("DELETE FROM mensajes WHERE id_mensaje=:id");
    $stmt->bindParam(':id',$txtID);
    $stmt->execute();
}

$stmt=$con->prepare("SELECT * FROM mensajes");
$stmt->execute();
$lista_mensajes=$stmt->fetchAll(PDO::FETCH_ASSOC);

include('template/cabecera.php');

if (!empty($lista_mensajes)) {
?>
<div class="col-md-12" >
    <table class="table table-border bg-body bg-opacity-75">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_mensajes as $mensaje) { ?>
            <tr>
                <td><?= $mensaje['ID_MENSAJE']; ?></td>
                <td><?= $mensaje['NOMBRE']; ?></td>
                <td><?= $mensaje['EMAIL']; ?></td>
                <td><?= $mensaje['ASUNTO']; ?></td>
                <td><?= $mensaje['MENSAJE']; ?></td>
                <td>
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?= $mensaje['ID_MENSAJE']; ?>">
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
                </td>
            </tr>    
            <?php } ?>       
        </tbody>
    </table>
</div>
<?php }else{?>

<div class="row justify-content-center">
    <div class="bg-body col-md-4 text-center">
        <h5>No existe ningun mensaje</h5>
    </div>
</div>
<?php }
include('template/pie.php');?>
