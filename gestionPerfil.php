<?php 
require("header.php");
$select3=mysqli_query($conexion,"SELECT idpais,nombre FROM paises ORDER BY nombre ASC");
$selectProvincias=mysqli_query($conexion,"SELECT idprovincia,nombre_provincia FROM provincias ORDER BY nombre_provincia ASC");
?>
<!DOCTYPE html>
<html>

<head>
<title>Inicio de afl cinema</title>
    
</head>

<body>
<script language="javascript">
 	$(document).ready(function(){
 		$("#cbxpais").change(function () {	
 			$("#cbxpais option:selected").each(function () {
                 id= $(this).val();
 				 $.post("includes/obtenerProvincias.php", { id: id }, function(data){
 					$("#cbxprovincia").html(data);
 				});             
 			});
 		});
     $("#cbxprovincia").change(function () {	
 			$("#cbxprovincia option:selected").each(function () {
 				id_ciudad = $(this).val();
 				 $.post("includes/obtenerCiudad.php", { id_ciudad: id_ciudad }, function(data){
 					$("#cbxciudad").html(data);
 				});           
 			});
 		});
 	});
 	
	
	
 </script>
 <?php 
       $select4=mysqli_query($conexion,"SELECT * FROM usuarios WHERE idusuario={$_SESSION['login']}");
       $datos=mysqli_fetch_assoc($select4);
       $select5=mysqli_query($conexion,"SELECT p.idpais FROM paises AS p
                                        JOIN provincias AS pr ON pr.idpais=p.idpais
                                        JOIN ciudades AS c ON c.idprovincia=pr.idprovincia
                                        JOIN usuarios AS u ON u.idciudad=c.idciudad
                                        WHERE u.idusuario={$_SESSION['login']}");
       $datosPais=mysqli_fetch_assoc($select5);
       $select6=mysqli_query($conexion,"SELECT pr.idprovincia FROM provincias AS pr
                                        JOIN ciudades AS c ON c.idprovincia=pr.idprovincia
                                        JOIN usuarios AS u ON u.idciudad=c.idciudad
                                        WHERE u.idusuario={$_SESSION['login']}");
    $datosProvincia=mysqli_fetch_assoc($select6);
?>

<div class="container"  style="padding-top:100px;">
    <div style="background:#212121; border-radius:30px;">
    <H1 align="center" class="text-white">Perfil</H1>
    <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
                echo "<div class='alert alert-success'>Perfil modificado con exito!!</div>";
            }
            if (isset($_GET['error'])&& $_GET['error']==1) {
                echo "<div class='alert alert-success'>Contraseña incorrecta!!</div>";
            }
            if (isset($_GET['estado'])&& $_GET['estado']==2) {
                echo "<div class='alert alert-success'>Contraseña modificada con exito!!</div>";
            }?>
        <div class="px-lg-5 py-lg-4 p-4">
            <form action="abm_gestionPerfil.php" method ="POST" style="width:95%;">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label font-weight-bold text-white">Nombre</label>
                        <input value="<?php if(mysqli_num_rows($select4)>0){ echo $datos['nombre'];}?>" type="text"class="form-control bg-dark-x border-0" placeholder="Nombre" id="nombre_usuario" name ="nombre_usuario" onkeypress="return check(event)"/>
                    </div>
                    <div class="col-6">
                        <label class="form-label font-weight-bold text-white">Apellido</label>
                        <input value="<?php if(mysqli_num_rows($select4)>0){ echo $datos['apellido'];}?>" type="text"class="form-control bg-dark-x border-0" placeholder="Apellido" id="apellido" name ="apellido" onkeypress="return check(event)"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label font-weight-bold text-white">Tipo de Documento</label>
                        <select name="idtipodocumento" id="idtipodocumento" class="form-control" >
                            <option>Seleccione Tipo documentación</option>
                            <?php $selectEstado=mysqli_query($conexion,"SELECT * FROM documento_tipos ORDER BY idtipodocumento ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>
                                    <option value="<?php echo $r['idtipodocumento'];?>" <?php if(mysqli_num_rows($select4)>0){ if($r['idtipodocumento']==$datos['idtipodocumento']){echo "selected";}}?>><?php echo $r['nombre_documento'];?></option>
                                <?php }?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label font-weight-bold text-white">Número de Documento</label>
                        <input value="<?php if(mysqli_num_rows($select4)>0){ echo $datos['numero_documento'];}?>" type="text"class="form-control bg-dark-x border-0" placeholder="Número de Documento" id="numero_documento" name ="numero_documento" required onkeyup="this.value=Numeros(this.value)"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label font-weight-bold text-white">Género</label>
                        <select name="sexo" id="sexo" class="form-control" >
                            <option>Seleccione Género</option>
                            <?php $selectEstado=mysqli_query($conexion,"SELECT * FROM generos ORDER BY idgenero ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>
                                    <option value="<?php echo $r['idgenero'];?>" <?php if(mysqli_num_rows($select4)>0){ if($r['idgenero']==$datos['idgenero']){echo "selected";}}?>><?php echo $r['nombre'];?></option>
                                <?php }?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label font-weight-bold text-white">Número de Teléfono</label>
                        <input value="<?php if(mysqli_num_rows($select4)>0){ echo $datos['telefono'];}?>" type="text"class="form-control bg-dark-x border-0" placeholder="Número de Teléfono" id="telefono" name ="telefono" onkeyup="this.value=NumerosTel(this.value)" />
                    </div>
                    <div class="col-6">
                        <label class="form-label font-weight-bold text-white">Mail</label>
                        <input value="<?php if(mysqli_num_rows($select4)>0){ echo $datos['mail'];}?>" type="mail" class="form-control bg-dark-x border-0" placeholder="Mail" id="mail" name ="mail"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label font-weight-bold text-white">País</label>
                        <select class="form-control" id="cbxpais" name="cbxpais">
               	            <option>Seleccione País</option>
                            <?php while ($rsTP = $select3->fetch_assoc()){?>
                                <option <?php if(mysqli_num_rows($select5)>0){ if($rsTP['idpais']==$datosPais['idpais']){echo "selected";}}?>><?php echo $rsTP['nombre'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label font-weight-bold text-white">Provincia</label>
                        <select name="cbxprovincia" id="cbxprovincia" class="form-control" >
                        <?php 
                                if(mysqli_num_rows($select6)>0){
                                while ($rsTP = $selectProvincias->fetch_assoc()){?>
                                <option <?php if($rsTP['idprovincia']==$datosProvincia['idprovincia']){echo "selected";}?>><?php echo $rsTP['nombre_provincia'];?></option>
                        <?php    }
                                }else{?>
                                <option>Seleccione Provincia</option>
                    <?php    }
                    ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label font-weight-bold text-white">Ciudad</label>
                        <select name="cbxciudad" id="cbxciudad" class="form-control" >
                                <option>Seleccione Ciudad</option>
                                <?php $selectEstado=mysqli_query($conexion,"SELECT * FROM ciudades ORDER BY idciudad ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>
                                    <option value="<?php echo $r['idciudad'];?>" <?php if(mysqli_num_rows($select4)>0){ if($r['idciudad']==$datos['idciudad']){echo "selected";}}?>><?php echo $r['nombre_ciudad'];?></option>
                                <?php }?>
                        </select>
                    </div>
                    <div>
                        <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="guardarPerfil" name="guardarPerfil"><i class="fas fa-save"></i> Guardar Usuario</button>
                    </div>
            </form>
            <div class="form-group col-md-4">
            </div>
                <div>
                    <a class="btn btn-dark" href="#" data-toggle="modal" data-target="#contra">Cambiar Contraseña</a>
                    <!--<a  class="btn btn-dark" style="margin-top: 3%;width: 100%;" href="#" data-toggle="modal" data-target="#contrasenia"><i class="fas fa-save"></i> Cambiar contraseña</a>-->
                </div>
            </div>          
        </div>
    </div>
    <div data-backdrop="static" class="modal fade" id="contra">
        <div class="col-md-12 modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cambiar Contraseña</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>
                <div class="col-md-12" style="background:#e0e0e0">
                    <div class="modal-body">
                        <form action="abm_usuario.php" method="POST">
                            <div class="form-group" id="password-group">
                                <label for="contra">Contraseña</label>
                                <input type="password" class="form-control" name="contrasenia" id="contrasenia" onkeypress="return check(event)" placeholder="Ingrese su contraseña" require>
                                <input type="text" cñass="form-control" name="id" id="id" value="<?php echo $_SESSION['login'];?>" hidden>
                            </div>
                            <div align="center" class="form-group">
                                <button style="margin-top:7%;width:50%" name="Enviar" value="Enviar" type="submit" class="btn btn-light">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <script>

function Numeros(string){
    var out = '';
    ok=true;
    var filtro = '1234567890';
    for (var i=0; i<8; i++)
       if (filtro.indexOf(string.charAt(i)) != -1)
	     out += string.charAt(i);
    
         return out;
}
function NumerosTel(string){
    var out = '';
    ok=true;
    var filtro = '1234567890';
    for (var i=0; i<10; i++)
       if (filtro.indexOf(string.charAt(i)) != -1)
	     out += string.charAt(i);
    
         return out;
}
function filterFloat(evt,input){
        var key = window.Event ? evt.which : evt.keyCode;    
        var chark = String.fromCharCode(key);
        var tempValue = input.value+chark;
        if(key >= 48 && key <= 57){
            if(filter(tempValue)=== false){
                return false;
            }else{       
                return true;
            }
        }else{
              if(key == 8 || key == 13 || key == 0) {     
                  return true;              
              }else if(key == 46){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
              }else{
                  return false;
              }
        }
    }
    function filter(__val__){
        var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        if(preg.test(__val__) === true){
            return true;
        }else{
           return false;
        }
        function check(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            //Tecla de retroceso para borrar, siempre la permite
            if (tecla == 8) {
                return true;
            }

            // Patron de entrada, en este caso solo acepta numeros y letras
            patron = /[A-Za-z0-9_-]/;
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
        }
        
    }

    </script>
</body>
</html>