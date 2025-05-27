<?php 
    // required files
    require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

    //header
    new_header("Marvel Rivals Database"); 

    // output message if there is one
    if (($output = message()) !== null) {
		echo $output;
	}

    $_SESSION['message'] = null;

     // connect to database
    $mysqli = Database::dbConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    // Character information
    $query = "SELECT Char_ID, Char_Name, Role_Name, Attack_Name,
        Health, Move_Speed, Win_Rate, Pick_Rate, Difficulty,
        Char_Release FROM Characters
        NATURAL JOIN Roles
        NATURAL JOIN Attack_Type
        ORDER BY Char_Name";

    //  Prepare and execute query
	$stmt1 = $mysqli -> prepare($query);
	$stmt1 -> execute();

    if ($stmt1) {
		echo "<br><br><div class='row'>";
		echo "<center>";
		echo "<h3>Character Information</h3>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th></th><th>Name</th><th>Role</th><th>Attack Type</th><th>Health</th>
            <th>Movement Speed (m/s)</th><th>Win Rate</th><th>Pick Rate</th><th>Difficulty</th><th>Release Date</th>
            <th></th></tr>";
		echo "  </thead>";
		echo "  <tbody>";

		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
			// Retrieve information from query results
            $ID = $row['Char_ID'];
            $ID = (int)$ID;

			$name = $row['Char_Name'];
			$role = $row['Role_Name'];
			$attack = $row['Attack_Name'];
			$health = $row['Health'];
			$move = $row['Move_Speed'];
            $win = $row['Win_Rate'];
            $pick = $row['Pick_Rate'];
            $difficulty = $row['Difficulty'];
            $release = $row['Char_Release'];

			echo "<tr>";
			// outputs a red x that links to deleting a character

			echo "<td><a href='deleteCharacter.php?id=".urlencode($ID)."' onclick=\"return confirm('Are you sure you want to delete?');\"><img src='red_x_icon.jpg' alt='Delete button' height=15 width=15></a></td>";
			 // outputs information related to the character
            echo "<td>".$name."</td>";
			echo "<td>".$role."</td>";
			echo "<td>".$attack."</td>";
			echo "<td>".$health."</td>";
            echo "<td>".$move."</td>";
            echo "<td>".$win."</td>";
            echo "<td>".$pick."</td>";
            echo "<td>".$difficulty."</td>";
            echo "<td>".$release."</td>";

            // outputs an edit button that links to editing a character
			echo "<td><a href='updateCharacter.php?id=".urlencode($ID)."'><img src = 'pencil_icon.jpg' alt = 'Edit button' height=30 width=30 ></a></td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
        
        // link to add a character
		echo "<h4><a href='createCharacter.php'>Add a Character</a></h4>";
		echo "<br /><br />";
		echo "</center>";
		echo "</div>";
    }

    // add footer
    echo "<br /><p>&laquo:<a href='rivalsIndex.php'>Back to Main Page</a></p>";
    new_footer("Marvel Rivals Database");	
    Database::dbDisconnect($mysqli);
?>