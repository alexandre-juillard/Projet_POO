<section class="mt-4 container">
    <h1 class="text-center">Administration des produits</h1>
    <a href="/admin/produits/create" class="btn btn-primary mt-3">Créer un produit</a>
    <div class="mt-2 row gy-3">
        <?php foreach ($produits as $produit) : ?>
            <div class="col-md-4">
                <div class="card text-white <?= $produit->getActif() ? "bg-success" : "bg-secondary"; ?>">
                    <?php if ($produit->getImageName()) : ?>
                        <img src="/images/produits/<?= $produit->getImageName(); ?>" class="img-fluid rounded-top" loading="lazy" alt="<?= $produit->getTitre(); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-text text-center"><?= $produit->getTitre(); ?></h2>
                        <p class="card-text <?= $produit->findCategorieByProduit() ? 'badge bg-primary' : null; ?>"><?= $produit->findCategorieByProduit(); ?></p>
                        <p class="card-text">Créé le : <em><?= ($produit->getCreatedAt())->format('d-m-Y'); ?></em></p>
                        <p class="card-text">Prix TTC : <?= ($produit->getPrixHT() * (1 + $produit->getTva())); ?> €</p>
                        <p class="card-text"><?= substr($produit->getDescription(), 0, 20); ?>...</p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch-enable-produit-<?= $produit->getId(); ?>" <?= $produit->getActif() ? 'checked' : null; ?> data-switch-produit-id="<?= $produit->getId(); ?>" />
                            <label class="form-check-label" for="switch-enable-produit-<?= $produit->getId(); ?>">Actif</label>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <a href="/admin/produits/<?= $produit->getId(); ?>/edit" class="btn btn-warning">Modifier</a>
                            <form action="/admin/produits/<?= $produit->getId(); ?>/delete" method="POST" onsubmit="return confirm('Voulez vous supprimer cet article?')">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                <input type="hidden" name="id" value="<?= $produit->getId(); ?>">
                                <button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>