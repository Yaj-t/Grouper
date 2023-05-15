<?php
require_once 'Config.php';
require_once 'Event.php';

class EventDAO {
    private $conn;

    public function __construct() {
        $config = new Config();
        $this->conn = $config->getConnection();
    }

    public function createEvent(Event $event) {
        $stmt = $this->conn->prepare("INSERT INTO events (host, name, description, date, location) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $event->getHost(), $event->getName(), $event->getDescription(), $event->getDate(), $event->getLocation());
        $stmt->execute();
        $event->setId($stmt->insert_id);
        $stmt->close();
        return $event;
    }

    public function getEventById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_object("Event");
        $stmt->close();
        return $event;
    }

    public function updateEvent(Event $event) {
        $stmt = $this->conn->prepare("UPDATE events SET host = ?, name = ?, description = ?, date = ?, location = ? WHERE id = ?");
        $stmt->bind_param("issssi", $event->getHost(), $event->getName(), $event->getDescription(), $event->getDate(), $event->getLocation(), $event->getId());
        $stmt->execute();
        $stmt->close();
        return $event;
    }

    public function deleteEvent(Event $event) {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $event->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function getAllEvents() {
        $events = array();
        $result = $this->conn->query("SELECT * FROM events");
        while ($event = $result->fetch_object("Event")) {
            $events[] = $event;     
        }
        return $events;
    }

    public function getEventsByHost($hostId) {
        $events = array();
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE host = ?");
        $stmt->bind_param("i", $hostId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($event = $result->fetch_object("Event")) {
            $events[] = $event;
        }
        $stmt->close();
        return $events;
    }
}

?>