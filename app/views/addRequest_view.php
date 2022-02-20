<?php
if ($_SESSION['perfil'] != "ciudadano") {
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
    <h1>Añadiendo peticiones a <?php echo $data['nombreSuperheroe'] ?> </h1>
    <?php
    if (isset($data['msgSuccess'])) {
        echo "<h2>{$data['msgSuccess']}</h2>";
    }
    array_walk($data, function ($value, $key) {
        if (str_contains($key, "msgError")) {
            echo "<p>$value</p>";
        }
    });
    ?>
    <form class="d-flex flex-column" action="" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Titulo</span>
            <input type="text" name="titulo" value="" placeholder="Título la petición" class="form-control">
        </div>

        <div class="input-group">
            <span class="input-group-text">descripcion</span>
            <textarea name="descripcion" placeholder="descripción de la petición" class="form-control"></textarea>
        </div>

        <input type='hidden' value="<?php $data['idSuperheroe'] ?>" name='id' />
        <input class="btn btn-primary" type="submit" value="add">
    </form>
    </div>
</body>

</html>