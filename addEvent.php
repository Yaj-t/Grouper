<?php
require_once 'EventDAO.php';
require_once 'User.php';
// require_once 'UserDAO.php';
session_start();
// $dao = new UserDAO();
// $user = $dao->getUserByEmail("carl@gmail.com");
// $_SESSION["user"] = serialize($user);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $name = $_POST['myname'];
    $date = $_POST['mydate'];
    $location = $_POST['mylocation'];
    $description = $_POST['mydescription'];
    $host = $_SESSION["user"];
    $host = unserialize($host);
    $host = $host->getId();

    // Insert the event into the database
    $event = new Event(null, $host, $name, $description, $date, $location);
    $eventDAO = new EventDAO();
    $success = $eventDAO->createEvent($event);

    if ($success) {
        echo "Event added successfully!";
    } else {
        $error = "Error adding event.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php       
        include 'inHeader.html';
    ?>
    <div id = "body">
        <form method="post" action="addEvent.php">
            <div id="contents">
                <div >
                    <a>Name:<a>
                    <input type="text" class="inputform" name="myname"><br>
                </div>
            </div>
            <div id="contents">
                <div>
                    <a>Location:<a>
                    <input type="text" class="inputform" name="mylocation"><br>
                </div>
                <div>
                    <a>Date:<a>
                    <input type="date" class="inputform" name="mydate"><br>
                </div>
            </div>
            <div id="contents">
                <div>
                    <a>Description:<a>
                    <input type="text" class="description" name="mydescription"><br>
                </div>
            </div>
            <div id="contents">
                <button type="submit" class="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
    <?php if (!empty($error)) { ?>
        <div class="error-container">
            <p class="error-message"><?php echo $error; ?></p>
        </div>
    <?php } ?>
</body>
</html>
