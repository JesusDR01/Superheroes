<?php
if ($_SESSION['perfil'] != "experto") {
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
    <h1>Añadir superheroe</h1>
    <?php
    array_walk($data, function ($value, $key) {
        if (str_contains($key, "msgError")) {
            echo "<b>" . $value . "</b>";
        }
    });
    ?>
    <form class="d-flex flex-column" method="POST" enctype="multipart/form-data">

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nombre</span>
            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $data["nombre"]; ?>" class="form-control">
        </div>

        <div class="input-group mb-3">
            <input type="file" name="file" placeholder="imagen" class="form-control">
            <label class="input-group-text" for="inputGroupFile02">Imagen</label>
        </div>

        <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['idUsuario'] ?>" />
        <input class="btn btn-primary" type="submit" value="Añadir">
    </form>
</body>

</html>