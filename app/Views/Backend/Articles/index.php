<section class="mt-4 container">
    <h1 class="textcenter">Administration des articles</h1>
    <a href="/admin/articles/create" class="btn btn-primary mt-3">Créer un article</a>
    <div class="mt-2 row gy-3">
        <?php foreach ($articles as $article) : ?>
            <div class="col-md-4">
                <div class="card text-white <?= $article->getActif() ? "bg-success" : "bg-secondary"; ?>">
                    <?php if ($article->getImageName()) : ?>
                        <img src="/images/articles/<?= $article->getImageName(); ?>" class="img-fluid rounded-top" loading="lazy" alt="<?= $article->getTitre(); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-text text-center"><?= $article->getTitre(); ?></h2>
                        <p class="card-text">Créé le : <em><?= ($article->getCreatedAt())->format('d-m-Y'); ?></em></p>
                        <p class="card-text">Par : <em><?= $article->getOneAuthorByArticle(); ?></em></p>
                        <p class="card-text"><?= substr($article->getDescription(), 0, 20); ?>...</p>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch-enable-article-<?= $article->getId();?>" <?= $article->getActif() ? 'checked' : null;?> data-switch-article-id="<?= $article->getId(); ?>"/>
                            <label class="form-check-label" for="switch-enable-article-<?= $article->getId();?>">Actif</label>
                        </div>

                        <div class="d-flex justify-content-between flex-wrap">
                            <a href="/admin/articles/<?= $article->getId(); ?>/edit" class="btn btn-warning">Modifier</a>
                            <form action="/admin/articles/<?= $article->getId(); ?>/delete" method="POST" onsubmit="return confirm('Voulez vous supprimer cet article?')">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                                <button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>