<header>

    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">My first app MVC</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Articles</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (!empty($_SESSION['LOGGED_USER'])) : ?>
                        <li class="nav-item">
                            <a href="/logout" class="btn btn-danger">Deconnexion</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="/register" class="btn btn-light">S'inscrire</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="/login" class="btn btn-light">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


</header>