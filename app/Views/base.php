<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($meta['title']) ? $meta['title'] : null; ?> | My first app MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <?php if(isset($meta['css'])): ?>
        <?php foreach($meta['css'] as $cssLink): ?>
            <link rel="stylesheet" href="<?= $cssLink; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (isset($meta['scripts'])) :?>
        <?php foreach($meta['scripts'] as $src) : ?>
            <script src="<?= $src ;?>" defer></script>
        <?php endforeach; ?>
    <?php endif ;?>
</head>
<body>
    <header>
        <?php include_once ROOT . '/Views/Layout/header.php'; ?>
        
    </header>

    <main>
        <?php include_once ROOT . '/Views/Layout/message.php'; ?>
        <?= $content; ?>

    </main>
    
</body>

</html>