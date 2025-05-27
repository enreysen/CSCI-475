<?php
//  Delete Characters
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Delete Character"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = (int)$id;

    $query = "DELETE FROM Team_Characters WHERE Char_ID = ?";
    $stmt1 =  $stmt1 = $mysqli->prepare($query);
    $stmt1 -> execute([$id]);
    if ($stmt1){
        $query = "DELETE FROM Characters WHERE Char_ID = ?";
        $stmt2 = $mysqli->prepare($query);
        $stmt2 -> execute([$id]);

        if ($stmt2) {
            $_SESSION["message"] = "Character deleted successfully.";
        } else {
            $_SESSION["message"] = "Character deletion failed.";
        }
        redirect("readCharacter.php");
    } else {
        $_SESSION["message"] = "Invalid action.";
        redirect("readCharacter.php");
    }
}

Database::dbDisconnect($mysqli);
?>
