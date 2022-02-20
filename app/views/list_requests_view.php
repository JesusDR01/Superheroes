<?php
if ($_SESSION['perfil'] != 'superheroe' && $_SESSION['perfil'] != 'experto') {
    header('Location: /home');
}
if (count($data) == 0) {
?>
    <h2>No se encontraron peticiones 😞</h2>
<?php
} else {
?>
    <table class="container">
        <tr>
            <th>TITULO</th>
            <th>DESCRIPCION</th>
            <th>REALIZADA</th>
        </tr>
        <?php
        foreach ($data as $elemento) {
        ?>
            <tr>
                <td>
                    <?php
                    echo $elemento['titulo'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $elemento['descripcion'];
                    ?>
                </td>
                <td>
                    <?php
                    if ($elemento['realizada'] == 1) {
                        echo "SI";
                    } else {
                    ?>
                        <a href="/superheroes/requestDone/<?php echo $elemento['id']; ?>">
                            <button class="btn btn-outline-primary">Marcar como realizada</button>
                        </a>
                    <?php
                    }
                    ?>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
}
