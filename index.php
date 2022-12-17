<?php
require_once '_constants.php';

// Root
h_menu::addPage('p_home', 'Home', [''], false, true);

// Discord Authorization
h_menu::addPage('h_discord', 'Discord', ['discord'], false, false);

// Load the correct class
h_menu::getPageByURL($_SERVER['REQUEST_URI'])
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHP Template - <?= h_menu::$page['name'] ?></title>

    <script src="https://kit.fontawesome.com/828c57c4c4.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_PATH ?>css/screen.css">
</head>

<body>
    <nav>

    </nav>
    <main>
        <?php new h_menu::$page['class'](h_menu::$action); ?>
    </main>
</body>

</html>
