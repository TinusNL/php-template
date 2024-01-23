<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::getByUsername($username);

    if (!$user) {
        $user = User::addUser($username, $password);
        Auth::setUser($user->id);
    }

    echo 'Gebruikersnaam bestaat al.';
}

?>

<div>
    <h1>Signup</h1>
    <p>Signup page</p>
    <hr>
    <a href="<?= Router::getUrl('login') ?>">Inloggen</a>
    <hr>
    <form action="" method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <input type="submit" value="Registreren">
    </form>
</div>