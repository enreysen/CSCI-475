<?php
//  required files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Marvel Rivals Database"); 

//  connect to database
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

//  output message
if (($output = message()) !== null) {
	echo $output;
}
$_SESSION['message'] = null;

echo "<h3>Add a Map</h3>";
echo "<center>";
echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";

//  check if form was submitted
if (isset($_POST["submit"])) {

    $mapName = $_POST['Map_Name'] ?? '';
    $mapMode = $_POST['Map_Mode'] ?? '';
    $mapRelease = $_POST['Map_Release'] ?? '';

    //  check if values are set
    if (!empty($mapName) && !empty($mapMode) && !empty($mapRelease)) {
        
        //  check if name is already taken
        $query = "SELECT Map_ID FROM Map WHERE Map_Name = ?";
        $stmtCheck = $mysqli->prepare($query);
        $stmtCheck->execute([$mapName]);

        if ($stmtCheck) {
            $count = $stmtCheck->rowCount();
            if ($count > 0) {
                $_SESSION["message"] = "Unable to add Map. Map name already exists.";
                redirect("createMap.php");
            } else {
                //  Insert new map
                $query = "INSERT INTO Map (Map_Name, Mode_ID, Map_Release) VALUES (?, ?, ?)";
                $stmtInsert = $mysqli->prepare($query);
                if ($stmtInsert->execute([$mapName, (int)$mapMode, $mapRelease])) {
                    $_SESSION["message"] = "Map ".$mapName." added!";
                    redirect("readMap.php");
                } else {
                    $_SESSION["message"] = "Unable to add Map.";
                    redirect("createMap.php");
                }
            }
        } else {
            $_SESSION["message"] = "Error checking map name.";
            redirect("createMap.php");
        }

    } else {
        //  If any field was empty
        $_SESSION["message"] = "Unable to add Map. Fill in all information!";
        redirect("createMap.php");
    }

} else {
    //  create a form that posts to this page
    echo '<div><form method="POST" action="createMap.php">';
    echo '<p>Map Name: <input type="text" name="Map_Name"></p>';

    //  output game modes
    $query = "SELECT Mode_ID, Map_Mode FROM Game_Mode";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();		

    echo '<p>Map Game Mode: <select name="Map_Mode"><option></option>';
    if ($stmt2) {
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $modeName = $row['Map_Mode'];
            $modeID = $row['Mode_ID'];
            echo '<option value="'.$modeID.'">'.htmlentities($modeName).'</option>';
        }
    }
    echo '</select></p>';

    echo '<p>Map Release Date: <input type="date" name="Map_Release" lang="en-CA"></p>';

    //  submit button
    echo '<input type="submit" name="submit" class="button tiny round" value="Add Map">';
    echo '</form></div>';
}

//  Add footer
echo "<br /><p><a href='rivalsIndex.php'>&laquo; Back to Main Page</a></p>";
new_footer("Marvel Rivals Database");	
Database::dbDisconnect($mysqli);
?>
