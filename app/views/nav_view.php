<nav>
    <div class=" p-2 d-flex justify-content-between align-items-center bg-light">
        <h1>Superhéroes</h1>
        <?php
        if ($_SESSION['perfil'] == 'experto') { ?>
            <a href="/superheroes/add">
                <button class="btn btn-outline-primary">Nuevo Superhéroe</button>
            </a>
        <?php
        } ?>
    </div>
</nav>