
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
                      $tipoproveedor=mysqli_query($conexion,"SELECT idproveedor FROM noticias WHERE idnoticia='$idnoticia'");
                      while($i=mysqli_fetch_array($tipoproveedor)){
                          $idTipoproveedor=$i['idproveedor'];
                      }  
                      $resultado=mysqli_query($conexion,$consulta);
                      $datos=mysqli_fetch_assoc($resultado);
                     
                  ?><h1 align="center" style="color:white">Editar noticia </h1>
                       <form method="POST" action="abm_noticias.php" enctype="multipart/form-data" style="width:70%;">
                         <div class="form-row">
                             <div class="form-group col-md-4">
                                <label>TÍtulo</label>
                                <input type="text" class="form-control" name="nombre_noticia" id="nombre_noticia" value="<?php echo $datos['nombre_noticia'];?>">
                            </div>
                         </div>
                         <div class="form-row">
                              <div class="form-group col-md-8">
                                 <label for="imagen">Imagen</label>
 					             <input type="file" name="imagen" class="form-control" id="imagen" >
                              </div>
                              <div class="form-group col-md-4">
                                  <img src="<?php echo "imagenes/". $datos["imagen"]; ?>" width =100>
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
								<select name="idestado" class="form-control" >
									
									<?php $selectEstado=mysqli_query($conexion,"SELECT descripcion,idestado FROM estados_noticias ORDER BY idestado ASC");
									while($r=mysqli_fetch_array($selectEstado)){?>
										
										<option value="<?php echo $r['idestado'];?>" <?php  if($idTipoEstado==$r['idestado']){ echo'selected';}?>><?php echo $r['descripcion'];?></option>
									<?php }?>
								</select>
							</div>
                            <div class="form-group col-md-4">
								<label>Proveedor</label>
								<select id="idproveedor" name="idproveedor" class="form-control" >
									
									<?php $selectProveedor=mysqli_query($conexion,"SELECT razon_social,idproveedor FROM proveedores ORDER BY idproveedor ASC");
									while($r=mysqli_fetch_array($selectProveedor)){?>
										
										<option value="<?php echo $r['idproveedor'];?>" <?php  if($idTipoproveedor==$r['idproveedor']){ echo'selected';}?>><?php echo $r['razon_social'];?></option>
									<?php }?>
								</select>
							</div>
						 </div>
                         <div class="form-group">
                            <label>Descripción</label>
                            <textarea type="text" class="form-control" name="descripcion" id="descripcion" rows="5"><?php echo $datos['descripcion'];?></textarea>
                         </div>                
                         <div class="form-group">
                             <input type="text" name="id" id="id" value="<?php echo $datos['idnoticia']; ?>" hidden>
                             <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="Modificar" name="Modificar"><i class="fas fa-save"></i> Guardar Cambios</button>
                         </div>
                       </form>
                      <?php 
                  }
                 if(isset($_POST['alta']) && !empty($_POST['alta'])){ ?>
                    <h1 align="center" style="color:white">Alta noticia </h1>
                    <form method="POST" action="abm_noticias.php" enctype="multipart/form-data" style="width:70%;">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                               <label for="inputEmail4">Título</label>
                               <input type="text" class="form-control" name="nombre_noticia" id="nombre_noticia" required placeholder="Ingrese título">
                            </div>
                            <div class="form-group col-md-4">
								<label>Estado</label>
								<select name="estado" class="form-control" >
									
									<?php $estado=mysqli_query($conexion,"SELECT descripcion,idestado FROM estados_noticias ORDER BY idestado ASC");
									while($r=mysqli_fetch_array($estado)) { ?>
										
										<option value="<?php echo $r['idestado'];?>"> <?php echo $r['descripcion'];?>  </option>
									<?php }?>
								
                                
                                </select>
							</div>
                        </div>                     
                        <div class="form-row">       
                                <div class="form-row">       
                                        <div class="form-group col-md-8">
                                            <label for="imagen">Imagen</label>
                                            <input type="file" name="imagen" class="form-control" id="imagen" >
                                        </div>
                                        
                                </div>
                                <div class="form-group col-md-4">
								<label>Proveedor</label>
								<select id="idproveedor" name="idproveedor" class="form-control" >
									
									<?php $selectProveedor=mysqli_query($conexion,"SELECT razon_social,idproveedor FROM proveedores ORDER BY idproveedor ASC");
									while($r=mysqli_fetch_array($selectProveedor)){?>
										
										<option value="<?php echo $r['idproveedor'];?>"><?php echo $r['razon_social'];?></option>
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

    </script>
   </body>
</html>