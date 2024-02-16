<section class="mt-4 container">
    <h1 class="text-center">Administration des Users</h1>
    <div class="row gy-3">
        <?php foreach($users as $user) : ?>
            <div class="col-4">
                <div class="card">
                    <h2 class="card-header"><?= $user->getNom(); ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>