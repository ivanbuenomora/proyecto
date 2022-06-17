<?php
require_once('base_de_datos.php');

function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
  require_once ('PhpMailer/class.phpmailer.php');
  
  $mail = new phpmailer();

  $mail->PluginDir = "PhpMailer/";

  $mail->Mailer = "smtp";
  $mail->SMTPAuth = true;

  $mail->SMTPSecure = 'ssl'; 
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465;

  // $mail->Host = 'localhost';
  // $mail->Port = '25';

  $mail->Username = 'ivanbmora@hotmail.com'; 
  $mail->Password = 'antonioperez3726'; 
  
  $mail->setFrom('ivanbmora@hotmail.com', 'Ivan');
  $mail->addAddress($email, $nombre);
  
  $mail->Subject = $asunto;
  $mail->Body    = $cuerpo;
  $mail->IsHTML(true);
  
  if($mail->send())
  return true;
  else
  return false;

}

$token = md5(uniqid(mt_rand(), false));	
  

$email=$_POST['email'];
if (!empty($email)){
  // comprobamos que el email introducido existe en la base de datos
  $error_email='';
  $success_email='';
  $result = $con->query("SELECT * FROM usuarios WHERE email = '$email'");
  if ($result->rowCount() == 0) {
    $error_email='El email "'.$email.'" no existe';
    $email=null;
  }else {
    // ejecutamos el metodo prepare que ejecuta una consulta sql
    $stmt = $con->prepare('SELECT id_usuario, nombre, email FROM usuarios WHERE email=:email'); 
    // vinculamos el parametro 
    $stmt->bindParam(':email',$email);
    // ejecutamos la consulta sql
    $stmt->execute();
    // obtenemos a traves del metodo fetch el resultado de la consulta, 
    // obtenemos los datos del usuario. fetch_assoc devuelve un array indexado cuyos keys son el nombre de las columnas.
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    $id=$results['id_usuario'];
    $nombre=$results['nombre'];
    $email=$results['email'];

    $urlCorreo = $url."/cambia_pass.php?user_id=".$id."&token=".$token;

    $asunto = "Recuperar contraseña";

    $cuerpo = "Hola $nombre:<br/><br/>Se ha solicitado un recuperacion de contraseña.<br/><br/>
    Para restaurar la contraseña visita la siguiente direccion: <a href='$urlCorreo'>$urlCorreo</a>";
  
    if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
      echo "Se ha enviado un correo electronico a la direccion $email para restablecer tu contraseña.";
      echo "<a href=$url.'/iniciar_sesion.php'>Iniciar sesion</a>";
      exit;
    }else{
      $error_email="Error al enviar el correo";
    }
  }
}
?>
<?php include("template/cabecera.php") ?>
<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" class="p-3 form bg-body bg-opacity-75">
  <fieldset>
    <legend>Recupera tu contraseña</legend>

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
    
    <p class="ver-mensaje-error"><?= $message; ?></p>

    <button type="submit" class="btn btn-primary mb-2" id="recuperar">Recuperar contraseña</button>
  </fieldset>
</form>

<?php include("template/pie.php") ?>