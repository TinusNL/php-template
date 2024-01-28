<?php

class Auth
{
    public static ?User $user = null;

    // Check if the user is logged in
    public static function forceLogin(): void
    {
        // Check if the user is logged in
        if (!Auth::$user) {
            // Redirect to the login page
            header('Location: ' . Router::getUrl('login'));
            exit;
        }
    }

    // Load the user from the session
    public static function loadUser()
    {
        // Check if the user is logged in
        if (isset($_SESSION['user'])) {
            // Get the user from the database
            $user = User::getById($_SESSION['user']);

            // Check if the user exists
            if (!$user) {
                // Remove the user from the session and redirect to the login page
                unset($_SESSION['user']);
                header('Location: ' . Router::getUrl('login'));
                exit;
            }

            // Set the user
            Auth::$user = $user;
        }
    }

    // Set the user in the session
    public static function setUser(int $id): void
    {
        // Set the user in the session
        $_SESSION['user'] = $id;

        // Redirect to the home page
        header('Location: ' . Router::getUrl('admin/locked'));
        exit;
    }

    // Remove the user from the session
    public static function logout(): void
    {
        // Remove the user from the session
        unset($_SESSION['user']);

        // Redirect to the login page
        header('Location: ' . Router::getUrl('login'));
        exit;
    }
}
