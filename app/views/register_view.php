<?php
if ($_SESSION['perfil'] != "invitado") {
    header("Location: /home");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Jesús Díaz Rivas</title>
</head>

<body class="container">
    <?php include("header_view.php") ?>
    <?php
    array_walk($data, function ($value, $key) {
        if (str_contains($key, "msgError")) {
            echo "<p>$value</p>";
        }
    });
    ?>
    <div class="d-flex justify-content-evenly flex-wrap">
        <div style="flex:1; margin:10px;">
            <h2>Registrate como ciudadano!</h2>
            <form class="d-flex flex-column" method="POST">

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nombre</span>
                    <input value="<?php echo $data['nombreCiudadano'] ?>" type="text" name="nombreCiudadano" placeholder="Nombre de ciudadano" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Correo electrónico</span>
                    <input value="<?php echo $data['email'] ?>" type="email" name="email" placeholder="Correo electrónico" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Usuario</span>
                    <input value="<?php echo $data['usuarioCiudadano'] ?>" type="text" name="usuarioCiudadano" placeholder="Nombre de usuario" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Contraseña</span>
                    <input type="password" name="psw" placeholder="******" class="form-control">
                </div>
                <input class="btn btn-primary" type="submit" name="ciudadano" value="Registrarse">
            </form>
        </div>
        <div style="flex:1; margin:10px;">
            <h2>Registrate como superhéroe!</h2>
            <form class="d-flex flex-column" method="POST" enctype="multipart/form-data">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nombre</span>
                    <input type="text" class="form-control" placeholder="Nombre de superhéroe" value="<?php echo $data['nombreSuperheroe'] ?>" name="nombreSuperheroe">
                </div>
                <div class="input-group mb-3">
                    <input type="file" name="file" class="form-control" id="inputGroupFile02">
                    <label class="input-group-text" for="inputGroupFile02">Imagen</label>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Usuario</span>
                    <input value="<?php echo $data['usuarioSuperheroe'] ?>" type="text" name="usuarioSuperheroe" placeholder="Nombre de usuario" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Contraseña</span>
                    <input type="password" name="psw" placeholder="******" class="form-control">
                </div>
                <input class="btn btn-primary" type="submit" name="superheroe" value="Registrarse   ">
            </form>
        </div>
    </div>
</body>

</html>