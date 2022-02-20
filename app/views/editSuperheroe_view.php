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
    <h1>Editando a <?php echo $data['nombre']?> </h1>
    <form action="" method="POST" class="d-flex flex-column">
        <label>
            Nombre del superheroe:
            <input type="text" name="nombre" value="<?php echo $data['nombre'] ?>" placeholder="Nombre">
        </label>
        <label>
            Nueva imagen:
            <input type="file" name="imagen" placeholder="imagen">
        </label>
        
        <input type='hidden' value="<?php echo $data['id'] ?>" name='id' />
        <input type="submit" value="edit">
    </form>
</body>

</html>