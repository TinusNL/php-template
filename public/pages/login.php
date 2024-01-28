<?php

if (Auth::$user) {
    header('Location: ' . Router::getUrl('admin/locked'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::getByUsername($username);

    if ($user && password_verify($password, $user->password)) {
        $_SESSION['user'] = $user->id;
        Auth::setUser($user->id);
    }

    echo 'Username and/or password is incorrect.';
}

?>

<div>
    <h1>Login</h1>
    <p>Login page</p>
    <hr>
    <a href="<?= Router::getUrl('signup') ?>">Signup</a>
    <hr>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
</div>