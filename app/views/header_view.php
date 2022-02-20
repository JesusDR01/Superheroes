<header>
    <div class="p-2 d-flex justify-content-between">
        <?php
        if ($_SESSION['perfil'] == 'invitado') {

        ?>
            <a href="/superheroes/login">
                <h2>Iniciar sesión</h2>
            </a>
            <a href="/superheroes/register">
                <h2>Registrarse</h2>
            </a>
        <?php
        } else {
        ?>
            <a href="/superheroes/info">
                <h2>Información de Usuario</h2>
            </a>
            <a href="/superheroes/logout">
                <h2>Salir</h2>
            </a>
        <?php
        }

        ?>
    </div>
    <div class="p-2 d-flex justify-content-between align-items-center bg-light">
        <a href="/home">
            <button class="btn btn-outline-primary">Superhéroes</button>
        </a> <?php
                if ($_SESSION['perfil'] == 'experto' || $_SESSION['perfil'] == 'superheroe') { ?>
            <a href="/superheroes/listRequests">
                <button class="btn btn-outline-primary">Peticiones</button>
            </a>
            <a href="/superheroes/listSkills">
                <button class="btn btn-outline-primary">Habilidades</button>
            </a>
        <?php
                }
                if ($_SESSION['perfil'] == 'experto') { ?>
            <a href="/superheroes/add">
                <button class="btn btn-outline-primary">Nuevo Superhéroe</button>
            </a>
        <?php
                } ?>
    </div>
</header>