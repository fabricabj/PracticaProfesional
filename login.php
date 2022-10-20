<?php
session_start();
require("conexion.php");
if (isset($_POST['ingresar']) && !empty($_POST['ingresar'])) {
	$usuario=$_POST['usuario'];
	$password=sha1($_POST['contrasenia']);
	$consulta= mysqli_query($conexion,"SELECT idusuario,nombre_usuario,contrasenia,idestado FROM usuarios where nombre_usuario='$usuario' and contrasenia='$password' LIMIT 1"); 
	if($p=mysqli_fetch_assoc($consulta)){
		if($p['idestado']==1){
			if ($p['nombre_usuario']==$usuario && $p['contrasenia']==$password) {

				$selectgrupo=mysqli_query($conexion,"SELECT idgrupo FROM grupo_usuarios WHERE idusuario='{$p['idusuario']}'");
				while($r=mysqli_fetch_array($selectgrupo)){
					$idgrupo=$r['idgrupo'];
				}
				
				$_SESSION['login']=$p['idusuario'];
				$_SESSION['usuario']=$p['nombre_usuario'];
				$_SESSION['grupo'] = $idgrupo;
				header("location:index.php");
			}else{ 
				header("location:index.php?error=2");
			}
		}else{
			header("location:index.php?error=3");
		}
	}else{
		header("location:index.php?error=2");
	}	
}
if (isset($_GET['recuperar'])&& $_GET['recuperar']==1){
			echo '<script> alert("Se ha enviado un mail a su correo con el link de restablecer contraseña");</script>';
			header("location:index.php");
		}
		if (isset($_GET['recuperar'])&& $_GET['recuperar']==2){
			echo '<script> alert("Problemas");</script>';
			header("location:index.php");
		}
		if (isset($_GET['recuperar'])&& $_GET['recuperar']==3){
			echo '<script> alert("El usuario no existe");</script>';
		}
		
 ?>