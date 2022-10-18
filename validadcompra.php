<?php
use BenMajor\ImageResize\Image;
require "vendor/autoload.php";
require("class.phpmailer.php");
require("class.smtp.php");
require("conexion.php");
session_start();
require("conexion.php");
if (isset($_POST['enviar']) && !empty($_POST['enviar'])) {
$consulta=mysqli_query($conexion,"SELECT mail from usuarios where idusuario={$_SESSION['login']}");
while($r=mysqli_fetch_array($consulta)){
    $mail1=$r['mail'];
}

function imagen(){
if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {

    $errores=0;
       
	$extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $name = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
    $mimeType = $_FILES['imagen']['type'];

	$extension2 = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $name2 = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
    $mimeType2 = $_FILES['imagen']['type'];

    # Generate a new image resize object using a upload image:
    $image = new Image($_FILES['imagen']['tmp_name']);
    $image2 = new Image($_FILES['imagen']['tmp_name']);

    if ($mimeType == "imagen/png" || $mimeType == "imagen/gif" || $mimeType == "imagen/svg+xml" || $mimeType == "imagen/svg") {
	      
        $image->setTransparency(true); // agregar transparencia si el formato de imagen acepta transparencia
    } else {
        $image->setTransparency(false); // no agregar transparencia si el formato de la imagen no acepta transparencia
    }
	
		

    # Set the background to white:
    $image->setBackgroundColor('#212121');

    # Contain the image:
    $image->contain(200);

    $image->output("imagenes");
	$image2->output("ImagenesOriginales"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

    # Renombrar la imagen genereda por el metodo output
    
    rename($image->getOutputFilename(), 'imagenes/'.$name);
	rename($image2->getOutputFilename(), 'ImagenesOriginales/'.$name2);
    }

	if (empty($errores)==true) {
		move_uploaded_file($image, "imagenes/".$name);
		move_uploaded_file($image2, "ImagenesOriginales/".$name2);
		return $name;
	}
	else{
		
		print_r($errores);
		
	}
}
$fechaPago =$_POST['fechaPago'];
$tipoPago =$_POST['tipoPago'];
$totalPagar =$_POST['totalpagar'];
$imagen=imagen();
include('sendmail.php');//Mando a llamar la funcion que se encarga de enviar el correo electronico
$sugerencia = "aflcinema1@gmail.com";
//$subject = $_POST['asunto'];
//$message = $_POST['mensaje'];


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
     $mail->AddCC($mail1); // Se deja en copia el mail del usuario que envía la sugerencia.
     $mail->AddAddress($sugerencia); // Esta es la dirección a donde enviamos los datos del formulario
     //$mail->Subject = ($subject); // Este es el titulo del email.
     //$mensajeHtml = nl2br($mensaje);
     $mail->Body = "<html> 
                    <body> 
                         <h1 align='center'>Comprobante de pago</h1>       
                         <hr/>
                         <h3 align='center'> Comprobante de pago </h3>
                         <h4 align='center'>Enviado por $mail1 </h4>  
                         <img src='http://localhost/practicapro/ImagenesOriginales/".$imagen."'/>                   
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
          header("location:index.php?exito=1");
     } else {
          header("location:index.php?error=2");
          exit();
     }

     
 
} else {
header("location:index.php?error=1");
}
?>

