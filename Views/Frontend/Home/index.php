<h1>Page d'accueil</h1>

<?php foreach ($postes as $poste) : ?>
    <h2><?= $poste->getTitre(); ?></h2>
    <p><?= $poste->getDescription(); ?></p>
<?php endforeach; ?>