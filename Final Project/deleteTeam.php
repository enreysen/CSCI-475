<?php
//  Delete Team
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Delete Team"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //  Delete from Team_Characters
    $stmt1 = $mysqli->prepare("DELETE FROM Team_Characters WHERE Team_ID = ?");
    $stmt1->execute([$id]);

    //  Delete from Team_Up
    $stmt2 = $mysqli->prepare("DELETE FROM Team_Up WHERE Team_ID = ?");
    
    if ($stmt2->execute([$id])) {
        $_SESSION["message"] = "Team deleted successfully.";
        redirect("readTeam.php");
    } else {
        $_SESSION["message"] = "Team deletion failed.";
        redirect("readTeam.php");
    }

//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readTeam.php");
}
?>