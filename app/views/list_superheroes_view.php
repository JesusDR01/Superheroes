<style>
    img {
        min-width: 30%;
        height: 100%;
    }
</style>
<?php
if (count($data) == 0) {
?>
    <h2>No se encontraron superhéroes 😞</h2>
<?php
} else {
?>
    <table class="container">
        <tr>
            <th></th>
            <th>NOMBRE</th>
            <th>EVOLUCIÓN</th>
            <?php
            if ($_SESSION['perfil'] != 'invitado') {
            ?> <th>ACCIONES</th>
            <?php
            } ?>
        </tr>
        <?php
        foreach ($data as $elemento) {
        ?>
            <tr>
                <td>
                    <?php
                    if ($elemento['imagen'] != null) {
                        $img = $elemento['imagen'];
                    } else {
                        $img = "default.png";
                    }
                    ?>
                    <img src="<?php echo "imgs/" . $img ?>" alt="<?php echo $elemento['nombre'] ?>" width="150" height="150">
                </td>
                <td>
                    <?php
                    echo $elemento['nombre'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $elemento['evolucion'];
                    ?>
                </td>
                <td>
                    <?php
                    if ($_SESSION['perfil'] == 'experto') {
                    ?>
                        <a href="/superheroes/edit/<?php echo $elemento['idSuperheroe'] ?>">
                            <button class="btn btn-outline-primary">Editar</button>
                        </a>
                        <a href="/superheroes/delete/<?php echo $elemento['idSuperheroe'] ?>">
                            <button class="btn btn-outline-danger">Eliminar</button>
                        </a>
                    <?php
                    }
                    if ($_SESSION['perfil'] == 'experto' || $_SESSION['perfil'] == 'superheroe') {
                    ?>
                        <a href="/superheroes/addSkills/<?php echo $elemento['idSuperheroe'] ?>">
                            <button class="btn btn-outline-primary">Añadir habilidades</button>
                        </a>
                    <?php } ?>

                    <?php
                    if ($_SESSION['perfil'] == 'ciudadano') {
                    ?>
                        <a href="/superheroes/addRequest/<?php echo $elemento['idSuperheroe'] ?>">
                            <button class="btn btn-outline-primary">Realizar petición</button>
                        </a>
                    <?php } ?>

                </td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
}
