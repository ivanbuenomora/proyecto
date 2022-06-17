<?php include("template/cabecera.php");?>
<?php
$usuario=$_POST['usuario'];
$nombre=$_POST['nombre'];
$apellidos=$_POST['apellidos'];
$email=$_POST['email'];
$pass=$_POST['password'];
$pass2=$_POST['password2'];

    // comprobamos que los campos no estan vacios
    if(!empty($usuario) && !empty($nombre) && !empty($apellidos) && !empty($email) && !empty($pass) && !empty($pass2)){   
      
      // comprobamos que el usuario introducido no existe en la base de datos
      $error_usuario='';
      $result = $con->query("SELECT * FROM usuarios WHERE usuario = '$usuario'");
      if ($result->rowCount() > 0) {
        $error_usuario='El usuario "'.$usuario.'" ya existe';
        $usuario=null;
      }

      // comprobamos que el email introducido no existe en la base de datos
      $error_email='';
      $result = $con->query("SELECT * FROM usuarios WHERE email = '$email'");
      if ($result->rowCount() > 0) {
        $error_email='El email "'.$email.'" ya existe';
        $email=null;
      }

      // creamos una sentencia sql para insertar un nuevo usuario en la base de datos
      // ejecutamos el metodo prepare que ejecuta la consulta sql
      $stmt = $con->prepare("INSERT INTO usuarios (usuario, nombre, apellidos, email, password) VALUES (:usuario, :nombre, :apellidos, :email, :password)");
      
      // a traves del statement con el metodo de vincular parametros vinculamos los 
      // valores introducidos en el formulario a las variables de la sentencia sql 

      $stmt->bindParam(':usuario',$usuario);
      $stmt->bindParam(':nombre',$nombre);
      $stmt->bindParam(':apellidos',$apellidos);
      $stmt->bindParam(':email',$email);

      // antes de guardar las contraseñas es recomendable cifrarlas
      $password = password_hash($pass, PASSWORD_BCRYPT);
      $stmt->bindParam(':password',$password);
      
      // ejecutamos la sentencia y guardamos el mensaje para saber si se ha realizado correctamente o no
      $message = ($stmt->execute()) ? "si" : "no" ;
    }
?>


<form method="POST" class="p-3 form bg-body bg-opacity-75">
  <fieldset>
    <legend>Registrar nueva cuenta</legend>

    <div class="form-floating mb-3">
      <input type="text" class="form-control" value="<?= $usuario; ?>" name="usuario" id="usuario" placeholder="Usuario">
      <label for="usuario">Usuario</label>
      <p class="ocultar-mensaje-error">El usuario debe tener entre 2 y 50 caracteres (letras, numeros y guion bajo)</p>
      <?php if (!empty($error_usuario)) { ?>
        <p class="ver-mensaje-error"><?= $error_usuario;?></p>
      <?php }?>
    </div>
    
    <div class="form-floating mb-3">
      <input type="text" class="form-control" value="<?= $nombre; ?>" name="nombre" id="nombre" placeholder="Nombre">
      <label for="nombre">Nombre</label>
      <p class="ocultar-mensaje-error">El nombre debe tener entre 2 y 50 caracteres (solo letras)</p>
    </div>

    <div class="form-floating mb-3">
      <input type="text" class="form-control" value="<?= $apellidos; ?>" name="apellidos" id="apellidos" placeholder="Apellidos">
      <label for="apellidos">Apellidos</label>
      <p class="ocultar-mensaje-error">Los apellidos deben tener entre 2 y 50 caracteres (solo letras)</p>
    </div>

    <div class="form-floating mb-3">
      <input type="email" class="form-control" value="<?= $email; ?>" name="email" id="email" placeholder="Email">
      <label for="email">Email</label>
      <p class="ocultar-mensaje-error">El email debe ser en minusculas y puede tener guion bajo y numeros antes del @ "ejemplo_1@gmail.com"</p>
      <?php if (!empty($error_email)) { ?>
        <p class="ver-mensaje-error"><?= $error_email;?></p>
      <?php }?>
    </div>

    <div class="form-floating mb-3">
      <input type="password" class="form-control" value="<?= $pass; ?>" name="password" id="password" placeholder="Contraseña">
      <label for="contraseña">Contraseña</label>
      <p class="ocultar-mensaje-error">La contraseña debe tener entre 4 y 50 caracteres</p>
    </div>

    <div class="form-floating mb-3">
      <input type="password" class="form-control" value="<?= $pass2; ?>" name="password2" id="password2" placeholder="Confirmar contraseña">
      <label for="contraseña">Confirmar contraseña</label>
      <p class="ocultar-mensaje-error">Las contraseñas no coinciden</p>
    </div>

    <button type="submit" class="btn btn-primary mb-2" id="registrarse">Registrarse</button>

    <?php switch ($message) {
    case 'si':
        ?><p class="text-success">Usuario añadido correctamente</p><?php
        break;
    case 'no':
        ?><p class="ver-mensaje-error">Error al añadir el usuario</p><?php
        break;
    }?>

  </fieldset>
  <a href="iniciar_sesion.php">Ya estoy registrado</a>
</form>

<?php include("template/pie.php") ?>