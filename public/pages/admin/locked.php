<?php

Auth::forceLogin();

?>

<?= Router::getComponent('admin/header') ?>

<div>
    <h1>Locked</h1>
    <p>Locked page</p>
    <hr>
    <a href="<?= Router::getUrl('api/logout') ?>">Logout</a>
</div>