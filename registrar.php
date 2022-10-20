 <?php
 require("conexion.php");
 if (isset($_POST['registrado']) && !empty($_POST['registrado'])) {
    $usuario=$_POST['nombre_usu'];
    $mail=$_POST['email'];
    $contrasenia=sha1($_POST['contrasenia']);
    $verificarMail=mysqli_query($conexion,"SELECT mail FROM usuarios WHERE mail='$mail' LIMIT 1");
    $verificarUsuario=mysqli_query($conexion,"SELECT nombre_usuario FROM usuarios WHERE nombre_usuario='$usuario' LIMIT 1");
    if(mysqli_num_rows($verificarMail)>0){
        header("location:index.php?error=1");
    }else if(mysqli_num_rows($verificarUsuario)>0){
        header("location:index.php?error=4");
    }else{
        $insertar=mysqli_query($conexion,"INSERT INTO usuarios(idusuario,nombre_usuario,mail,contrasenia,idestado) VALUES (00,'$usuario','$mail','$contrasenia',1)");
        $idusuario = mysqli_insert_id($conexion);
        $insergrupo=mysqli_query($conexion,"INSERT INTO grupo_usuarios(idgrupo,idusuario) SELECT (SELECT idgrupo FROM grupo WHERE nombre_grupo='cliente'),$idusuario");
        header("location:index.php?estado=1");
    }
}

?>