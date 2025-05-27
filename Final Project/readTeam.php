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

	   //Map information
	// ********************
	// Incorporates Dr. Davidson's queries from Milestone 3:
	//     - For each Team_Name, list all Role_Name on one line - use group-concat.
	//     - For each Team_Name, list all Char_Name on one line - use group concat.
	//
	// *******************
    // Team ups
    $query = "SELECT T.Team_ID, T.Team_Name, GROUP_CONCAT(C.Char_Name ORDER BY C.Char_Name DESC SEPARATOR ', ') AS Characters, 
        GROUP_CONCAT(DISTINCT R.Role_Name) AS Roles, Team_Description FROM Team_Up T
        NATURAL JOIN Team_Characters TC
        NATURAL JOIN Characters C 
        NATURAL JOIN Roles R 
        GROUP BY T.Team_Name";


    //  Prepare and execute query
	$stmt2 = $mysqli -> prepare($query);
	$stmt2 -> execute();

    if ($stmt2) {
		echo "<br><br><br><center><h5>Incorporates Dr. Davidison's Queries:</h5>";
		echo "<h5>Query 1: For each Team_Name, list all Char_Name (Team Characters) on one line - use group concat.</h5>";
		echo "<h5>Query 2: For each Team_Name, list all Role_Name (Team Roles) on one line - use group-concat.</h5>";
		echo "<br><br><div class='row'>";
		echo "<h3>Team Ups</h3>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th></th><th>Team Name</th><th>Team Characters</th><th>Team Roles</th><th>Team Description</th><th></th></tr>";
		echo "  </thead>";
		echo "  <tbody>";

		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
			// Retrieve information from query results
            $ID = $row['Team_ID'];
            $ID = (int)$ID;

            $name = $row['Team_Name'];
			$characters = $row['Characters'];
			$roles = $row['Roles'];
			$description = $row['Team_Description'];

			echo "<tr>";
			// outputs a red x that links to deleting a team up
			echo "<td><a href='deleteTeam.php?id=".urlencode($ID)."' onclick=\"return confirm('Are you sure you want to delete?');\"><img src='red_x_icon.jpg' alt='Delete button' height=30 width=30></a></td>";
			 // outputs information related to the character
            echo "<td>".$name."</td>";
			echo "<td>".$characters."</td>";
			echo "<td>".$roles."</td>";
			echo "<td>".$description."</td>";
            // outputs an edit button that links to editing a team up
			echo "<td><a href='updateTeam.php?id=".urlencode($ID)."'><img src = 'pencil_icon.jpg' alt = 'Edit button' height=70 width=70 ></a></td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
        
        // link to add a team up
		echo "<h4><a href='createTeam.php'>Add a Team Up</a></h4>";
		echo "<br /><br />";
        
		echo "</center>";
		echo "</div>";
    }

    // add footer
    echo "<br /><p>&laquo:<a href='rivalsIndex.php'>Back to Main Page</a></p>";
    new_footer("Marvel Rivals Database");	
    Database::dbDisconnect($mysqli);
?>