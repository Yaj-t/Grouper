<?php
require_once('config.php');

class Event
{
    private $conn;

    public function __construct()
    {
        $config = new Config();
        $this->conn = $config->getConnection();
    }

    public function createEvent($name, $date, $location, $host)
    {
        $query = "INSERT INTO events (name, date, location, host) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssss', $name, $date, $location, $host);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function getEventById($id)
    {
        $query = "SELECT * FROM events WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getEventsByHost($host)
    {
        $query = "SELECT * FROM events WHERE host = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $host);
        $stmt->execute();
        $result = $stmt->get_result();
        $events = array();
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        return $events;
    }

    public function getEventsByUser($user_id)
    {
        $query = "SELECT events.* FROM events INNER JOIN event_users ON events.id = event_users.event_id WHERE event_users.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->     bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $events = array();
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        return $events;
    }
    
    public function joinEvent($event_id, $user_id)
    {
        $query = "INSERT INTO event_users (event_id, user_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $event_id, $user_id);
        $stmt->execute();
        return $stmt->insert_id;
    }
    
    public function unjoinEvent($event_id, $user_id)
    {
        $query = "DELETE FROM event_users WHERE event_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $event_id, $user_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    
    public function updateEvent($id, $name, $date, $location)
    {
        $query = "UPDATE events SET name = ?, date = ?, location = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssi', $name, $date, $location, $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    
    public function deleteEvent($id)
    {
        $query = "DELETE FROM events WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    
}