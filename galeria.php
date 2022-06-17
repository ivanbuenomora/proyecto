<?php include("template/cabecera.php") ?>
<div class="jumbotron">
    <h1 class="display-6">Porque una imagen vale mas que mil palabras...</h1>
    <hr class="my-3">
</div>

<div class="contenedor-galeria imagen-con-efecto">
    
<?php
// mostrar las imagenes que hay en la base de datos
$stmt = $con->prepare("SELECT ruta_foto FROM galeria ORDER BY id_foto DESC");

$stmt->execute();

while ($foto=$stmt->fetch(PDO::FETCH_ASSOC)){ ?>

     <img src= "img/<?=$foto["ruta_foto"]?>" class='imagen'>

<?php } ?>

</div>

<?php include("template/pie.php") ?>