<?php
require("conexion.php");
if(isset($_POST['alta']) && !empty($_POST['alta'])){
		$nombreGrupo=$_POST['nombreGrupo'];
		$nombrePermiso=$_POST['nombrePermiso'];
		$insert=mysqli_query($conexion,"INSERT INTO grupo VALUES(00,'$nombreGrupo')");
		$select=mysqli_query($conexion,"SELECT idgrupo FROM grupo WHERE nombre_grupo='$nombreGrupo'");
		while($r=mysqli_fetch_array($select)){$idGrupo=$r['idgrupo'];}
		if(!empty($nombrePermiso)){
			foreach($_POST['nombrePermiso'] as $selected){
				$select2=mysqli_query($conexion,"SELECT idpermiso FROM permisos_usuarios WHERE nombre_permiso='$selected'");
				while($r=mysqli_fetch_array($select2)){$idPermiso=$r['idpermiso'];}
				$insert2=mysqli_query($conexion,"INSERT INTO grupos_permisos VALUES($idPermiso,$idGrupo)");
			}
			header("location:asignarpermisos.php?estado=1");
		}
}
if(isset($_POST['modificar']) && !empty($_POST['modificar'])){
	$nombreGrupo=$_POST['nombreGrupo'];
	$idGrupo=$_POST['idgrupo'];
	$update=mysqli_query($conexion,"UPDATE grupo SET nombre_grupo = '$nombreGrupo' WHERE idgrupo=$idGrupo");
	$delete=mysqli_query($conexion,"DELETE FROM grupos_permisos WHERE idgrupo=$idGrupo");    
	foreach($_POST['idPermiso'] as $selected){
		$insert=mysqli_query($conexion,"INSERT INTO grupos_permisos VALUES($selected,$idGrupo)");
	}
	header("location:listarPermisos.php?estado=1");
	
}

if(isset($_POST['baja']) && !empty($_POST['baja'])){
	$idGrupo=$_POST['idgrupo'];
	
	$delete1=mysqli_query($conexion,"DELETE FROM grupos_permisos WHERE idgrupo=$idGrupo");
	$delete2=mysqli_query($conexion,"DELETE FROM grupo_usuarios WHERE idgrupo=$idGrupo");
	$delete3=mysqli_query($conexion,"DELETE FROM grupo WHERE idgrupo=$idGrupo");
		  
	header("location:listarPermisos.php?estado=2");
}
?>