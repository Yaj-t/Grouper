<?php
require_once 'Config.php';

class EventUserDAO {
  private $conn;

  public function __construct() {
    $db = new Config();
    $this->conn = $db->getConnection();
  }

  // Add a new row to the event_users table
  public function addEventUser($event_id, $user_id) {
    $stmt = $this->conn->prepare("INSERT INTO event_users (event_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $stmt->close();
  }

  // Get the list of all users for an event
  public function getUsersByEvent($event_id) {
    $stmt = $this->conn->prepare("SELECT * FROM event_users WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = array();
    while ($row = $result->fetch_assoc()) {
      $users[] = $row['user_id'];
    }
    $stmt->close();
    return $users;
  }

  // Get the list of all events for a user
  public function getEventsByUser($user_id) {
    $stmt = $this->conn->prepare("SELECT * FROM event_users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $events = array();
    while ($row = $result->fetch_assoc()) {
      $events[] = $row['event_id'];
    }
    $stmt->close();
    return $events;
  }

  // Remove a row from the event_users table
  public function removeEventUser($event_id, $user_id) {
    $stmt = $this->conn->prepare("DELETE FROM event_users WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $stmt->close();
  }

  public function isUserJoined($event_id, $user_id) {
    $stmt = $this->conn->prepare("SELECT * FROM event_users WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;
    $stmt->close();
    return $count > 0;
  }

  public function joinEvent($event_id, $user_id) {
    if (!$this->isUserJoined($event_id, $user_id)) {
      $this->addEventUser($event_id, $user_id);
      return true;
    }
    return false;
  }
  
  
}
?>