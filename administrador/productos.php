<?php
require_once('../base_de_datos.php');
//if ternario:  ("lo que se valida")?"lo que ocurre si se valida":"lo que ocurre si no se valida
//si hay algo en txtID del post, txtID va a ser igual al valor, si esta vacio sera ""
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$nombre_prod=(isset($_POST['nombre']))?$_POST['nombre']:"";
$descripcion=(isset($_POST['mensaje']))?$_POST['mensaje']:"";
$precio=(isset($_POST['precio']))?$_POST['precio']:"";
$ruta_imagen=(isset($_FILES['ruta_imagen']['name']))?$_FILES['ruta_imagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

switch ($accion) {
    case 'Agregar':
        $stmt=$con->prepare("INSERT INTO productos (nombre_prod, descripcion, precio, ruta_imagen) VALUES (:nombre_prod, :descripcion, :precio, :ruta_imagen)");
        $stmt->bindParam(':nombre_prod',$nombre_prod);
        $stmt->bindParam(':descripcion',$descripcion);
        $stmt->bindParam(':precio',$precio);

        // Fecha para distinguir los archivos aunque tengan el mismo nombre
        $fecha=new DateTime();

        // El nombre será la fecha con un guión y el nombre del archivo, si ruta_imagen esta vacio será ""
        $nombre_archivo=$fecha->getTimestamp()."_".$_FILES["ruta_imagen"]["name"];

        // Si el nombre no está vacio, moveremos el archivo a la carpeta img con el nombre nuevo que tiene la fecha
        if ($nombre_archivo!="") {
            move_uploaded_file($_FILES["ruta_imagen"]["tmp_name"],"../img/".$nombre_archivo);
        }

        $stmt->bindParam(':ruta_imagen',$nombre_archivo);
        
        $message = ($stmt->execute()) ? "Producto agregado correctamente" : "Error al agregar el producto" ;
        break;

    case 'Modificar':
        if ($txtID!="") {
    
        $stmt=$con->prepare("UPDATE productos SET nombre_prod=:nombre_prod, descripcion=:descripcion, precio=:precio WHERE id_producto=:id");
        $stmt->bindParam(':nombre_prod',$nombre_prod);
        $stmt->bindParam(':descripcion',$descripcion);
        $stmt->bindParam(':precio',$precio);
        $stmt->bindParam(':id',$txtID);
        $message = ($stmt->execute()) ? "Producto modificado con éxito" : "Error al modificar el producto" ;
        
        if ($ruta_imagen!="") {
            // misma instruccion que al agregar la imagen
            $fecha=new DateTime();
            $nombre_archivo=$fecha->getTimestamp()."_".$_FILES["ruta_imagen"]["name"];
            move_uploaded_file($_FILES["ruta_imagen"]["tmp_name"],"../img/".$nombre_archivo);

            // misma instruccion que al borrar la imagen
            $stmt=$con->prepare("SELECT ruta_imagen FROM productos WHERE id_producto=:id");
            $stmt->bindParam(':id',$txtID);
            $stmt->execute();
            $imagen=$stmt->fetch(PDO::FETCH_LAZY);

            if ($imagen["ruta_imagen"]!="") {
                if (file_exists("../img/".$imagen["ruta_imagen"])) {
                    unlink("../img/".$imagen["ruta_imagen"]);
                }
            }

            $stmt=$con->prepare("UPDATE productos SET ruta_imagen=:ruta_imagen WHERE id_producto=:id");
            $stmt->bindParam(':ruta_imagen',$nombre_archivo);    
            $stmt->bindParam(':id',$txtID);
            $message = ($stmt->execute()) ? "Producto modificado con éxito" : "Error 1 al modificar el producto" ;
        }
        }else{
            $message="Error 2 al modificar el producto";    
        }
        header('Location:'.$url.'/administrador/productos.php');
        break;

    case 'Cancelar':
        // refrescamos la pagina 
        header('Location:'.$url.'/administrador/productos.php');
        break;

    case 'Seleccionar':
        $stmt=$con->prepare("SELECT * FROM productos WHERE id_producto=:id");
        $stmt->bindParam(':id',$txtID);
        $stmt->execute();
        $producto=$stmt->fetch(PDO::FETCH_LAZY);

        $txtID=$producto['ID_PRODUCTO'];
        $nombre_prod=$producto['NOMBRE_PROD'];
        $descripcion=$producto['DESCRIPCION'];
        $precio=$producto['PRECIO'];
        $ruta_imagen=$producto['RUTA_IMAGEN'];

        break;

    case 'Borrar':
        $stmt=$con->prepare("SELECT ruta_imagen FROM productos WHERE id_producto=:id");
        $stmt->bindParam(':id',$txtID);
        $stmt->execute();
        $imagen=$stmt->fetch(PDO::FETCH_LAZY);

        if ($imagen["ruta_imagen"]!="") {
            if (file_exists("../img/".$imagen["ruta_imagen"])) {
                unlink("../img/".$imagen["ruta_imagen"]);
            }
        }
        
        $stmt=$con->prepare("DELETE FROM productos WHERE id_producto=:id");
        $stmt->bindParam(':id',$txtID);
        $stmt->execute();
        break;
}

// hacemos un select de todos los productos que hay en la base de datos para guardarlos en la variable lista 
// El metodo fetchAll genera una asociacion entre los datos que vienen de la tabla y los nuevos registros
// PDO::FETCH_ASSOC devuelve un array indexado cuyos keys son el nombre de las columnas.
$stmt=$con->prepare("SELECT * FROM productos ORDER BY id_producto DESC");
$stmt->execute();
$lista_productos=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('template/cabecera.php'); ?>
<div class="col-md-4">
    
    <div class="card bg-dark bg-opacity-75">
        <div class="card-header">
            Datos del producto
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" value="<?= $txtID; ?>" name="txtID" id="txtID" readonly>
                    <label for="txtID">ID:</label>    
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" value="<?= $nombre_prod; ?>" name="nombre" id="nombre" placeholder="Nombre" required>
                    <label for="nombre_prod">Nombre:</label>
                    <p class="ocultar-mensaje-error">El nombre debe tener entre 2 y 50 caracteres (solo letras)</p>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" name="mensaje" id="mensaje" placeholder="Descripcion" required><?= $descripcion; ?></textarea>
                    <label for="descripcion">Descripcion:</label>
                    <p class="ocultar-mensaje-error">El mensaje debe tener entre 4 y 200 caracteres (excepto los siguiente simbolos $ % & | < > #)</p>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" value="<?= $precio; ?>" name="precio" id="precio" placeholder="Precio" required>
                    <label for="precio">Precio:</label>
                    <p class="ocultar-mensaje-error">El precio debe tener entre 1 o 3 cifras y 2 decimales separados con punto</p>
                </div>

                <div>
                    <?php if ($ruta_imagen!="") { ?>
                        <p>Imagen: <?= $ruta_imagen; ?></p>                  
                        <?php if ($nombre_archivo!="") { ?>
                            <img src="../img/<?= $nombre_archivo; ?>" width="100%" class="mt-2 mb-4" alt="">
                        <?php }else{?>
                            <img src="../img/<?= $ruta_imagen; ?>" width="100%" class="mt-2 mb-4" alt="">
                        <?php }?>
                    <?php } ?>
                    <input type="file" class="form-floating mb-3" name="ruta_imagen" id="ruta_imagen" placeholder="Imagen">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?= ($accion=="Seleccionar")?"disabled":"";?> value="Agregar" id="producto" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?= ($accion!="Seleccionar")?"disabled":"";?> value="Modificar" id="producto" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?= ($accion!="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-danger">Cancelar</button>
                </div>

                <!-- strpos para saber si existe la palabra 'Error' dentro del mensaje y así asignarle una clase u otra -->
                <?php if (strpos($message, 'Error')===false) {
                    ?><p class="text-success mt-3"><?= $message ?></p><?php
                }else {
                    ?><p class="ver-mensaje-error mt-3"><?= $message ?></p><?php
                }?>

            </form>
        </div>
    </div>
</div>

<div class="col-md-8">
    <table class="table table-border bg-body bg-opacity-75">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_productos as $producto) { ?>
            <tr>
                <td><?= $producto['ID_PRODUCTO']; ?></td>
                <td><?= $producto['NOMBRE_PROD']; ?></td>
                <td><?= $producto['DESCRIPCION']; ?></td>
                <td><?= $producto['PRECIO']; ?>€</td>
                <td><img src="../img/<?= $producto['RUTA_IMAGEN']; ?>"width="100" alt=""></td>       
                <td>
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?= $producto['ID_PRODUCTO']; ?>">
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