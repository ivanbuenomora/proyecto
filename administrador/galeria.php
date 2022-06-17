<?php
require_once('../base_de_datos.php');

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$ruta_foto=(isset($_FILES['ruta_foto']['name']))?$_FILES['ruta_foto']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

switch ($accion) {
    case 'Agregar':
        if ($ruta_foto!="") {
        $stmt=$con->prepare("INSERT INTO galeria (ruta_foto) VALUES (:ruta_foto)");     
        // Fecha para distinguir los archivos aunque tengan el mismo nombre
        $fecha=new DateTime();

        // El nombre será la fecha con un guión y el nombre del archivo, si ruta_foto esta vacio será ""
        $nombre_archivo=$fecha->getTimestamp()."_".$_FILES["ruta_foto"]["name"];
        
        // Si el nombre no está vacio, moveremos el archivo a la carpeta img con el nombre nuevo que tiene la fecha
        if ($nombre_archivo!="") {
            move_uploaded_file($_FILES["ruta_foto"]["tmp_name"],"../img/".$nombre_archivo);
        }

        $stmt->bindParam(':ruta_foto',$nombre_archivo);
        $message = ($stmt->execute()) ? "Fotografía agregada con éxito" : "Error al agregar la fotografía" ;
        }else{
            $message="Error al agregar la fotografía";
        }

        break;

    case 'Modificar':       
        if ($ruta_foto!="") {
            // misma instruccion que 'Agregar'
            $fecha=new DateTime();
            $nombre_archivo=$fecha->getTimestamp()."_".$_FILES["ruta_foto"]["name"];
            move_uploaded_file($_FILES["ruta_foto"]["tmp_name"],"../img/".$nombre_archivo);

            // misma instruccion que 'Borrar'
            $stmt=$con->prepare("SELECT ruta_foto FROM galeria WHERE id_foto=:id");
            $stmt->bindParam(':id',$txtID);
            $stmt->execute();
            $foto=$stmt->fetch(PDO::FETCH_LAZY);

            if ($foto["ruta_foto"]!="") {
                // Preguntamos si el archivo existe en la carpeta img para despues borrarlo
                if (file_exists("../img/".$foto["ruta_foto"])) {
                    unlink("../img/".$foto["ruta_foto"]);
                }
            }

            // Despues de haber borrado la imagen antigua, actualizamos con la nueva
            $stmt=$con->prepare("UPDATE galeria SET ruta_foto=:ruta_foto WHERE id_foto=:id");
            $stmt->bindParam(':ruta_foto',$nombre_archivo);    
            $stmt->bindParam(':id',$txtID);
            $message = ($stmt->execute()) ? "Fotografía modificada con éxito" : "Error al modificar la fotografía" ;
        }else{
            $message="Error al modificar la fotografía";
        }
        
        header('Location:'.$url.'/administrador/galeria.php');
        break;

    case 'Cancelar':
        // refrescamos la pagina 
        header('Location:'.$url.'/administrador/galeria.php');
        break;

    case 'Seleccionar':
        $stmt=$con->prepare("SELECT * FROM galeria WHERE id_foto=:id");
        $stmt->bindParam(':id',$txtID);
        $stmt->execute();
        $foto=$stmt->fetch(PDO::FETCH_LAZY);
        $ruta_foto=$foto["RUTA_FOTO"];
        break;

    case 'Borrar':

        $stmt=$con->prepare("SELECT ruta_foto FROM galeria WHERE id_foto=:id");
        $stmt->bindParam(':id',$txtID);
        $stmt->execute();
        $foto=$stmt->fetch(PDO::FETCH_LAZY);

        if ($foto["ruta_foto"]!="") {
            if (file_exists("../img/".$foto["ruta_foto"])) {
                unlink("../img/".$foto["ruta_foto"]);
            }
        }

        // Despues de borrarlo de la carpeta img, lo borramos de la base de datos
        $stmt=$con->prepare("DELETE FROM galeria WHERE id_foto=:id");
        $stmt->bindParam(':id',$txtID);
        $stmt->execute();

        header('Location: http://'.$_SERVER['HTTP_HOST'].'/proyecto/administrador/galeria.php');

        break;
}

$stmt=$con->prepare("SELECT * FROM galeria ORDER BY ID_FOTO DESC");
$stmt->execute();
$lista_fotos=$stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include('template/cabecera.php'); ?>

<div class="col-md-4">
    <div class="card bg-dark bg-opacity-75">
        <div class="card-header">
            Datos de la fotografía
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" value="<?= $txtID; ?>" name="txtID" id="txtID" readonly>
                    <label for="txtID">ID:</label>    
                </div>

                <div>               
                    <?php if ($ruta_foto!="") { ?>
                        <p>Imagen: <?= $ruta_foto; ?><p>               
                        <img src="../img/<?= $ruta_foto; ?>" width="100%" class="mt-2 mb-4" alt="" >                
                    <?php } ?>            
                    <input type="file" class="form-floating mb-3" name="ruta_foto" id="ruta_foto" placeholder="Fotografía">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" <?= ($accion=="Seleccionar")?"disabled":""; ?> name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" <?= ($accion!="Seleccionar")?"disabled":""; ?> name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" <?= ($accion!="Seleccionar")?"disabled":""; ?> name="accion" value="Cancelar" class="btn btn-danger">Cancelar</button>
                </div>

                <!-- strpos para saber si existe la palabra 'Error' dentro del mensaje y así asignarle una clase u otra -->
                <?php if (strpos($message, 'Error')===false) {
                    ?><p class="text-success mt-3"><?= $message; ?></p><?php
                }else {
                    ?><p class="ver-mensaje-error mt-3"><?= $message; ?></p><?php
                }?>
            </form>
        </div>
    </div>
</div>
<div class="col-md-8 ">
    <table class="table table-border bg-body bg-opacity-75">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fotografía</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_fotos as $foto) { ?>
            <tr>
                <td><?= $foto['ID_FOTO']; ?></td>
                <td><?= $foto['RUTA_FOTO']; ?></td>
                <td><img src="../img/<?= $foto['RUTA_FOTO']; ?>" width="100" alt=""></td>
                <td>
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?= $foto['ID_FOTO']; ?>">
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
                </td>
            </tr>    
            <?php } ?>       
        </tbody>
    </table>
</div>

<?php include('template/pie.php');?>