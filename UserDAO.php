<?php
require_once('Config.php');
class UserDao {
    private $conn;

    public function __construct() {
        $config = new Config();
        $this->conn = $config->getConnection();
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function createUser($name, $email, $password, $user_type) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, usertype) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, password_hash($password, PASSWORD_DEFAULT), $user_type);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT id, name, email, password, usertype FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $email, $password, $user_type);
            $stmt->fetch();

            return new User($id, $name, $email, $password, $user_type);
        } else {
            return null;
        }
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT name, email, usertype FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($name, $email, $user_type);
            $stmt->fetch();

            return new User($id, $name, $email, "", $user_type);
        } else {
            return null;
        }
    }

    public function updateUser($user) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, usertype = ? WHERE id = ?");
        $stmt->bind_param("sssi", $user->getName(), $user->getEmail(), $user->getUserType(), $user->getId());

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}

?>