 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    body{
        background: url('fondo.jpg') no-repeat fixed center;
        -webkit-background-size:cover;
        -moz-background-size:cover;
        -o-background-size:cover;
        background-size:cover;
        width: 100%;
        height: 100%;
        text-align: center;
    }
    
</style>
<title>Inicio Peliculas AFL cinema</title>
</head>
<body>
<?php
    require("header.php");
    require("conexion.php");
    ?>
     <div class="container">
       <div class="row">
        <?php if(isset($_GET['token']) && !isset($_GET['estado'])){
            $token=$_GET['token'];
            $select=mysqli_query($conexion,"SELECT * FROM usuarios WHERE token='$token'");
            if($r=mysqli_fetch_array($select)){
                  $update=mysqli_query($conexion,"UPDATE usuarios SET token= null WHERE idusuario={$r['idusuario']}");?>
                  <div class="col-md-12 form" align="center">
                       <form action="recuperar.php?idusuario=<?php echo $r['idusuario'];?>&cambiar" method="POST" onsubmit="return form(this)" style="width:50%" class="rp">
                            <div class="form-row">
                               <div class="form-group col-md-12">
                                  <label for="inputEmail4">Contraseña nueva</label>
                                  <input type="password" class="form-control" name="contr" id="contr" placeholder="ingrese su contraseña nueva">
                               </div>
                               <div class="form-group col-md-12">
                                  <label for="inputPassword4">Repetir contraseña</label>
                                  <input type="password" class="form-control" id="contr2" placeholder="Repetir contraseña">
                               </div>
                            </div>
                            <button  class="btn btn-dark" style="width: 100%;" onclick="form()"><i class="fas fa-save"></i> Restablecer contraseña</button>
                       </form>
                  </div>
        <?php
          } 
        }
         if(isset($_GET['idusuario']) && isset($_GET['cambiar'])){
            $id=$_GET['idusuario'];
            $password=sha1($_POST['contr']);
            $actualizar=mysqli_query($conexion,"UPDATE usuarios SET contrasenia='$password',token=null WHERE idusuario='$id'");
            header('location:index.php');
           
         }?>
 </body>
</html>