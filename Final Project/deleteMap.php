<?php
//  Delete Map
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Delete Map"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("DELETE FROM Map WHERE Map_ID = ?");
    if ($stmt->execute([$id])) {
        $_SESSION["message"] = "Map deleted successfully.";
        redirect("readMap.php");
    } else {
        $_SESSION["message"] = "Map deletion failed.";
        redirect("readMap.php");
    }
    redirect("readMap.php");
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect(".php");
}
?>
