<?php
session_start();
require("conexion.php");
if (isset($_POST['enviarMail']) && !empty($_POST['enviarMail'])) {

    $to = "cinemaafl@gmail.com";
    $subject = $_POST['asunto'];
    $message = $_POST['mensaje'];
    $headers = "From:" . $_POST['mail'];

    echo $to, $subject, $message, $headers;
    
    mail($to, $subject, $message, $headers);

} 
?>