<?php
require("class.phpmailer.php");
require("class.smtp.php");
require("conexion.php");
$user=$_POST['mail'];
$mensaje="Recuperar su Contraseña";
if (isset($_POST['buscar'])){
 include('sendmail.php');//Mando a llamar la funcion que se encarga de enviar el correo electronico
 $consulta=mysqli_query($conexion,"SELECT * FROM usuarios WHERE mail='$user'");
 if($r=mysqli_fetch_array($consulta)){
     echo "enviar email a ". $r['mail'];
     $token=uniqid();// genera un ID único
     $sql=mysqli_query($conexion,"UPDATE usuarios set token='$token' WHERE mail='{$r['mail']}'");
	 $smtpHost = "smtp.gmail.com";  // Dominio alternativo brindado en el email de alta 
     $smtpUsuario = ("aflcinema1@gmail.com");  // Mi cuenta de correo
     $smtpClave = "ohiczseicwwbodvh";  // Mi contraseña
     $mail = new PHPMailer();
     $mail->IsSMTP();
     $mail->SMTPAuth = true;
     $mail->Port = 587; 
     $mail->IsHTML(true); 
     $mail->CharSet = "utf-8";

     // VALORES A MODIFICAR //
     $mail->Host = $smtpHost; 
     $mail->Username = $smtpUsuario; 
     $mail->Password = $smtpClave;
     $mail->setFrom = $smtpUsuario;
     $mail->FromName= "AFLcinema"; // Email desde donde envío el correo.
     $mail->AddAddress($user); // Esta es la dirección a donde enviamos los datos del formulario
     $mail->Subject = "Restablecer contraseña en AFLcinema"; // Este es el titulo del email.
     $mensajeHtml = nl2br($mensaje);
     $mail->Body = "<html> 
                        <body> 
                             <h1 align='center'>AFLcinema</h1>
                             <h2>Solicitud de restablecimiento de contraseña</h2></div>
                             <p>Usted ha solicitado una nueva contraseña para la siguiente cuenta en AFLcinema</p>
                             <p>Si no hiciste esta solicitud simplemente ignora este correo electrónico. Si quiere proceder: </p>
                             <a href='http://localhost/practicapro/recuperar.php?token=$token'>Haz clic aquí para restablecer tu contraseña</a>
                        </body> 
                    </html>
                    <br />"; // Texto del email en formato HTML
     $mail->AltBody = "{$mensaje} \n\n "; // Texto sin formato HTML
     $mail->SMTPOptions = array(
     'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
       )
     );
     $estadoEnvio = $mail->Send(); 
     if($estadoEnvio){
          header("location:login.php?recuperar=1");
     } else {
          header("location:login.php?recuperar=2");
           exit();
     }
 }else{
   header("location:login.php?recuperar=3");
 }
}
        
?>