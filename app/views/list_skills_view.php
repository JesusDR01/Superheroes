<?php
if ($_SESSION['perfil'] != 'superheroe' && $_SESSION['perfil'] != 'experto') {
    header('Location: /home');
}

if (count($data) == 0) {
?>
    <h2>No tienes habilidades 😞</h2>
<?php
} else {
?>
    <table class="container">
        <tr>
            <th>NOMBRE</th>
            <th>VALOR</th>
            <th>ACCIONES</th>
        </tr>
        <?php
        foreach ($data as $elemento) {
        ?>
            <tr>
                <td>
                    <div class="input-group mb-3 reference">
                        <span class="input-group-text" id="basic-addon1">Nombre de la habilidad</span>
                        <input type="hidden" name="nombre" value="<?php echo $elemento['nombre']; ?>" class="form-control">
                    </div>
                    <span>
                        <?php
                        echo $elemento['nombre'];
                        ?>
                    </span>
                </td>
                <td>

                    <div class="input-group mb-3 reference">
                        <span class="input-group-text" id="basic-addon1">Valor de la habilidad</span>
                        <input type="hidden" name="valor" value="<?php echo $elemento['valor']; ?>" class="form-control">
                    </div>

                    <span>
                        <?php
                        echo $elemento['valor'];
                        ?>
                    </span>
                </td>
                <td colspan="2">
                    <form method="post" action="/superheroes/modifySkill/<?php echo $elemento['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $elemento['id']; ?>">
                        <input type="hidden" name="nombre" value="<?php echo $elemento['nombre']; ?>">
                        <input type="hidden" name="valor" value="<?php echo $elemento['valor']; ?>">
                        <input class="btn btn-primary" type="submit" value="Confirmar">
                        <input class="btn btn-danger cancel" type="button" value="Cancelar">
                    </form>
                    <a href="/superheroes/modifySkill/<?php echo $elemento['id']; ?>">
                    </a>
                    <button class="btn btn-outline-primary modify">Modificar</button>
                <?php
            }
                ?>
            </tr>
    </table>
<?php
}
