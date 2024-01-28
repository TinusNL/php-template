<?php

// If the user is logged in, redirect to the admin page
if (Auth::$user) {
    header('Location: ' . Router::getUrl('admin'));
    exit;
}

// If the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get the user from the database
    $user = User::getByUsername($username);

    // Check if the user exists and the password is correct
    if ($user && password_verify($password, $user->password)) {
        // Set the user in the session
        Auth::setUser($user->id);
    }

    // Show an error message
    echo 'Username and/or password is incorrect.';
}

?>

<div class="pages-login">
    <div>
        <h1>Login</h1>

        <form action="" method="POST">
            <div class="input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="..." required>
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="..." required>
            </div>
            <div class="actions">
                <a href="<?= Router::getUrl('signup') ?>">Don't have an account?</a>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</div>