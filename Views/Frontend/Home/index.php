<section class="mt-4 container">
    <h1 class="text-center">Page d'accueil</h1>
    <div class="row gy-2 mt-4">
        <?php foreach ($postes as $poste) : ?>
            <div class="col-md-4">
                <div class="card">
                    <h2 class="card-header"><?= $poste->getTitre(); ?></h2>
                    <div class="card-body">
                        <p class="card-text"><?= $poste->getDescription(); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>