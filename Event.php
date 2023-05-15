<?php
class Event {
    private $id;
    private $host;
    private $name;
    private $description;
    private $date;
    private $location;

    public function __construct($id =  null, $host, $name, $description, $date, $location) {
        $this->id = $id;
        $this->host = $host;
        $this->name = $name;
        $this->description = $description;
        $this->date = $date;
        $this->location = $location;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }
}
?>