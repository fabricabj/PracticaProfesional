
<!DOCTYPE html>
 <html>
   <head>
    <title><?php if (isset($_POST['idnoticia'])) { echo "Modificar Noticia";}else{echo "Alta Noticia";}?></title> 
   </head>
   <body>
   <?php require ("header.php");
   require ("conexion.php");

  ?>
    <div class="container" style="padding-top:40px;">
		<div class="row">
        
            <div align="center" class="col-md-12 altamod">
            <?php 
                 if (isset($_POST['idnoticia'])) {
                      $idnoticia=$_POST['idnoticia'];
                      $consulta="SELECT * FROM noticias WHERE idnoticia='$idnoticia'";
                      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM noticias WHERE idnoticia='$idnoticia'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      }  
                      $resultado=mysqli_query($conexion,$consulta);
                      $datos=mysqli_fetch_assoc($resultado);
                      //$generos=explode(' ', $datos_generos['categorias']);
                      //$rta=in_array(' ',$generos);
                  ?>
                       <form method="POST" action="abm_noticias.php" style="width:70%;">
                         <div class="form-row">
                             <div class="form-group col-md-4">
                                <label>Titulo</label>
                                <input type="text" class="form-control" name="nombre_noticia" id="nombre_noticia" value="<?php echo $datos['nombre_noticia'];?>">
                                <input type="text" class="form-control" name="nombre_anterior" id="nombre_anterior" value="<?php echo $datos['nombre_anterior'];?>" hidden>
                            </div>
                         </div>
                           <div class="form-row">
                              <div class="form-group col-md-4">
                                 <label>Imágen</label>
                                 <input type="text" class="form-control" value="<?php echo $datos['imagen'];?>" name="imagen" id="imagen" required>
                              </div>
                          </div>
                          <div class="form-row">
                             <div class="form-group">
                             <label for="inputPassword4">Fecha</label>
                                <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $datos['fecha'];?>" required>
                            </div>
                         </div>
                          <div class="form-row">
                             
							<div class="form-group col-md-4">
								<label>Estado</label>
								<select name="estado" class="form-control" >
									
									<?php $selectEstado=mysqli_query($conexion,"SELECT idestado FROM estados_noticias ORDER BY idestado ASC");
									while($r=mysqli_fetch_array($selectEstado)){?>
										
										<option value="<?php echo $r['idestado'];?>" <?php  if($idTipoEstado==$r['idestado']){ echo'selected';}?>><?php echo $r['idestado'];?></option>
									<?php }?>
								</select>
							</div>
						 </div>
                         <div class="form-group">
                            <label>Descripción</label>
                            <textarea type="text" class="form-control" name="descripcion" id="descripcion" rows="5"><?php echo $datos['descripcion'];?></textarea>
                         </div>                
                         <div class="form-group">
                             <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="Modificar" name="Modificar"><i class="fas fa-save"></i> Guardar Noticia</button>
                             <button style="margin-top: 3%;width: 100%;" class="btn btn-dark"><a style="text-decoration: none;color: white;" href="javascript:history.go(-1)"><i class="fas fa-ban"></i> Cancelar</a></button>
                         </div>
                       </form>
                      <?php 
                  }
                 if(isset($_POST['alta']) && !empty($_POST['alta'])){ ?>
                    
                    <form method="POST" action="abm_noticias.php" style="width:70%;">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                               <label for="inputEmail4">Título</label>
                               <input type="text" class="form-control" name="nombre_noticia" id="nombre_noticia" required placeholder="Ingrese título">
                            </div>
                            <div class="form-group col-md-4">
								<label>Estado</label>
								<select name="estado" class="form-control" >
									
									<?php $estado=mysqli_query($conexion,"SELECT idestado FROM estados_noticias ORDER BY idestado ASC");
									while($r=mysqli_fetch_array($estado)) { ?>
										
										<option> <?php echo $r['idestado'];?>  </option>
									<?php }?>
								
                                
                                </select>
							</div>
                        </div>                     
                        <div class="form-row">       
                                <div class="form-group col-md-8">
                                    <label for="inputEmail4">Imágen</label>
                                    <input type="text" class="form-control" name="imagen" id="imagen" required placeholder="Ingrese link de la imágen">
                                </div>
                                <div class="form-group col-md-4">
								<label>Proveedor</label>
								<select id="idproveedor" name="idproveedor" class="form-control" >
									
									<?php $selectProveedor=mysqli_query($conexion,"SELECT idproveedor FROM proveedores ORDER BY idproveedor ASC");
									while($r=mysqli_fetch_array($selectProveedor)){?>
										
										<option><?php echo $r['idproveedor'];?></option>
									<?php }?>
								</select>
							</div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword4">Fecha</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" required>                          
                        </div>
                        
                        <div class="form-group">
                            <label for="inputEmail4">Descripción</label>
                            <textarea type="text" class="form-control" name="descripcion" id="descripcion" required placeholder="Descripción"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="guardarNoticia" name="guardarNoticia"><i class="fas fa-save"></i> Guardar Noticia</button>
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