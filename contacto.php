<?php include("template/cabecera.php") ?>
<?
    if(!empty($_POST['nombre']) && !empty($_POST['email']) && !empty($_POST['asunto']) && !empty($_POST['mensaje'])){ 

        $stmt = $con->prepare("INSERT INTO mensajes (nombre, email, asunto, mensaje) VALUES (:nombre, :email, :asunto, :mensaje)");
        
        $stmt->bindParam(':nombre',$_POST['nombre']);
        $stmt->bindParam(':email',$_POST['email']);
        $stmt->bindParam(':asunto',$_POST['asunto']);
        $stmt->bindParam(':mensaje',$_POST['mensaje']);

        $message = ($stmt->execute()) ? "si" : "no" ;
    }
?>

<form action="" method="post" class="p-3 form bg-body bg-opacity-75">
  <fieldset>
    <legend>Puedes enviarme un mensaje</legend>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
      <label for="nombre">Nombre</label>
      <p class="ocultar-mensaje-error">El nombre debe tener entre 2 y 50 caracteres (solo letras)</p>
    </div>

    <div class="form-floating mb-3">
      <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
      <label for="email">Email</label>
      <p class="ocultar-mensaje-error">El email debe ser en minusculas y puede tener guion bajo y numeros antes del @ "ejemplo_1@gmail.com"</p>
    </div>

    <div class="form-floating mb-3">
      <input type="text" class="form-control" name="asunto" id="asunto" placeholder="Asunto" required>
      <label for="asunto">Asunto</label>
      <p class="ocultar-mensaje-error">El asunto debe tener entre 4 y 50 caracteres (solo letras)</p>
    </div>

    <div class="form-floating mb-3">
      <textarea class="form-control" name="mensaje" id="mensaje" placeholder="Mensaje" required></textarea>
      <label for="mensaje">Mensaje</label>
      <p class="ocultar-mensaje-error">El mensaje debe tener entre 4 y 200 caracteres (excepto los siguiente simbolos $ % & | < > #)</p>
    </div>

    <button type="submit" class="btn btn-primary mb-2" id="contacto">Enviar</button>

    <?php switch ($message) {
    case 'si':
        ?><p class="text-success">Mensaje enviado correctamente</p><?php
        break;
    case 'no':
        ?><p class="ver-mensaje-error">Error al enviar el mensaje</p><?php
        break;
    }?>

  </fieldset>
</form>

<?php include("template/pie.php") ?>