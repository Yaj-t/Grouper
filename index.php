<?php
require_once 'EventDAO.php';

// Create an instance of EventDAO
$eventDAO = new EventDAO();

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
        include 'notInHeader.html';
    ?>
    <div id="body"> 
        <p id="title" class="glow">Groupr</p>
        <form name="search" method="get" action="index.php">
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
                <ul>
                    <?php foreach ($searchResults as $event): ?>
                        <li>
                            <strong class="glow">Event ID:</strong> <?php echo $event->getId(); ?><br>
                            <strong class="glow">Host:</strong> <?php echo $event->getHost(); ?><br>
                            <strong class="glow">Name:</strong> <?php echo $event->getName(); ?><br>
                            <strong class="glow">Description:</strong> <?php echo $event->getDescription(); ?><br>
                            <strong class="glow">Date:</strong> <?php echo $event->getDate(); ?><br>
                            <strong class="glow">Location:</strong> <?php echo $event->getLocation(); ?><br>
                        </li>
                        <br>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
