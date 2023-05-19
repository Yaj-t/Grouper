<?php
require_once 'EventDAO.php';
require_once 'User.php';
//require_once 'UserDAO.php';
 session_start();
// $dao = new UserDAO();
// $user = $dao->getUserByEmail("carl@gmail.com");
// $_SESSION["user"] = serialize($user);

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
        echo "Error adding event.";
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
    <link rel="stylesheet" href="addevent.css">
</head>
<body>
<div class="topnav">
        <div class="logo">
            <a href="eventpage.html" class="Logo">Groupr</a>
        </div>
        <div class="searchbar">
            <input type="text" placeholder="Search Events..">
        </div>
        <div class="links">
            <a href="">Plan Event</a>
            <a href="">FAQ</a>
            <a href="">Report</a>
            <a href="">Log In</a>
        </div>
    </div>
    <div class="forms">
        <form method="post" action="addEvent.php">
            <div class="rowdiv">
                <div class="inputdiv">
                    <a>Name:<a>
                    <input type="text" class="inputform" name="myname"><br>
                </div>
            </div>
            <div class="rowdiv">
                <div class="inputdiv">
                    <a>Location:<a>
                    <input type="text" class="inputform" name="mylocation"><br>
                </div>
                <div class="inputdiv">
                    <a>Date:<a>
                    <input type="date" class="inputform" name="mydate"><br>
                </div>
            </div>
            <div class="descdiv">
                <div class="inputdiv">
                    <a>Description:<a>
                    <input type="text" class="description" name="mydescription"><br>
                </div>
            </div>
            <div class="buttondiv">
                <button type="submit" class="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
    <?php if (isset($error)) { ?>
        <div class = "error-container">
            <p class="error-message"><?php echo $error; ?></p>
        </div>
      
    <?php } ?>
</body>
</html>
