<?php
// Load the constants
require_once '_constants.php';

// Load the router
Router::loadPages('pages');
Router::loadUrl($_SERVER['REQUEST_URI']);

// If the current page is not an api, load the header
if (Router::isApi()) : ?>
    <?php Router::getContent(); ?>
<?php else :  ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./<?= Router::getOffset() ?>css/main.css">
        <title>PHP Template</title>
    </head>

    <body>
        <?php

        Router::getContent();

        ?>
    </body>

    </html>
<?php endif;  ?>