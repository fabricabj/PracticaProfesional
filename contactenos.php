<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./estilos.css">
    <title>Contáctenos</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <?php
    require("header.php");
    ?>
    

    <div class="container">
        <div class="row justify-content-around mt-3">
            <div class="col-12">
                <p class="text-center descripNos">Nosotros</p>
                <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
                    echo "<div class='alert alert-success'>Sugerencia enviada con exito!!</div>";
                }
                if (isset($_GET['estado'])&& $_GET['estado']==2) {
                    echo "<div class='alert alert-success'>Mail enviado con exito!!</div>";
                }
                if (isset($_GET['error'])&& $_GET['error']==1) {
                    echo "<div class='alert alert-success'>verifique el capchat!!</div>";
                }
                if (isset($_GET['error'])&& $_GET['error']==2) {
                    echo "<div class='alert alert-success'>No se a podido enviar el correo!!</div>";
                }?>
            </div>
            <div class="card col-3" style="width: 18rem; background-color: #212121">
                <img src="./imagenes/aye.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text descrip text-center">
                        <b>Ayelén Calissi</b>
                    </p>
                    <p class="card-text descrip">
                        <i>Estudiante del Instituto Tecnológico Beltrán, Desarrolladora Software</i></br>
                    </p>
                    <p class="card-text">
                        <i class="fab fa-github fa-lg" style="color:#FFF"> </i>
                        <a href="https://github.com/ayelencalissi" target="_blank" style="text-decoration:none;">AyelenCalissi</a>
                    </p>
                    <p>
                        <i class="fab fa-instagram fa-lg" style="color:#c32aa3"></i>
                        <a href="https://instagram.com/ayelencalissi" target="_blank" style="text-decoration:none;">@AyelenCalissi</a>
                    </p>
                </div>
            </div>
            <div class="card col-3" style="width: 18rem; background-color: #212121">
                <img src="./imagenes/leo.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text descrip text-center">
                        <b>Leonel Girett</b>
                    </p>
                    <p class="card-text descrip">
                        <i>Estudiante del Instituto Tecnológico Beltrán, Desarrollador Software</i>
                    </p>
                    <p class="card-text">
                        <i class="fab fa-github fa-lg" style="color:#FFF"> </i>
                        <a href="https://github.com/leonel1414" target="_blank" style="text-decoration:none;">Leonel1414</a>
                    </p>
                    <p>
                        <i class="fab fa-instagram fa-lg" style="color:#c32aa3"></i>
                        <a href="https://instagram.com/leo.girett" target="_blank" style="text-decoration:none;">@Leo.girett</a>
                    </p>
                </div>
            </div>
            <div class="card col-3" style="width: 18rem; background-color: #212121">
                <img src="./imagenes/franco.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text descrip text-center">
                        <b>Franco Colavella</b>
                    </p>
                    <p class="card-text descrip">
                        <i>Estudiante del Instituto Tecnológico Beltrán, Desarrollador Software</i>
                    </p>
                    <p class="card-text">
                        <i class="fab fa-github fa-lg" style="color:#FFF"> </i>
                        <a href="https://github.com/FrancoColavella" target="_blank" style="text-decoration:none;">FrancoColavella</a>
                    </p>
                    <p>
                        <i class="fab fa-instagram fa-lg" style="color:#c32aa3"></i>
                        <a href="https://instagram.com/francobodier_lt" target="_blank" style="text-decoration:none;">@Francobodier_lt</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <button type="button" class="btn btn-dark mr-5" data-toggle="modal" data-target="#contactar">Contactar</button>

                        <?php
                        if(isset($_SESSION['login'])){
                             $idgrupo=$_SESSION['grupo'];
                                $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                                while($rs=mysqli_fetch_array($permisos)){
                                    $nombrePermiso=$rs['nombre_permiso'];
                                    switch($nombrePermiso) {
                                        case "alta sugerencias": ?>     
                                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#sugerencia">Sugerencia</button>
                        <?php        break;
                                    }
                                    } 
                                }?>
        </div>
    </div>
    <div class="modal fade" id="contactar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario de contactó</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="mailcontacto.php">
                    <div class="modal-body">                    
                            <div class="form-group">
                                <label for="asunto">Asunto</label>
                                <input type="input" class="form-control" name="asunto" id="asunto" placeholder="Asunto" required>
                            </div>
                            <div class="form-group">
                                <label for="mail">Email</label>
                                <input type="email" class="form-control" name="mail" id="mail" placeholder="nombre@ejemplo.com" required>
                            </div>
                            <div class="form-group">
                                <label for="mensaje">Mensaje</label>
                                <textarea class="form-control" name="mensaje" id="mensaje" rows="3" required></textarea> 
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LeDXT8dAAAAAOpD-ZH499PkUdjtyJUeImuiVG1r"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button value="enviarMail" name="enviarMail" class="btn btn-primary" >Enviar</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sugerencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario de sugerencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="abm_sugerencia.php">
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <label for="txtarea1">Mensaje</label>
                                <textarea class="form-control" id="descripcion" name ="descripcion" maxlength="99" placeholder="Agregue alguna sugerencia !" rows="3"></textarea>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button value="guardarSugerencia" name="guardarSugerencia" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>


</html>