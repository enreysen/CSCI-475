<?php
//  Update Team
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Update Team"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//  Output message
if (($output = message()) !== null) {
    echo $output;
}
$_SESSION['message'] = null;

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("SELECT * FROM Team_Up WHERE Team_ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $_SESSION["message"] = "Team not found.";
        redirect("readTeam.php");
    }

    $stmtCharacters = $mysqli->query("SELECT Char_ID, Char_Name FROM Characters ORDER BY Char_Name ASC");
    $allCharacters = $stmtCharacters->fetchAll(PDO::FETCH_ASSOC);

    $stmtAssigned = $mysqli->prepare("SELECT Char_ID FROM Team_Characters WHERE Team_ID = ?");
    $stmtAssigned->execute([$id]);
    $assignedCharacters = $stmtAssigned->fetchAll(PDO::FETCH_COLUMN, 0);

    //  Formatting
    echo "<center>";
    echo "<div class='row'>";
    echo "<label for='left-label' class='left inline'>";
    
    echo "<form action='updateTeam.php?id=" . urlencode($id) . "' method='POST'>";
    echo "<p>Team Name: <input type='text' name='Team_Name' value='" . htmlentities($row['Team_Name']) . "'></p>";

    echo "<p>Characters:</p>";
    foreach ($allCharacters as $character) {
        echo "<input type='checkbox' name='Characters[]' value='" . $character['Char_ID'] . "'";
        if (in_array($character['Char_ID'], $assignedCharacters)) {
            echo " checked";
        }
        echo "> " . htmlentities($character['Char_Name']) . "<br>";
    }

    echo "<p>Team Description:<br>";
    echo "<textarea name='Team_Description' rows='5' cols='50'>" . htmlentities($row['Team_Description']) . "</textarea></p>";

    echo "<input type='submit' name='submit' class='button tiny round' value='Update Team'>";
    echo "</form>";

    echo "</label>";
    echo "</div>";
    echo "</center>";

//  when the form is submitted
} elseif (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $teamName = trim($_POST['Team_Name']);
    $teamDescription = trim($_POST['Team_Description']);
    $charactersSelected = isset($_POST['Characters']) ? $_POST['Characters'] : [];

    //  Check if fields are empty
    if (empty($teamName) || empty($teamDescription) || empty($charactersSelected)) {
        $_SESSION["message"] = "All fields must be filled, and you must select at least 2 characters.";
        redirect("updateTeam.php?id=" . urlencode($id));
    }

    //  Check character count
    $count = count($charactersSelected);
    if ($count < 2 || $count > 6) {
        $_SESSION["message"] = "You must select between 2 and 6 characters.";
        redirect("updateTeam.php?id=" . urlencode($id));
    }

    //  Check if same team name already exists (excluding itself)
    $stmtCheckName = $mysqli->prepare("SELECT Team_ID FROM Team_Up WHERE Team_Name = ? AND Team_ID != ?");
    $stmtCheckName->execute([$teamName, $id]);
    if ($stmtCheckName->rowCount() > 0) {
        $_SESSION["message"] = "A team with that name already exists.";
        redirect("updateTeam.php?id=" . urlencode($id));
    }

    //  Check if exact same set of characters already exists (excluding itself)
    $query = "SELECT TC.Team_ID
              FROM Team_Characters TC
              INNER JOIN (
                  SELECT Team_ID
                  FROM Team_Characters
                  WHERE Team_ID != ?
                  GROUP BY Team_ID
                  HAVING COUNT(*) = ?
              ) AS T ON TC.Team_ID = T.Team_ID
              WHERE TC.Char_ID IN (" . implode(',', array_fill(0, count($charactersSelected), '?')) . ")
              GROUP BY TC.Team_ID
              HAVING COUNT(*) = ?";
    $params = array_merge([$id, $count], $charactersSelected, [$count]);
    $stmtCheck = $mysqli->prepare($query);
    $stmtCheck->execute($params);

    if ($stmtCheck->rowCount() > 0) {
        $_SESSION["message"] = "Error: A team with the exact same set of characters already exists.";
        redirect("updateTeam.php?id=" . urlencode($id));
    }

    //  Update team name and description
    $stmt = $mysqli->prepare("UPDATE Team_Up SET Team_Name = ?, Team_Description = ? WHERE Team_ID = ?");
    $stmt->execute([$teamName, $teamDescription, $id]);

    //  Delete old character
    $stmtDelete = $mysqli->prepare("DELETE FROM Team_Characters WHERE Team_ID = ?");
    $stmtDelete->execute([$id]);

    //  Insert new character
    $stmtInsert = $mysqli->prepare("INSERT INTO Team_Characters (Team_ID, Char_ID) VALUES (?, ?)");
    foreach ($charactersSelected as $charID) {
        $stmtInsert->execute([$id, $charID]);
    }

    //  Success
    $_SESSION["message"] = "Team updated successfully.";
    redirect("readTeam.php");

//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readTeam.php");
}

//  Add footer
echo "<br /><p><a href='rivalsIndex.php'>&laquo; Back to Main Page</a></p>";
new_footer("Marvel Rivals Database");	
Database::dbDisconnect($mysqli);
?>
