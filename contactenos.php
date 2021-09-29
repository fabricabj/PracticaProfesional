<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./estilos.css">
    <title>Contáctenos</title>
</head>

<body>
    <?php
    require("header.php");
    ?>

    <div class="container">
        <div class="row justify-content-around mt-3">
            <div class="col-12">
                <p class="text-center descripNos">Nosotros</p>
            </div>
            <div class="card col-3" style="width: 18rem; background-color: #212121">
                <img src="./imagenes/aye.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text descrip text-center">
                        <b>Ayelén Calissi</b>
                    </p>
                    <p class="card-text descrip">
                        <i>Estudiante del Instituto tecnológico Beltrán, Desarrolladora Software, y fan de los gatitos</i></br>
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
                        <i>Estudiante del Instituto tecnológico Beltrán, curo el empacho online</i>
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
                        <i>Estudiante del Instituto tecnológico Beltrán, cerrajero en Aldo Bonzi</i>
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
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#sugerencia">Sugerencia</button>
        </div>
    </div>
    <div class="modal fade" id="contactar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="input" class="form-control" id="asunto" placeholder="Asunto">
                        </div>
                        <div class="form-group">
                            <label for="mail">Email</label>
                            <input type="email" class="form-control" id="mail" placeholder="nombre@ejemplo.com">
                        </div>
                        <div class="form-group">
                            <label for="txtarea">Mensaje</label>
                            <textarea class="form-control" id="txtarea" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sugerencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sugerencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="txtarea1">Mensaje</label>
                            <textarea class="form-control" id="txtarea1" maxlength="99" placeholder="Agreguen Buscando a Nemo, please!" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>