<?php
//  Delete Reward
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Delete Reward"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("DELETE FROM Rank_Rewards WHERE Reward_ID = ?");
    
    //  Success
    if ($stmt->execute([$id])) {
        $_SESSION["message"] = "Reward deleted successfully.";
        redirect("readSeason.php");
    //  Fail
    } else {
        $_SESSION["message"] = "Reward deletion failed.";
        redirect("readSeason.php");
    }

//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readSeason.php");
}
?>