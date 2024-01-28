<?php

Auth::forceLogin();

?>

<?= Router::getComponent('admin/header') ?>

<div class="pages-admin-locked">
    <div class="header">
        <h1>Items</h1>
        <div>
            <a href="#" class="new">New</a>
        </div>
    </div>
    <div class="items">
        <div>
            <h3>Item Name</h3>
            <div>
                <a href="#" class="edit">Edit</a>
                <a href="#" class="delete">Delete</a>
            </div>
        </div>
        <div>
            <h3>Item Name</h3>
            <div>
                <a href="#" class="edit">Edit</a>
                <a href="#" class="delete">Delete</a>
            </div>
        </div>
        <div>
            <h3>Item Name</h3>
            <div>
                <a href="#" class="edit">Edit</a>
                <a href="#" class="delete">Delete</a>
            </div>
        </div>
    </div>
</div>