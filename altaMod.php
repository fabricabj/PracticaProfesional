
<!DOCTYPE html>
 <html>
   <head>
    <title><?php if (isset($_POST['titulo'])) { echo "Modificar Pelicula";}else{echo "Alta Pelicula";}?></title> 
   </head>
   <body>
   <?php require ("header.php");
   require ("conexion.php");
  ?>
    <div class="container" style="padding-top:40px;">
		<div class="row">
        
            <div align="center" class="col-md-12 altamod">
            <?php 
                 if (isset($_POST['titulo'])) {
                      $titulo=$_POST['titulo'];
                      $consulta="SELECT * FROM peliculas WHERE titulo='$titulo'";
                      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM peliculas WHERE titulo='$titulo'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      }  
                      $resultado=mysqli_query($conexion,$consulta);
                      $datos_generos=mysqli_fetch_assoc($resultado);
                      $generos=explode(' ', $datos_generos['categorias']);
                      $rta=in_array(' ',$generos);
                  ?>
                       <form method="POST" action="ABM.php" style="width:70%;">
                         <div class="form-row">
                             <div class="form-group col-md-8">
                                <label>Titulo</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $datos_generos['titulo'];?>" required>
                                <input type="text" class="form-control" name="titulo_anterior" id="titulo_anterior" value="<?php echo $datos_generos['titulo'];?>" hidden>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="inputPassword4">Año</label>
                                  <input type="text" class="form-control" value="<?php echo $datos_generos['anio'];?>" name="anio" id="anio">
                              </div>
                         </div>
                         <div class="form-row">
                             <div class="form-group col-md-8">
                                <label>Duracion</label>
                                <input type="text" class="form-control" name="duracion" id="duracion" value="<?php echo $datos_generos['duracion'];?>" required>
                             </div>
                             <div class="form-group col-md-4">
                                <label for="inputPassword4">Puntaje</label>
                                <input type="text" class="form-control" name="puntaje" id="puntaje" value="<?php echo $datos_generos['puntaje'];?>" required>
                               
                             </div>
                         </div>
                           <div class="form-row">
                              <div class="form-group col-md-8">
                                 <label>imagen</label>
                                 <input type="text" class="form-control" value="<?php echo $datos_generos['imagen'];?>" name="imagen" id="imagen" required>
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputPassword4">Precio</label>
                                <input type="text" class="form-control" name="precio" id="precio" value="<?php echo $datos_generos['precio'];?>" required>
                             </div>
                          </div>
                          <div class="form-row">
                             <div class="form-group col-md-8">
                                <label for="inputPassword4">fecha de publicacion</label>
                                <input type="date" class="form-control" name="fecha_publicacion" id="fecha_publicacion" value="<?php echo $datos_generos['fecha_publicacion'];?>" required>
                             </div>
							<div class="form-group col-md-4">
								<label>estado</label>
								<select name="estado" class="form-control" >
									
									<?php $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM pelicula_estados ORDER BY descripcion ASC");
									while($r=mysqli_fetch_array($selectEstado)){?>
										
										<option value="<?php echo $r['idestado'];?>" <?php  if($idTipoEstado==$r['idestado']){ echo'selected';}?>><?php echo $r['descripcion'];?></option>
									<?php }?>
								</select>
							</div>
						 </div>
                         <div class="form-group">
                            <label>Descripcion</label>
                            <textarea type="text" class="form-control" name="descripcion" id="descripcion" rows="3"><?php echo $datos_generos['descripcion'];?></textarea>
                         </div>
                         <p style="color:#fafafa;float:left">Generos</p><br>
                         <div class="form-row"  style="border: 1px solid white;color:#fafafa;padding-top:20px;float:left;width:100%">
                             <div class="form-group">
                                <label class="checkbox">
                                    Fantasia
                                    <input type="checkbox" name="nombre_genero[]" value="Fantasia" <?php if(in_array('Fantasia',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Terror
                                    <input type="checkbox" name="nombre_genero[]" value="Terror" <?php if(in_array('Terror',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Accion
                                   <input type="checkbox" name="nombre_genero[]" value="accion" <?php if(in_array('accion',$generos)){?> checked <?php }?>>
                                   <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Drama
                                    <input type="checkbox" name="nombre_genero[]" value="Drama" <?php if(in_array('Drama',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Comedia
                                    <input type="checkbox" name="nombre_genero[]" value="Comedia" <?php if(in_array('Comedia',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    SCI-FI
                                    <input type="checkbox" name="nombre_genero[]" value="SCI-FI" <?php if(in_array('SCI-FI',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Aventura
                                    <input type="checkbox" name="nombre_genero[]" value="Aventura" <?php if(in_array('Aventura',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Crimen
                                    <input type="checkbox" name="nombre_genero[]" value="Crimen" <?php if(in_array('Crimen',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Romance
                                    <input type="checkbox" name="nombre_genero[]" value="Romance" <?php if(in_array('Romance',$generos)){?> checked <?php }?>>
                                    <span class="check"></span>
                                </label>
                             </div>
                         </div>   
                         <div class="form-group">
                             <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="Modificar" name="Modificar"><i class="fas fa-save"></i> Guardar</button>
                             <button style="margin-top: 3%;width: 100%;" class="btn btn-dark"><a style="text-decoration: none;color: white;" href="javascript:history.go(-1)"><i class="fas fa-ban"></i> Cancelar</a></button>
                         </div>
                       </form>
                      <?php 
                  }
                 if(isset($_POST['alta']) && !empty($_POST['alta'])){ ?>
                    
                    <form method="POST" action="ABM.php" style="width:70%;">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                               <label for="inputEmail4">Titulo</label>
                               <input type="text" class="form-control" name="titulo" id="titulo" required placeholder="ingrese nombre de la pelicula">
                            </div>
                            <div class="form-group col-md-4">
                               <label for="inputPassword4">año</label>
                               <input type="text" class="form-control" name="anio" id="anio" required placeholder="ingrese solo numeros enteros" onkeyup="this.value=Numeros(this.value)">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                               <label for="inputPassword4">Duracion</label>
                               <input type="text" class="form-control" name="duracion" id="duracion" required placeholder="ingrese duracion en minutos" onkeyup="this.value=Numeros(this.value)">
                            </div>
                            <div class="form-group col-md-4">
                               <label for="inputPassword4">Puntaje</label>
                               <input type="text" class="form-control" name="puntaje" id="puntaje" required placeholder="ingrese solo numeros" onkeypress="return filterFloat(event,this);">
                            </div>
                        </div>
                        <div class="form-row">       
                                <div class="form-group col-md-8">
                                    <label for="inputEmail4">imagen</label>
                                    <input type="text" class="form-control" name="imagen" id="imagen" required placeholder="ingrese link de la imagen">
                                </div>
                                <div class="form-group col-md-4">
                                        <label for="inputPassword4">Precio</label>
                                        <input type="text" class="form-control" name="precio" id="precio" required>
                                </div>
                        </div>
                        <div class="form-row">
                             <div class="form-group col-md-8">
                                <label for="inputPassword4">fecha de publicacion</label>
                                <input type="date" class="form-control" name="fecha_publicacion" id="fecha_publicacion" required>
                             </div>
							<div class="form-group col-md-4">
								<label>estado</label>
								<select name="estado" class="form-control" >
									
									<?php $selectEstado=mysqli_query($conexion,"SELECT descripcion FROM pelicula_estados ORDER BY descripcion ASC");
									while($r=mysqli_fetch_array($selectEstado)){?>
										
										<option><?php echo $r['descripcion'];?></option>
									<?php }?>
								</select>
							</div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Descripcion</label>
                            <textarea type="text" class="form-control" name="descripcion" id="descripcion" required placeholder="ingrese descripcion de la pelicula"></textarea>
                        </div>
                        <p style="color:#fafafa;float:left">Generos</p><br>
                        <div class="form-row"  style="border: 1px solid white;padding-top:20px;color:#fafafa;float:left;width:100%">
                            <div class="form-group generos">
                                <label class="checkbox">
                                    Fantasia
                                    <input type="checkbox" name="nombre_genero[]" value="Fantasia">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Terror
                                    <input type="checkbox" name="nombre_genero[]" value="Terror">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Accion
                                    <input type="checkbox" name="nombre_genero[]" value="accion">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Drama
                                    <input type="checkbox" name="nombre_genero[]" value="Drama">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Comedia
                                    <input type="checkbox" name="nombre_genero[]" value="Comedia">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    SCI-FI
                                    <input type="checkbox" name="nombre_genero[]" value="SCI-FI">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Aventura
                                    <input type="checkbox" name="nombre_genero[]" value="Aventura">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Crimen
                                    <input type="checkbox" name="nombre_genero[]" value="Crimen">
                                    <span class="check"></span>
                                </label>
                                <label class="checkbox">
                                    Romance
                                    <input type="checkbox" name="nombre_genero[]" value="Romance">
                                    <span class="check"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="guardar" name="guardar"><i class="fas fa-save"></i> Guardar</button>
                            <button style="margin-top: 3%;width: 100%;" class="btn btn-dark"><a style="text-decoration: none;color: white;" href="javascript:history.go(-1)"><i class="fas fa-ban"></i> Cancelar</a></button>
                        </div>
                    </form>
                    <?php
                  }

 ?>
 </div>
               
</div>
</div>
    <script>

function Numeros(string){
    var out = '';
    ok=true;
    var filtro = '1234567890';
    for (var i=0; i<4; i++)
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
        
    }

    </script>
   </body>
</html>