<?php
//  Update Characters
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Update Character"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 // output message (if there is one)
 if (($output = message()) !== null) {
    echo $output;
}

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("SELECT * FROM Characters WHERE Char_ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //  Exists
    if (!$row) {
        $_SESSION["message"] = "Character not found.";
        redirect("readCharacter.php");
    }

    $stmtRoles = $mysqli->query("SELECT Role_ID, Role_Name FROM Roles ORDER BY Role_ID ASC");
    $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);

    $stmtAttacks = $mysqli->query("SELECT Attack_ID, Attack_Name FROM Attack_Type ORDER BY Attack_ID ASC");
    $attacks = $stmtAttacks->fetchAll(PDO::FETCH_ASSOC);

    //  Formatting
    echo "<center>";
    echo "<div class='row'>";
    echo "<label for='left-label' class='left inline'>";

    echo "<form action='updateCharacter.php?id=" . urlencode($id) . "' method='POST'>";
    echo "<p>Character Name: <input type='text' name='Char_Name' value='" . htmlentities($row['Char_Name']) . "'></p>";

    //  Role
    echo "<p>Role: <select name='Role_ID'>";
    foreach ($roles as $role) {
        echo "<option value='" . $role['Role_ID'] . "'";
        if ($role['Role_ID'] == $row['Role_ID']) {
            echo " selected";
        }
        echo ">" . htmlentities($role['Role_Name']) . "</option>";
    }
    echo "</select></p>";

    //  Attack
    echo "<p>Attack Type: <select name='Attack_ID'>";
    foreach ($attacks as $attack) {
        echo "<option value='" . $attack['Attack_ID'] . "'";
        if ($attack['Attack_ID'] == $row['Attack_ID']) {
            echo " selected";
        }
        echo ">" . htmlentities($attack['Attack_Name']) . "</option>";
    }
    echo "</select></p>";

    //  Other stuff
    echo "<p>Health: <input type='number' name='Health' value='" . htmlentities($row['Health']) . "'></p>";
    echo "<p>Move Speed: <input type='text' name='Move_Speed' value='" . htmlentities($row['Move_Speed']) . "'></p>";
    echo "<p>Win Rate: <input type='text' name='Win_Rate' value='" . htmlentities($row['Win_Rate']) . "'></p>";
    echo "<p>Pick Rate: <input type='text' name='Pick_Rate' value='" . htmlentities($row['Pick_Rate']) . "'></p>";

    echo "<p>Difficulty: <select name='Difficulty'>";
    for ($i = 1; $i <= 5; $i++) {
        echo "<option value='" . $i . "'";
        if ($row['Difficulty'] == $i) {
            echo " selected";
        }
        echo ">" . $i . " Star</option>";
    }
    echo "</select></p>";

    echo "<p>Character Release Date (YYYY-MM-DD): <input type='text' name='Char_Release' value='" . htmlentities($row['Char_Release']) . "'></p>";

    //  Submit button
    echo "<input type='submit' name='submit' class='button tiny round' value='Update Character'>";
    echo "</form>";

    echo "</label>";
    echo "</div>";
    echo "</center>";

} elseif (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $charName = $_POST['Char_Name'];
    $roleID = $_POST['Role_ID'];
    $attackID = $_POST['Attack_ID'];
    $health = $_POST['Health'];
    $moveSpeed = $_POST['Move_Speed'];
    $winRate = $_POST['Win_Rate'];
    $pickRate = $_POST['Pick_Rate'];
    $difficulty = $_POST['Difficulty'];
    $charRelease = $_POST['Char_Release'];

    // check if any are empty
    if (!isset($charName, $roleID, $attackID, $health, $moveSpeed, $winRate, $pickRate, $difficulty, $charRelease) ||
        $charName === '' || $roleID === '' || $attackID === '' || $health === '' || $moveSpeed === '' ||
        $winRate === '' || $pickRate === '' || $difficulty === '' || $charRelease === '') {
        $_SESSION["message"] = "Fill out all information.";
        redirect("updateCharacter.php?id=" . urlencode($id));
    }else{
        // then check if the name is already taken

        // if name exists, print out error message
        $query = "SELECT Health FROM Characters WHERE Char_Name = ? AND Char_ID != ?";
        $stmtCheck = $mysqli -> prepare($query);
        // execute query
        $stmtCheck -> execute([$charName, $id]);
            
        if($stmtCheck){
            $count = $stmtCheck -> rowCount();
                
            if($count > 0){
                $_SESSION["message"] = "Unable to add Character. Character name already exists.";
                redirect("updateCharacter.php?id=" . urlencode($id));
            }
        }
    }

    $stmt = $mysqli->prepare("UPDATE Characters 
        SET Char_Name = ?, Role_ID = ?, Attack_ID = ?, Health = ?, Move_Speed = ?, Win_Rate = ?, Pick_Rate = ?, Difficulty = ?, Char_Release = ?
        WHERE Char_ID = ?");

    //  Success
    if ($stmt->execute([$charName, $roleID, $attackID, $health, $moveSpeed, $winRate, $pickRate, $difficulty, $charRelease, $id])) {
        $_SESSION["message"] = "Character updated successfully.";
        redirect("readCharacter.php");
    //  Fail
    } else {
        $_SESSION["message"] = "Character update failed.";
        redirect("updateCharacter.php?id=" . urlencode($id));
    }

//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readCharacter.php");
}

//  Add footer
echo "<br /><p>&laquo:<a href='rivalsIndex.php'>Back to Main Page</a></p>";
new_footer("Marvel Rivals Database");	
Database::dbDisconnect($mysqli);
?>