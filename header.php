<?php

require("conexion.php");

$id_usuario = 0;
$nombre_usuario = "";
session_start();
if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
    $id_usuario = $_SESSION['login'];
    $nombre_usuario = $_SESSION['usuario'];
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Inicio de AFL cinema</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">
    <style>
        .row {
            padding: 0px;
            margin: 0px;
        }

        .menu a {
            color: white;
            text-decoration: none;
        }

        .login li {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12" style="background:#121212">
            <div class="row contBackHeader">
                <div class="col-md-3" style="padding-top:15px"><a class="navbar-brand" href="index.php"><img src="logo.png" style="width:200px;height: 70px;border-radius: 50px"></a>
                </div>
                <div class="col-md-9" style="padding-top:15px;">
                    <nav class="navbar navbar-expand-lg " style="float:right">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto login">
                                <?php if ($id_usuario == 0) : ?>
                                    <li class="nav-item active">
                                        <a class="btn btn-dark" href="#" data-toggle="modal" data-target="#ingresar" onclick="ingresar();">Iniciar Sesión</a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="btn btn-dark" href="#" data-toggle="modal" data-target="#registrar" onclick="registrar();">Registrate</a>
                                    </li>
                                <?php else : ?>

                                    <li class="nav-item">
                                        <a class="btn btn-light user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-user-alt"></i> <?php echo $nombre_usuario; 
                                                 $consul1=mysqli_query($conexion,"SELECT * FROM comprobantes WHERE idestado=3");
                                                 $consul2=mysqli_query($conexion,"SELECT * FROM sugerencias WHERE idestado=2");
                                                            if(mysqli_num_rows($consul1)>0 || mysqli_num_rows($consul2)>0){?>
                                                                <i class='fa fa-exclamation-circle' style='color: red'></i>
                                                           <?php } ?> 
                                        </a>
                                                   
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <?php
                                            $idgrupo = $_SESSION['grupo'];
                                            $permisos = mysqli_query($conexion, "SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                                            while ($rs = mysqli_fetch_array($permisos)) {
                                                $nombrePermiso = $rs['nombre_permiso'];
                                                switch ($nombrePermiso) {
                                                    case "asignar permisos": ?>
                                                        <form method="POST" action="asignarpermisos.php">
                                                            <button type="submit" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-users'></i> Asignar Permisos</button>
                                                        </form>
                                                    <?php break;
                                                    case "buscar proveedores": ?>
                                                        <!--<form method="POST" action="proveedores.php">-->
                                                        <a href="proveedores.php?pagina=1&est=1" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-list-alt'></i> Listado Proveedores</a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "buscar noticias": ?>
                                                        <!--<form method="GET" action="listarNoticias.php?estado=1">-->
                                                            <a href="listarNoticias.php?pagina=1&est=1" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-list-alt'></i> Listado Noticias</a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "buscar pelicula": ?>
                                                        <!--<form method="POST" action="listarpeliculas.php">-->
                                                            <a href="listarpeliculas.php?pagina=1&est=1" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-list-alt'></i> Listado Películas</a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "buscar usuarios": ?>
                                                        <!--<form method="POST" action="listarUsuario.php">-->
                                                            <a href="listarUsuario.php?pagina=1&est=1" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-list-alt'></i> Listado Usuarios</a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "favoritos": ?>
                                                        <form method="POST" action="lista.php">
                                                            <button type="submit" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-heart'></i> Mis Favoritos</button>
                                                        </form>
                                                    <?php break;
                                                    case "gestion perfil": ?>
                                                        <form method="POST" action="gestionPerfil.php">
                                                            <button type="submit" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-address-card-o'></i> Gestionar Perfil</button>
                                                        </form>
                                                    <?php break;
                                                    case "listado comprobantes": ?>
                                                        <!--<form method="POST" action="listadocomprobante.php">-->
                                                            <a href="listadocomprobante.php?pagina=1&est=3" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-list-alt'></i> Listado Comprobantes
                                                            <?php $consul=mysqli_query($conexion,"SELECT * FROM comprobantes WHERE idestado=3");
                                                            if(mysqli_num_rows($consul)>0){?>
                                                                <i class='fa fa-exclamation-circle' style='color: red'></i>
                                                           <?php } ?>
                                                        </a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "buscar estrenos": ?>
                                                        <!--<form method="POST" action="listadoEstrenos.php">-->
                                                        <a href="listadoEstrenos.php?pagina=1&est=3" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-list-alt'></i> Listado Estrenos</a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "baja sugerencias": ?>
                                                        <!--<form method="POST" action="listadoSugerencia.php">-->
                                                        <a href="listadoSugerencia.php?pagina=1&est=2" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-list-alt'></i> Listado Sugerencias
                                                        <?php $consul=mysqli_query($conexion,"SELECT * FROM sugerencias WHERE idestado=2");
                                                            if(mysqli_num_rows($consul)>0){?>
                                                                <i class='fa fa-exclamation-circle' style='color: red'></i>
                                                           <?php } ?></a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "Mis compras": ?>
                                                        <!--<form method="POST" action="miscompras.php">-->
                                                        <a href="miscompras.php?pagina=1&est=1" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-shopping-basket'></i> Ver mis compras</a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "reporte ventas": ?>
                                                        <!--<form method="POST" action="reporteventa.php">-->
                                                        <a href="reporteventa.php?pagina=1&est=1" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-shopping-basket'></i> Ver ventas</a>
                                                        <!--</form>-->
                                                    <?php break;
                                                    case "ver estadisticas": ?>
                                                        <form method="POST" action="verEstadisticas.php">
                                                            <button type="submit" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item"><i class='fa fa-bar-chart-o'></i> Ver Estadísticas</button>
                                                        </form>
                                                    <?php break;
                                                }
                                            } ?>
                                            <form action="logout.php" method="POST">
                                                <button type="submit" onMouseover="this.style.background='#B7B7B7'" onMouseout="this.style.background='white'" class="dropdown-item" name="borrar"><i class='fa fa-sign-out'></i> Cerrar Sesión</button>
                                            </form>
                                        </div>
                                    </li>
                                <li>
                                <?php
                                        $idgrupo = $_SESSION['grupo'];
                                        $permisos2 = mysqli_query($conexion, "SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                                        while ($ss = mysqli_fetch_array($permisos2)) {
                                        $nombrePermiso1 = $ss['nombre_permiso'];
                                            switch ($nombrePermiso1) {
                                                case "comprar pelicula": ?>
                                                        <!--<form method="POST" action="carrito.php">
                                                            <button type="submit" class="dropdown-item"><i class='fa-solid fa-shop'></i></button>-->
                                                            <a href="carrito.php" style="float: left;margin: 2px;border-radius:30px" class="btn btn-light"><i class='fa fa-cart-arrow-down'></i></a>
                                                        <!--</form>-->
                                                    <?php break;
                                            }
                                        }
                                                    ?>
                                </li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-md-12" style="background:#121212">
                    <nav class="navbar navbar-light">
                        <div class="container-fluid menu colspan=1">
                            <a href="noticias.php">Noticias</a>
                            <a href="categorias.php">Películas</a>
                            <a href="estrenos.php">Estrenos</a>
                            <a href="contactenos.php">Contáctenos</a>
                            <form action="buscador.php?pagina=1" method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <select style="width:160px;background:black;color:white" class="form-control" id="selectTipo" name="genero">
                                            <option>Todo</option>
                                            <option>Fantasía</option>
                                            <option>Terror</option>
                                            <option>Acción</option>
                                            <option>Aventura</option>
                                            <option>Crimen</option>
                                            <option>Ciencia Ficción</option>
                                            <option>Drama</option>
                                            <option>Comedia</option>
                                        </select>
                                    </div>
                                    <input id="titulo" name="titulo" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Buscar películas">
                                    <div class="input-group-append">
                                        <button style="border-color: white" class="btn btn-outline-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
            <div data-backdrop="static" class="modal fade" id="ingresar">
                <div class="col-md-12 modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Iniciar Sesión</h4>
                            <button type="button" class="close" data-dismiss="modal">X</button>
                        </div>
                        <div class="col-md-12" style="background:#e0e0e0">
                            <div class="modal-body">
                                <form action="login.php" method="POST">
                                    <div class="form-group" id="user-group">
                                        <label for="user">Usuario</label>
                                        <input type="text" class="form-control" name="usuario" id="usuario" onkeypress="return check(event)" placeholder="Ingrese su usuario" require>
                                    </div>
                                    <div class="form-group" id="password-group">
                                        <label for="contra">Contraseña</label>
                                        <input type="password" class="form-control" name="contrasenia" id="contrasenia" onkeypress="return check(event)" placeholder="Ingrese su contraseña" require>
                                    </div>
                                    <div align="center"><a style="color:black;text-decoration:none" data-toggle="modal" href="#" data-target="#recuperar">¿Olvidaste tu contraseña?</a></div>
                                    <div align="center" class="form-group">
                                        <button style="margin-top:7%;width:50%" name="ingresar" value="ingresar" type="submit" class="btn btn-light">Ingresar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end #iniciar-->
            <div data-backdrop="static" class="modal fade" id="registrar">
                <div class="col-md-12 modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Registrate</h4>
                            <button type="button" class="close" data-dismiss="modal">X</button>
                        </div>
                        <div class="col-md-12" style="background:#e0e0e0">
                            <div class="modal-body">
                                <form method="POST" action="registrar.php" onsubmit="return registrar(this)">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Mail</label>
                                            <input type="email" class="form-control" name="email" id="mail" placeholder="example@example.com" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Usuario</label>
                                            <input type="text" class="form-control" name="nombre_usu" id="nombre_usuario" onkeypress="return check(event)" placeholder="Ingrese su usuario" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Contraseña</label>
                                            <input type="password" class="form-control" name="contrasenia" id="contrasenia" onkeypress="return check(event)" placeholder="Ingrese su contraseña" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Repetir Contraseña</label>
                                            <input type="password" class="form-control" id="contrasenia2" onkeypress="return check(event)" placeholder="Repetir su contraseña" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12" align="center">
                                        <div class="form-group">
                                            <button style="width: 50%;" name="registrado" value="registrado" id="btn2" class="btn btn-light" onclick="registrar();">Registrar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div data-backdrop="static" class="modal fade" id="recuperar">
            <div class="col-md-12 modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Recuperar Contraseña</h4>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                    </div>
                    <div class="col-md-12" style="background:#e0e0e0">
                        <div class="modal-body">
                            <form action="recuperarContra.php" method="POST">
                                <div class="form-group" id="user-group">
                                    <label for="user">Ingrese su email</label>
                                    <input type="email" class="form-control" name="mail" id="mail" require placeholder="Ingrese su email">
                                </div>

                                <button style="margin-top:7%;width:50%" name="buscar" value="buscar" type="submit" class="btn btn-light">Buscar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="jquery.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/2be8605e79.js"></script>
    <script>
        function registrar(v) {
            var ok = true;
            var msg = "ERROR: \n";

            if (v.elements['contrasenia'].value != v.elements['contrasenia2'].value) {
                msg += "Las contraseñas no coinciden \n";
                ok = false;
            }
            if (ok == false) {
                alert(msg);
                return ok;
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

