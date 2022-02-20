<?php
if ($_SESSION['perfil'] != "experto" && $_SESSION['perfil'] != "superheroe") {
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
    <h1>Añadiendo habilidades a <?php echo $data['nombreSuperheroe'] ?> </h1>
    <?php
    array_walk($data, function ($value, $key) {
        if (str_contains($key, "msgError")) {
            echo "<p>$value</p>";
        }
    });
    ?>
    <form class="d-flex flex-column" action="" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nombre de la habilidad</span>
            <input type="text" name="nombre" value="" placeholder="Nombre de la habilidad" class="form-control">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Valor de la habilidad</span>
            <input type="number" name="valor" value="" placeholder="valor de la habilidad" class="form-control">
        </div>
        <input type='hidden' value="<?php $data['idSuperheroe'] ?>" name='id' />
        <input type="submit" class="btn btn-primary" value="add">
    </form>
    </div>
</body>

</html>