<?php if(!empty($_POST)){
		
		$captcha = $_POST['g-recaptcha-response'];
		
		$secret = '6LeDXT8dAAAAAE2MaPYZFp4eQ2Tg3CD2p-JTfuvw';
		
		if(!$captcha){
 
			header("location:contactenos.php?error=1");
			
			} else {
			
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
			
			$arr = json_decode($response, TRUE);
			
			if($arr['success'])
			{
				     require("class.phpmailer.php");
                         require("class.smtp.php");
                         require("conexion.php");
                         session_start();
                         require("conexion.php");
                         if (isset($_POST['enviarMail']) && !empty($_POST['enviarMail'])) {
                         include('sendmail.php');//Mando a llamar la funcion que se encarga de enviar el correo electronico
                         $sugerencia = "aflcinema1@gmail.com";
                         $subject = $_POST['asunto'];
                         $message = $_POST['mensaje'];
                         $cc = $_POST['mail'];

                         
                         // mail($to, $subject, $message, $headers);

                              $smtpHost = "smtp.gmail.com";  // Dominio alternativo brindado en el email de alta 
                              $smtpUsuario = ("aflcinema1@gmail.com");  // Mi cuenta de correo afl.sugerencias@gmail.com
                              $smtpClave = "ohiczseicwwbodvh";  // Mi contraseña,  alfsugerencias
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
                              $mail->AddCC($cc); // Se deja en copia el mail del usuario que envía la sugerencia.
                              $mail->AddAddress($sugerencia); // Esta es la dirección a donde enviamos los datos del formulario
                              $mail->Subject = ($subject); // Este es el titulo del email.
                              //$mensajeHtml = nl2br($mensaje);
                              $mail->Body = "<html> 
                                             <body> 
                                                  <h1 align='center'>Mensaje para AFL Cinema</h1>       
                                                  <hr/>
                                                  <h3 align='center'> $message </h3>
                                                  <h4 align='center'>Enviado por $cc </h4>                     
                                             </body> 
                                             </html>
                                             <br />"; // Texto del email en formato HTML
                              //$mail->AltBody = "{$mensaje} \n\n "; // Texto sin formato HTML
                              $mail->SMTPOptions = array(
                              'ssl' => array(
                              'verify_peer' => false,
                              'verify_peer_name' => false,
                              'allow_self_signed' => true
                              )
                              );
                              $estadoEnvio = $mail->Send(); 
                              if($estadoEnvio){
                                   header("location:contactenos.php?estado=2");
                              } else {
                                   header("location:contactenos.php?error=2");
                                   exit();
                              }

                              
                         } 
				} else {
                         header("location:contactenos.php?error=1");
			}
		}
	}
?>

<?php
/*require("class.phpmailer.php");
require("class.smtp.php");
require("conexion.php");
session_start();
require("conexion.php");
if (isset($_POST['enviarMail']) && !empty($_POST['enviarMail'])) {
    include('sendmail.php');//Mando a llamar la funcion que se encarga de enviar el correo electronico
    $sugerencia = "cinemaafl@gmail.com";
    $subject = $_POST['asunto'];
    $message = $_POST['mensaje'];
    $cc = $_POST['mail'];

    
   // mail($to, $subject, $message, $headers);

     $smtpHost = "smtp.gmail.com";  // Dominio alternativo brindado en el email de alta 
     $smtpUsuario = ("aflcinema.contacto@gmail.com");  // Mi cuenta de correo afl.sugerencias@gmail.com
     $smtpClave = "aflcontacto";  // Mi contraseña,  alfsugerencias
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
     $mail->FromName= "AFLcinema Contacto"; // Email desde donde envío el correo.
     $mail->AddCC($cc); // Se deja en copia el mail del usuario que envía la sugerencia.
     $mail->AddAddress($sugerencia); // Esta es la dirección a donde enviamos los datos del formulario
     $mail->Subject = ($subject); // Este es el titulo del email.
     //$mensajeHtml = nl2br($mensaje);
     $mail->Body = "<html> 
                        <body> 
                             <h1 align='center'>Mensaje para AFL Cinema</h1>       
                             <hr/>
                             <h3 align='center'> $message </h3>
                             <h4 align='center'>Enviado por $cc </h4>                     
                        </body> 
                    </html>
                    <br />"; // Texto del email en formato HTML
     //$mail->AltBody = "{$mensaje} \n\n "; // Texto sin formato HTML
     $mail->SMTPOptions = array(
     'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
       )
     );
     $estadoEnvio = $mail->Send(); 
     if($estadoEnvio){
          header("location:contactenos.php?ok=1");
     } else {
          header("location:contactenos.php?ok=2");
           exit();
     }

	header("location:contactenos.php");
} */
?>