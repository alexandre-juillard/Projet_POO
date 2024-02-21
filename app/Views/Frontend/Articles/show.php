<section class="mt-4 container">
    <h1 class="text-center">Détail de l'article</h1>
    <div class="mt-2 row gy-3">
            <div class="col-md-12">
                <div class="card">
                    <?php if ($article->getImageName()) : ?>
                        <img src="/images/articles/<?= $article->getImageName(); ?>" class="img-fluid rounded-top" loading="lazy" alt="<?= $article->getTitre(); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-text text-center"><?= $article->getTitre(); ?></h2>
                        <p class="card-text text-center">Créé le : <em><?= ($article->getCreatedAt())->format('d-m-Y'); ?></em></p>
                        <p class="card-text text-center">Par : <em><?= $article->getOneAuthorByArticle(); ?></em></p>
                        <p class="card-text text-center"><?= $article->getDescription(); ?></p>
                        <div class="text-center">
                            <a href="/articles/details/<?= $article->getId(); ?>" class="btn btn-primary border">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
