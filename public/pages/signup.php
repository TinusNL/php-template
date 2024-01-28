<?php

if (Auth::$user) {
    header('Location: ' . Router::getUrl('admin/locked'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password != $password2) {
        echo 'Passwords do not match.';
    } else {
        $user = User::getByUsername($username);

        if (!$user) {
            $user = User::addUser($username, $password);
            Auth::setUser($user->id);
        }

        echo 'Username already exists.';
    }
}

?>

<div>
    <h1>Signup</h1>
    <p>Signup page</p>
    <hr>
    <a href="<?= Router::getUrl('login') ?>">Login</a>
    <hr>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="password2">Re-enter Password:</label>
        <input type="password" name="password2" id="password2" required>
        <br><br>
        <input type="submit" value="Signup">
    </form>
</div>