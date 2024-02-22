<section class="mt-4 container">
    <h1 class="text-center">Administration des catégorie</h1>
    <a href="/admin/categories/create" class="btn btn-primary mt-3">Créer une catégorie</a>
    <div class="mt-2 row gy-3">
        <?php foreach ($categories as $categorie) : ?>
            <div class="col-md-4">
                <div class="card text-white <?= $categorie->getActif() ? "bg-success" : "bg-secondary"; ?>">
                    <?php if ($categorie->getImageName()) : ?>
                        <img src="/images/categories/<?= $categorie->getImageName(); ?>" class="img-fluid rounded-top" loading="lazy" alt="<?= $categorie->getNom(); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-text text-center"><?= $categorie->getNom(); ?></h2>
                        <p class="card-text">Créé le : <em><?= ($categorie->getCreatedAt())->format('d-m-Y'); ?></em></p>
                        

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch-enable-categorie-<?= $categorie->getId();?>" <?= $categorie->getActif() ? 'checked' : null;?> data-switch-categorie-id="<?= $categorie->getId(); ?>"/>
                            <label class="form-check-label" for="switch-enable-categorie-<?= $categorie->getId();?>">Actif</label>
                        </div>

                        <div class="d-flex justify-content-between flex-wrap">
                            <a href="/admin/categories/<?= $categorie->getId(); ?>/edit" class="btn btn-warning">Modifier</a>
                            <form action="/admin/categories/<?= $categorie->getId(); ?>/delete" method="POST" onsubmit="return confirm('Voulez vous supprimer cette catégorie?')">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                <input type="hidden" name="id" value="<?= $categorie->getId(); ?>">
                                <button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>