<?php foreach(isset($_SESSION['messages']) ? $_SESSION['messages'] : [] as $type => $message) : ?>
    <div class="alert alert-<?= $type;?>" role="alert">
        <?php echo $message;
        unset($_SESSION['message'][$type]); ?>
    </div>
<? endforeach; ?>