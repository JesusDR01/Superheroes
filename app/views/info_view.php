<?php
if ($_SESSION['perfil'] == 'invitado') {
    header('Location: /home');
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
    <style>
        img {
            object-fit: contain;
        }
    </style>
</head>

<body class="container">
    <?php include("header_view.php") ?>
    <h1>Información personal</h1>
    <?php

    array_walk($data, function ($value, $key) {
        if (str_contains($key, "msgError")) {
            echo "<p>$value</p>";
        }
    });
    if (count($data) == 0) {
    ?>
        <h2>Información no disponible 😞</h2>
        <?php
    } else {
        $data = $data[0];
        if ($_SESSION['perfil'] == 'ciudadano') {
        ?> <p>Tu nombre de ciudadano: <b><?php echo $data['nombre']; ?> </b></p>
            <p> Tu email:<?php echo $data['email']; ?> </p>
        <?php
        } else {
        ?>
            <p>Tu nombre de superheroe: <b> <?php echo $data['nombre']; ?></b> </p>
            <p> Tu evolución: <?php echo $data['evolucion']; ?> </p>
            <?php
            if ($data['imagen'] != null) {
                $img = $data['imagen'];
            } else {
                $img = "default.png";
            }
            ?>
            <p>Tu imagen:</p>
            <img src="<?php echo "../imgs/" . $img ?>" alt="<?php echo $data['imagen'] ?>" width="150" height="150">
        <?php }
        ?>
    <?php
    }
    ?>
</body>

</html>