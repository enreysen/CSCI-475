<?php
//  Delete Season
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Delete Season"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //  Delete Rank Rewards
    $stmt1 = $mysqli->prepare("DELETE FROM Rank_Rewards WHERE Season_ID = ?");
    $stmt1->execute([$id]);

    //  Delete Season
    $stmt2 = $mysqli->prepare("DELETE FROM Season WHERE Season_ID = ?");
    
    // Success
    if ($stmt2->execute([$id])) {
        $_SESSION["message"] = "Season deleted successfully.";
        redirect("readSeason.php");
    // Fail
    } else {
        $_SESSION["message"] = "Season deletion failed.";
        redirect("readSeason.php");
    }
//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readSeason.php");
}
?>