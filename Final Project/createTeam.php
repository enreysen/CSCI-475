<?php
// required files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Marvel Rivals Database"); 

// connect to database
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// output message if there is one
if (($output = message()) !== null) {
    echo $output;
}
$_SESSION['message'] = null;

echo "<h3>Add a Team Up</h3>";
echo "<center>";
echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";

if (isset($_POST["submit"])) {
    if (!empty($_POST['Team_Name']) && !empty($_POST['Characters']) && !empty($_POST['Team_Description'])) {

        $charactersSelected = $_POST['Characters'];
        $count = count($charactersSelected);

        //  Check if character selection is between 2 and 6
        if ($count < 2 || $count > 6) {
            $_SESSION["message"] = "You must select between 2 and 6 characters.";
            redirect("createTeam.php");
        }

        //  ensure team name does not already exist
        $query = "SELECT Team_ID FROM Team_Up WHERE Team_Name = ?";
        $stmtCheck = $mysqli->prepare($query);
        $stmtCheck->execute([$_POST['Team_Name']]);
        
        if ($stmtCheck) {
            $countTeam = $stmtCheck->rowCount();
            
            if ($countTeam > 0) {
                $_SESSION["message"] = "Unable to add Team Up. Team name already exists.";
                redirect("createTeam.php");
            } else {
                //  Check if exact same character set already exists
                $query = "SELECT TC.Team_ID
                          FROM Team_Characters TC
                          INNER JOIN (
                              SELECT Team_ID
                              FROM Team_Characters
                              GROUP BY Team_ID
                              HAVING COUNT(*) = ?
                          ) AS T ON TC.Team_ID = T.Team_ID
                          WHERE TC.Char_ID IN (" . implode(',', array_fill(0, count($charactersSelected), '?')) . ")
                          GROUP BY TC.Team_ID
                          HAVING COUNT(*) = ?";
                $params = array_merge([count($charactersSelected)], $charactersSelected, [count($charactersSelected)]);
                $stmtCheckDup = $mysqli->prepare($query);
                $stmtCheckDup->execute($params);

                if ($stmtCheckDup->rowCount() > 0) {
                    $_SESSION["message"] = "Error: A team with the exact same set of characters already exists.";
                    redirect("createTeam.php");
                }

                // create and prepare query to insert information into Team_Up table
                $query = "INSERT INTO Team_Up (Team_Name, Team_Description) VALUES (?, ?)";
                $stmt1 = $mysqli->prepare($query);
                $stmt1->execute([$_POST['Team_Name'], $_POST['Team_Description']]);

                if ($stmt1) {
                    // get Team ID
                    $query = "SELECT Team_ID FROM Team_Up WHERE Team_Name = ?";
                    $stmt3 = $mysqli->prepare($query);
                    $stmt3->execute([$_POST['Team_Name']]);
                    $row = $stmt3->fetch(PDO::FETCH_ASSOC);
                    $teamID = (int)$row['Team_ID'];

                    // insert all selected characters
                    $query = "INSERT INTO Team_Characters (Team_ID, Char_ID) VALUES (?, ?)";
                    $stmtInsert = $mysqli->prepare($query);
                    foreach ($charactersSelected as $charID) {
                        $stmtInsert->execute([$teamID, (int)$charID]);
                    }

                    $_SESSION["message"] = "Team Up " . htmlentities($_POST['Team_Name']) . " added!";
                    redirect("readTeam.php");
                }
            }
        }
    //  Invalid input
    } else {
        $_SESSION["message"] = "Unable to add Team Up. Fill in all information!";
        redirect("createTeam.php");
    }
} else {
    echo '<div><form method="POST" action="createTeam.php">';
    echo '<p>Team Name: <input type="text" name="Team_Name"></p>';

    //  Characters checkboxes
    $query = "SELECT Char_ID, Char_Name FROM Characters ORDER BY Char_Name ASC";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();

    echo '<p>Characters (select 2–6):</p>';
    if ($stmt2) {
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $charID = $row['Char_ID'];
            $charName = $row['Char_Name'];
            echo '<input type="checkbox" name="Characters[]" value="'.$charID.'"> ' . htmlentities($charName) . '<br>';
        }
    }

    echo '<p>Team Description:<br>';
    echo '<textarea name="Team_Description" rows="5" cols="50"></textarea></p>';

    //  submit button and closing the form
    echo '<input type="submit" name="submit" class="button tiny round" value="Add Team Up">';
    echo '</form></div>';
}

echo "</label>";
echo "</div>";
echo "</center>";

// back to main page
echo "<br /><p><a href='readTeam.php'>&laquo; Back to Main Page</a></p>";
?>
