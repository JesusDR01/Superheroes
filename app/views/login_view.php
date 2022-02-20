<?php
if ($_SESSION['perfil'] != "invitado") {
    header("Location: /home");
    exit();
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
    <h1>Inicio de sesión</h1>
    <?php
    array_walk($data, function ($value, $key) {
        if (str_contains($key, "msgError")) {
            echo "<p>$value</p>";
        }
    });
    ?>
    <form class="d-flex flex-column" action="" method="POST">
        <label>
            Usuario
            <input type="text" name="usuario" placeholder="Nombre de usuario">
        </label>
        <label>
            Contraseña
            <input type="password" name="psw" placeholder="******">
        </label>
        <input class="btn btn-primary" type="submit" value="Iniciar sesión">
    </form>
</body>

</html>