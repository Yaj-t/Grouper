<?php
require_once 'EventDAO.php';
require_once 'User.php';
require_once 'EventUserDAO.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Get the logged-in user
$user = unserialize($_SESSION['user']);

// Create an instance of the EventDAO
$eventDAO = new EventDAO();
$eventUserDAO = new EventUserDAO();

// Get the list of events created by the user
$createdEvents = $eventDAO->getEventsByHost($user->getId());

// Get the list of events joined by the user
$joinedEvents = $eventUserDAO->getEventsByUser($user->getId());

// Handle unjoin event form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unjoinEvent'])) {
    $eventId = $_POST['eventId'];

    // Remove the user from the event
    $eventUserDAO->removeEventUser($eventId, $user->getId());
}

// Handle delete event form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteEvent'])) {
    $eventId = $_POST['eventId'];

    // Delete the event
    $event = $eventDAO->getEventById($eventId);

    if ($event && $event->getHost() === $user->getId()) {
        $eventDAO->deleteEvent($event);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include'inHeader.html'?>
    <div id="body"> 
        <h1>Events Created by You</h1>
        <div class="event-list">
            <?php foreach ($createdEvents as $event): ?>
                <div class="event">
                    <h3><?php echo $event->getName(); ?></h3>
                    <p><?php echo $event->getDescription(); ?></p>
                    <p>Date: <?php echo $event->getDate(); ?></p>
                    <p>Location: <?php echo $event->getLocation(); ?></p>
                    <form method="post">
                        <input type="hidden" name="eventId" value="<?php echo $event->getId(); ?>">
                        <button type="submit" name="deleteEvent">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <h1>Events Joined by You</h1>
        <div class="event-list">
            <?php foreach ($joinedEvents as $event): ?>
                <div class="event">
                    <h3><?php echo $event->getName(); ?></h3>
                    <p><?php echo $event->getDescription(); ?></p>
                    <p>Date: <?php echo $event->getDate(); ?></p>
                    <p>Location: <?php echo $event->getLocation(); ?></p>
                    <form method="post">
                        <input type="hidden" name="eventId" value="<?php echo $event->getId(); ?>">
                        <button type="submit" name="unjoinEvent">Unjoin</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
