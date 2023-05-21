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
        $host = $event->getHost();
        $name = $event->getName();
        $description = $event->getDescription();
        $date = $event->getDate();
        $location = $event->getLocation();
        $stmt->bind_param("issss",$host , $name, $description, $date,$location);
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

    public function searchEvents($searchText) {
        $searchText = "%" . $searchText . "%";
        $events = array();
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE name LIKE ? OR description LIKE ?");
        $stmt->bind_param("ss", $searchText, $searchText);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) {
            // Create an Event object with the fetched row data
            $event = new Event($row['id'], $row['host'], $row['name'], $row['description'], $row['date'], $row['location']);
            $events[] = $event;
        }
    
        $stmt->close();
        return $events;
    }

    public function getEventsCreatedByUser($userId) {
        $events = array();
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE host = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($eventData = $result->fetch_assoc()) {
            $event = new Event(
                $eventData['id'],
                $eventData['host'],
                $eventData['name'],
                $eventData['description'],
                $eventData['date'],
                $eventData['location']
            );
            $events[] = $event;
        }
        
        $stmt->close();
        return $events;
    }
}

?>