<?php

Auth::forceLogin();

?>

<div>
    <h1>Locked</h1>
    <p>Locked page</p>
    <hr>
    <a href="<?= Router::getUrl('api/logout') ?>">Logout</a>
</div>