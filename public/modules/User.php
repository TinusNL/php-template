<?php

class User
{
    public readonly int $id;
    public readonly string $username;
    public readonly string $password;

    public function __construct(int $id, string $username, string $password)
    {
        // Set the user properties
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    // Delete the user from the database
    public function delete(): bool
    {
        $stmt = Database::prepare('DELETE FROM users WHERE id = :id;');
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update the user in the database
    public function update(string | null $username, string | null $password): bool
    {
        // If the username or password is null, use the current username or password
        $this->username = $username ?? $this->username;
        $this->password = $password ? password_hash($password, PASSWORD_DEFAULT) : $this->password;

        // Update the user in the database
        $stmt = Database::prepare('UPDATE users SET username = :username, password = :password WHERE id = :id;');
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $this->$username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->$password, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /*
        Public Static Functions
    */

    // Add a user to the database
    public static function addUser(string $username, string $password): User
    {
        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Add the user to the database
        $stmt = Database::prepare('INSERT INTO users (username, password) VALUES (:username, :password);');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        // Return the user
        return new User(Database::$conn->lastInsertId(), $username, $password);
    }

    // Get all users from the database
    public static function getAll(): array
    {
        // Get all users from the database
        $stmt = Database::prepare('SELECT * FROM users;');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert the users to User objects
        $userObjects = [];
        foreach ($users as $user) {
            $userObjects[] = new User($user['id'], $user['username'], $user['password']);
        }

        // Return the users
        return $userObjects;
    }

    public static function getById(int $id): User | bool
    {
        // Get the user from the database
        $stmt = Database::prepare('SELECT * FROM users WHERE id = :id;');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the user
        return $user ? new User($user['id'], $user['username'], $user['password']) : false;
    }

    public static function getByUsername(string $username): User | bool
    {
        // Get the user from the database
        $stmt = Database::prepare('SELECT * FROM users WHERE username = :username;');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the user
        return $user ? new User($user['id'], $user['username'], $user['password']) : false;
    }
}
