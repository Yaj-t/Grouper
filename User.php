<?php
class User {
    private $id;
    private $name;
    private $email;
    private $password;
    private $user_type;

    public function __construct($id=null, $name, $email, $password, $user_type) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->user_type = $user_type;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUserType() {
        return $this->user_type;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
?>