<section class="mt-4 container">
    <h1 class="text-center">Les articles en ligne</h1>
    <div class="mt-2 row gy-3">
        <?php foreach ($articles as $article) : ?>
            <div class="col-md-4">
                <div class="card">
                    <?php if ($article->getImageName()) : ?>
                        <img src="/images/articles/<?= $article->getImageName(); ?>" class="img-fluid rounded-top" loading="lazy" alt="<?= $article->getTitre(); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-text text-center"><?= $article->getTitre(); ?></h2>
                        <p class="card-text <?= $article->findCategorieByArticle() ? 'badge bg-primary' : null; ?><?= $article->findCategorieByArticle(); ?></p>
                        <p class="card-text">Créé le : <em><?= ($article->getCreatedAt())->format('d-m-Y'); ?></em></p>
                        <p class="card-text">Par : <em><?= $article->getOneAuthorByArticle(); ?></em></p>
                        <p class="card-text"><?= substr($article->getDescription(), 0, 20); ?>...</p>
                        <div class="text-center">
                            <a href="/articles/details/<?= $article->getId(); ?>" class="btn btn-primary border">Voir détails</a>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>