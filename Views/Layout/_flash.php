<?php foreach (isset($_SESSION['flash']) ? $_SESSION['flash'] : [] as $type => $message) : ?>
    <div class="alert alert-<?= $type; ?>" role="alert">
        <?= $message; ?>
    </div>
    <?php unset($_SESSION['flash'][$type]); ?>
<?php endforeach; ?>