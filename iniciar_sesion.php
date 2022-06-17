<?php  
require_once('base_de_datos.php');

$email=$_POST['email'];
$password=$_POST['password'];   
    // comprobamos que los campos no estan vacios
    if (!empty($email) && !empty($password)){
        // comprobamos que el email introducido existe en la base de datos
        $error_email='';
        $success_email='';
        $result = $con->query("SELECT * FROM usuarios WHERE email = '$email'");
        if ($result->rowCount() == 0) {
          $error_email='El email "'.$email.'" no existe';
          $email=null;
        }else {
          $success_email='El email existe en la base de datos';
        }

        // ejecutamos el metodo prepare que ejecuta una consulta sql
        $stmt = $con->prepare('SELECT usuario, email, password FROM usuarios WHERE email=:email');
        
        // vinculamos el parametro 
        $stmt->bindParam(':email',$email);

        // ejecutamos la consulta sql
        $stmt->execute();

        // obtenemos a traves del metodo fetch el resultado de la consulta, 
        // obtenemos los datos del usuario. fetch_assoc devuelve un array indexado cuyos keys son el nombre de las columnas.
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $message='';

        // usamos el metodo count para contar el resultado si es mayor que 0 es que si hay
        // y verificamos la contraseña introducida con la contraseña que hay en la base de datos
        if (is_countable($results) > 0 && password_verify($password,$results['password'])) {
            
            // almacenamos nombre unico del usuario en una variable de sesion llamada usuario
            $_SESSION['usuario'] = $results['usuario'];
            
            // redireccionamos a la pagina inicial
            header('Location: '.$url);
        }else{
            $message='El usuario y/o contraseña incorrecto';
        }
    }
?>

<?php include("template/cabecera.php") ?>

<form method="post" class="p-3 form bg-body bg-opacity-75">
  <fieldset>
    <legend>Inicia sesion en tu cuenta</legend>

    <div class="form-floating mb-3">
      <input type="email" required class="form-control" value="<?= $email; ?>" name="email" id="email" placeholder="Email" maxlength="50">
      <label for="email">Email</label>
      <p class="ocultar-mensaje-error">El email debe ser en minusculas y puede tener guion bajo y numeros antes del @ "ejemplo_1@gmail.com"</p>
      <?php if (!empty($error_email)) { ?>
        <p class="ver-mensaje-error"><?= $error_email;?>
      <?php } elseif(!empty($success_email)){?>
      <p class="text-success"><?= $success_email;?>
      <?php } ?>
    </div>

    <div class="form-floating mb-3">
      <input type="password" required class="form-control" name="password" id="password" placeholder="Contraseña" maxlength="50">
      <label for="contraseña">Contraseña</label>
      <p class="ocultar-mensaje-error">La contraseña debe tener entre 4 y 50 caracteres</p>
    </div>
    
    <p class="ver-mensaje-error"><?= $message; ?></p>

    <button type="submit" class="btn btn-primary mb-3" id="iniciar">Iniciar sesión</button>
    
  </fieldset>
  <p><a href="recuperar.php" class="mb-3">¿A olvidado su contraseña?</a></p>

  <a href="registrarse.php">Registrarse</a>
</form>

<?php include("template/pie.php") ?>