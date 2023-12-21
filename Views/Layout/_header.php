<header class="navbar-fixed bg-primary">
    <nav class="navbar container navbar-expand-sm navbar-dark">
        <a class="navbar-brand" href="/">My first MVC App</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/" aria-current="page">Home <span class="visually-hidden">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Postes</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <li class="nav-item ms-2">
                        <a href="/profil" class="btn btn-outline-light">Profil</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="/logout" class="btn btn-danger">Déconnexion</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="/login" class="btn btn-light">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>