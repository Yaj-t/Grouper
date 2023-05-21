<?php
require_once 'EventDAO.php';
require_once 'Event.php';
require_once 'User.php';
require_once 'EventUserDAO.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = unserialize($_SESSION['user']);

$eventDAO = new EventDAO();
$eventUserDAO = new EventUserDAO();

$createdEvents = $eventDAO->getEventsCreatedByUser($user->getId());

$joinedEvents = $eventUserDAO->getEventsByUser($user->getId());

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
        <h1>Event List</h1>
        <h2>Events Created by You</h2>
        <div class="event-list">
            <?php foreach ($createdEvents as $event): ?>
                <div class="event">
                    <h3><?php echo $event->getName(); ?></h3>
                    <p><?php echo $event->getDescription(); ?></p>
                    <p>Date: <?php echo $event->getDate(); ?></p>
                    <p>Location: <?php echo $event->getLocation(); ?></p>
                    <p>You are the host of this event.</p>
                </div>
            <?php endforeach; ?>
        </div>
        <h2>Events Joined by You</h2>
        <div class="event-list">
            <?php foreach ($joinedEvents as $event): ?>
                <div class="event">
                    <h3><?php echo $event->getName(); ?></h3>
                    <p><?php echo $event->getDescription(); ?></p>
                    <p>Date: <?php echo $event->getDate(); ?></p>
                    <p>Location: <?php echo $event->getLocation(); ?></p>
                    <p>You have joined this event.</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
