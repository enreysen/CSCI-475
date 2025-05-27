<?php
// Update Season
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Update Season"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// output message if there is one
if (($output = message()) !== null) {
    echo $output;
}
$_SESSION['message'] = null;

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("SELECT * FROM Season WHERE Season_ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Season exists
    if (!$row) {
        $_SESSION["message"] = "Season not found.";
        redirect("readSeason.php");
    }

    // Formatting
    echo "<center>";
    echo "<div class='row'>";
    echo "<label for='left-label' class='left inline'>";

    echo "<form action='updateSeason.php?id=" . urlencode($id) . "' method='POST'>";
    echo "<p>Season Name: <input type='text' name='Season_Name' value='" . htmlentities($row['Season_Name']) . "'></p>";
    echo "<p>Season Description: <input type='text' name='Season_Description' value='" . htmlentities($row['Season_Description']) . "'></p>";
    echo "<p>Start Date (YYYY-MM-DD): <input type='date' name='Start_Date' value='" . htmlentities($row['Start_Date']) . "'></p>";
    echo "<p>End Date (YYYY-MM-DD): <input type='date' name='End_Date' value='" . htmlentities($row['End_Date']) . "'></p>";

    echo "<input type='submit' name='submit' class='button tiny round' value='Update Season'>";
    echo "</form>";

    echo "</label>";
    echo "</div>";
    echo "</center>";

} elseif (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $seasonName = $_POST['Season_Name'];
    $seasonDescription = $_POST['Season_Description'];
    $startDate = $_POST['Start_Date'];
    $endDate = $_POST['End_Date'];

    //  Check if any fields are empty
    if (empty($seasonName) || empty($seasonDescription) || empty($startDate) || empty($endDate)) {
        $_SESSION["message"] = "All fields are required.";
        redirect("updateSeason.php?id=" . urlencode($id));
    }

     //  Check if same season name already exists (excluding itself)
     $stmtCheckName = $mysqli->prepare("SELECT Season_ID FROM Season WHERE Season_Name = ? AND Season_ID != ?");
     $stmtCheckName->execute([$seasonName, $id]);
     if ($stmtCheckName->rowCount() > 0) {
         $_SESSION["message"] = "A season with that name already exists.";
         redirect("updateSeason.php?id=" . urlencode($id));
     }
    
    //  Check if start date is after end date
    if ($startDate > $endDate) {
        $_SESSION["message"] = "Start Date cannot be after End Date.";
        redirect("updateSeason.php?id=" . urlencode($id));
    }

    //  Check for overlapping seasons
    $query = "SELECT Season_ID FROM Season WHERE Season_ID != ? AND ((Start_Date <= ? AND End_Date >= ?) OR (Start_Date <= ? AND End_Date >= ?) OR (Start_Date >= ? AND End_Date <= ?))";
    $stmtCheck = $mysqli->prepare($query);
    $stmtCheck->execute([$id, $startDate, $startDate, $endDate, $endDate, $startDate, $endDate]);
    
    if ($stmtCheck->rowCount() > 0) {
        $_SESSION["message"] = "Season dates overlap with another existing season.";
        redirect("updateSeason.php?id=" . urlencode($id));
    }

    //  Update Season
    $stmt = $mysqli->prepare("UPDATE Season SET Season_Name = ?, Season_Description = ?, Start_Date = ?, End_Date = ? WHERE Season_ID = ?");
    
    if ($stmt->execute([$seasonName, $seasonDescription, $startDate, $endDate, $id])) {
        $_SESSION["message"] = "Season updated successfully.";
        redirect("readSeason.php");
    } else {
        $_SESSION["message"] = "Season update failed.";
        redirect("updateSeason.php?id=" . urlencode($id));
    }

//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readSeason.php");
}

//  Add footer
echo "<br /><p><a href='rivalsIndex.php'>&laquo; Back to Main Page</a></p>";
new_footer("Marvel Rivals Database");	
Database::dbDisconnect($mysqli);
?>
