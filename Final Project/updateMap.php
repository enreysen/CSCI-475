<?php
//  Update Map
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Update Map"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//  Output message
if (($output = message()) !== null) {
    echo $output;
}
$_SESSION['message'] = null;

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("SELECT * FROM Map WHERE Map_ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //  Map exists
    if (!$row) {
        $_SESSION["message"] = "Map not found.";
        redirect("readMap.php");
    }

    $stmtModes = $mysqli->query("SELECT Mode_ID, Map_Mode FROM Game_Mode");
    $modes = $stmtModes->fetchAll(PDO::FETCH_ASSOC);

    //  Formatting
    echo "<center>";
    echo "<div class='row'>";
    echo "<label for='left-label' class='left inline'>";
    
    echo "<form action='updateMap.php?id=" . urlencode($id) . "' method='POST'>";
    echo "<p>Map Name: <input type='text' name='Map_Name' value='" . htmlentities($row['Map_Name']) . "'></p>";

    echo "<p>Game Mode: <select name='Mode_ID'>";
    foreach ($modes as $mode) {
        echo "<option value='" . $mode['Mode_ID'] . "'";
        if ($mode['Mode_ID'] == $row['Mode_ID']) {
            echo " selected";
        }
        echo ">" . htmlentities($mode['Map_Mode']) . "</option>";
    }
    echo "</select></p>";

    echo "<p>Map Release Date: <input type='date' name='Map_Release' value='" . htmlentities($row['Map_Release']) . "'></p>";

    //  Submit button
    echo "<input type='submit' name='submit' class='button tiny round' value='Update Map'>";
    echo "</form>";

    echo "</label>";
    echo "</div>";
    echo "</center>";

} elseif (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $mapName = $_POST['Map_Name'];
    $modeID = $_POST['Mode_ID'];
    $mapRelease = $_POST['Map_Release'];

    //  Check if same map name already exists (excluding itself)
    $stmtCheckName = $mysqli->prepare("SELECT Map_ID FROM Map WHERE Map_Name = ? AND Map_ID != ?");
    $stmtCheckName->execute([$mapName, $id]);
    if ($stmtCheckName->rowCount() > 0) {
        $_SESSION["message"] = "A map with that name already exists.";
        redirect("updateMap.php?id=" . urlencode($id));
    }


    //  Check if any field is empty
    if (empty($mapName) || empty($modeID) || empty($mapRelease)) {
        $_SESSION["message"] = "All fields are required.";
        redirect("updateMap.php?id=" . urlencode($id));
    }

    $stmt = $mysqli->prepare("UPDATE Map SET Map_Name = ?, Mode_ID = ?, Map_Release = ? WHERE Map_ID = ?");

    //  Success
    if ($stmt->execute([$mapName, $modeID, $mapRelease, $id])) {
        $_SESSION["message"] = "Map updated successfully.";
        redirect("readMap.php");
    //  Fail
    } else {
        $_SESSION["message"] = "Map update failed.";
        redirect("updateMap.php?id=" . urlencode($id));
    }

//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readMap.php");
}

// Add footer
echo "<br /><p><a href='rivalsIndex.php'>&laquo; Back to Main Page</a></p>";
new_footer("Marvel Rivals Database");	
Database::dbDisconnect($mysqli);
?>