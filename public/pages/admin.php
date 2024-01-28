<?php

Auth::forceLogin();

?>

<?= Router::getComponent('admin/header') ?>

<div class="pages-admin">
    <div class="items">
        <a href="<?= Router::getUrl('admin/items') ?>">Items</a>
    </div>
</div>