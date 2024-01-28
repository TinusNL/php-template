<?php
// Load the constants
require_once '_constants.php';

// Load the router
Router::loadComponents();
Router::loadPages('pages');
Router::loadUrl($_SERVER['REQUEST_URI']);

// Get the content of the current page
$pageContent = Router::getContent();

// If the current page is not an api, load the header
if (Router::isApi()) : ?>
    <?= $pageContent ?>
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
        <?= $pageContent ?>
    </body>

    </html>
<?php endif;  ?>