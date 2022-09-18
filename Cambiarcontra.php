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
<title>Cambiar Contraseña</title>
</head>
<body>
<?php
    require("header.php");
    require("conexion.php");
    ?>
    <div class="container">
       <div class="row">
            <form action="abm_usuario.php" method="POST" style="width:50%" class="rp" onsubmit="return registrar(this)">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4" style="color:white">Contraseña Nueva</label>
                        <input type="password" class="form-control" name="contr" id="contr" onkeypress="return check(event)" placeholder="Ingrese su contraseña nueva">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputPassword4" style="color:white">Repetir Contraseña</label>
                        <input type="password" class="form-control" id="contr2" onkeypress="return check(event)" placeholder="Repetir contraseña">
                        <input type="text" class="form-control" id="idusu" name="idusu" value="<?php echo $_SESSION['login']; ?>" hidden>
                    </div>
                </div>
                <button class="btn btn-dark" style="width: 100%;" name="Cambiar" value="Cambiar" id="Cambiar" onclick="registar();"><i class="fas fa-save"></i> Cambiar Contraseña</button>             
            </form>
        </div>
    </div>
    <script>
        function registrar(v) {
            var ok = true;
            var msg = "ERROR: \n";

            if (v.elements['contr'].value != v.elements['contr2'].value) {
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
