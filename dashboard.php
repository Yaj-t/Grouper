<?php
require_once 'EventDAO.php';
require_once 'EventUserDAO.php';
require_once 'User.php';
require_once 'Event.php';

session_start();
$eventDAO = new EventDAO();
$eventUserDAO = new EventUserDAO();
$user = unserialize($_SESSION['user']);

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
// Check if the search query is submitted
if (isset($_GET['event'])) {
    // Get the search query from the user
    $searchQuery = $_GET['event'];

    // Call the searchEvents method to retrieve the search results
    $searchResults = $eventDAO->searchEvents($searchQuery);
} else {
    // Default empty search results
    $searchResults = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['joinEvent'])) {
    $eventId = $_POST['eventId'];
    
    // Add the user to the event
    $eventUserDAO->joinEvent($eventId, $user->getId());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <?php       
        include 'inHeader.html';
    ?>
    <div id="body"> 
        <p id="title" class="glow">Groupr</p>
        <form name="search" method="get" action="dashboard.php">
            <input id="search" type="text" placeholder="Search for events" name="event">
            <input type="submit" class="button">
        </form>
    </div>

    <div id="contents">
        <?php if (isset($_GET['event'])): ?>
            <h2 class="glow">Search Results</h2>
            <?php if (empty($searchResults)): ?>
                <p class="glow">No results found.</p>
            <?php else: ?>
                <div class="event-list">
                    <?php foreach ($searchResults as $event): ?>
                        <div class="event">
                            <h3><?php echo $event->getName(); ?></h3>
                            <p><?php echo $event->getDescription(); ?></p>
                            <p>Date: <?php echo $event->getDate(); ?></p>
                            <p>Location: <?php echo $event->getLocation(); ?></p>
                            <?php if ($event->getHost() === $user->getId()): ?>
                                <p>You are the host of this event.</p>
                            <?php elseif (!$eventUserDAO->isUserJoined($event->getId(), $user->getId())): ?>
                                <form method="post">
                                    <input type="hidden" name="eventId" value="<?php echo $event->getId(); ?>">
                                    <button type="submit" name="joinEvent">Join</button>
                                </form>
                            <?php else: ?>
                                <p>You have joined this event.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
