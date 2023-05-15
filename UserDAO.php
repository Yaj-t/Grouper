<?php
require_once('Config.php');
require_once('User.php');
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
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $name, $email, $pass, $user_type);

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

            return new User($name, $email, $password, $user_type, $id);
        } else {
            return null;
        }
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT name, email, password, usertype FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($name, $email, $password, $user_type);
            $stmt->fetch();

            return new User($name, $email, $password, $user_type, $id);
        } else {
            return null;
        }
    }

    public function updateUser($user) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, password = ?, usertype = ? WHERE id = ?");
        $pass = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $stmt->bind_param("sssi", $user->getName(), $user->getEmail(), $pass, $user->getUserType(), $user->getId());

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