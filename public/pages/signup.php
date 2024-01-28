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
    $password2 = $_POST['password2'];

    // Check if the passwords match
    if ($password != $password2) {
        echo 'Passwords do not match.';
    } else {
        // Get the user from the database
        $user = User::getByUsername($username);

        // Check if the user exists
        if (!$user) {
            // Add the user to the database and login
            $user = User::addUser($username, $password);
            Auth::setUser($user->id);
        }

        // Show an error message
        echo 'Username already exists.';
    }
}

?>

<div class="pages-signup">
    <div>
        <h1>Signup</h1>

        <form action="" method="POST">
            <div class="input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="..." required>
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="..." required>
            </div>
            <div class="input">
                <label for="password2">Re-enter Password</label>
                <input type="password" name="password2" id="password2" placeholder="..." required>
            </div>
            <div class="actions">
                <a href="<?= Router::getUrl('login') ?>">Already have an account?</a>
                <input type="submit" value="Signup">
            </div>
        </form>
    </div>
</div>