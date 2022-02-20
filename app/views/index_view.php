<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset-utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Jesús Díaz Rivas</title>
    <script>
        function showSuperheroes(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                };
            }
            xmlhttp.open("GET", `${window.location.origin}/ajax?nombre=${str}`);
            xmlhttp.send();
        }
    </script>
</head>

<body class="container">
    <div>
        <?php include("header_view.php") ?>
        <form>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Localizar SH</span>
                <input ttype="text" id="fname" name="fname" onkeyup="showSuperheroes(this.value)" class="form-control">
            </div>
        </form>
        <p>
        <h4>Listado de SuperHéroes</h4>
        <span id="txtHint">
            <?php
            include("list_superheroes_view.php");
            ?>
    </div>

</body>

</html>