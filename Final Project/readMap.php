<?php 
//Map information

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
	// Incorporates QUERY 2 from Milestone 3 -- Nested Query
	// Purpose: Answers the question which maps are standard maps (convoy, convergence, domination)?
	// *******************

	
	// standard maps (convoy, convergence, domination)
	$query = "SELECT Map.Map_ID, Map.Map_Name AS Standard_Maps, Game_Mode.Map_Mode as Game_Mode, Map.Map_Release 
	FROM Map LEFT JOIN Game_Mode ON Game_Mode.Mode_ID = Map.Mode_ID 
	WHERE Map.Mode_ID IN (SELECT Mode_ID FROM Game_Mode WHERE Map_Mode = 'Convoy' OR Map_Mode = 'Convergence'
	OR Map_Mode = 'Domination') 
	ORDER BY Map_Mode";

	 //  Prepare and execute query
	 $stmt5 = $mysqli -> prepare($query);
	 $stmt5 -> execute();
 
	 if ($stmt5) {
		echo '<br><br><br><center><h5>Incorporates Query 2 - Nested Query</h5>';
		echo '<h5>Purpose: Answers the following question: which maps are standard maps (Convoy, Convergence, Domination)?</h5>';
		 echo "<div class='row'>";
		 echo "<h3>Standard Maps</h3>";
		 echo "<table>";
		 echo "<thead>";
		 echo "<tr><th></th><th>Map Name</th><th>Game Mode</th><th>Map Release Date</th><th></th></tr>";
		 echo "</thead>";
		 echo "<tbody>";
 
		 while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
			 // Retrieve information from query results
			 $ID = $row['Map_ID'];
			 $ID = (int)$ID;
 
			 $name = $row['Standard_Maps'];
			 $mode = $row['Game_Mode'];
			 $release = $row['Map_Release'];
 
			 echo "<tr>";
			 // outputs a red x that links to deleting a map
			 echo "<td><a href='deleteMap.php?id=".urlencode($ID)."' onclick=\"return confirm('Are you sure you want to delete?');\"><img src='red_x_icon.jpg' alt='Delete button' height=15 width=15></a></td>";
			 // outputs information related to the character
			 echo "<td>".$name."</td>";
			 echo "<td>".$mode."</td>";
			 echo "<td>".$release."</td>";

			 // outputs an edit button that links to editing the map
			 echo "<td><a href='updateMap.php?id=".urlencode($ID)."'><img src = 'pencil_icon.jpg' alt = 'Edit button' height=30 width=30 ></a></td>";
			 echo "</tr>";
		 }
		 echo "</tbody>";
		 echo "</table>";
	}
	
	// arcade maps (conquest, doom match)
	$query = "SELECT Map.Map_ID, Map.Map_Name AS Arcade_Maps, Game_Mode.Map_Mode as Game_Mode, Map.Map_Release 
	FROM Map LEFT JOIN Game_Mode ON Game_Mode.Mode_ID = Map.Mode_ID 
	WHERE Map.Mode_ID IN (SELECT Mode_ID FROM Game_Mode WHERE Map_Mode = 'Conquest' OR Map_Mode = 'Doom Match') 
	ORDER BY Map_Mode";

	 //  Prepare and execute query
	 $stmt6 = $mysqli -> prepare($query);
	 $stmt6 -> execute();
 
	 if ($stmt6) {
		echo '<br><br><br><center><h5>Incorporates a nested query: </h5>';
		echo '<h5>Purpose: Answers the following question: which maps are arcade maps (Conquest, Doom Match)?</h5>';
		 echo "<div class='row'>";
		 echo "<center>";
		 echo "<h3>Arcade Maps</h3>";
		 echo "<table>";
		 echo "<thead>";
		 echo "<tr><th></th><th>Map Name</th><th>Game Mode</th><th>Map Release Date</th><th></th></tr>";
		 echo "</thead>";
		 echo "<tbody>";
 
		 while($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
			 // Retrieve information from query results
			 $ID = $row['Map_ID'];
			 $ID = (int)$ID;
 
			 $name = $row['Arcade_Maps'];
			 $mode = $row['Game_Mode'];
			 $release = $row['Map_Release'];
 
			 echo "<tr>";
			 // outputs a red x that links to deleting a map
			 echo "<td><a href='deleteMap.php?id=".urlencode($ID)."' onclick=return confirm('Are you sure you want to delete?');><img src='red_x_icon.jpg' alt='Delete button' height=15 width=15></a></td>";
			 // outputs information related to the character
			 echo "<td>".$name."</td>";
			 echo "<td>".$mode."</td>";
			 echo "<td>".$release."</td>";

			 // outputs an edit button that links to editing the map
			 echo "<td><a href='updateMap.php?id=".urlencode($ID)."'><img src = 'pencil_icon.jpg' alt = 'Edit button' height=30 width=30 ></a></td>";
			 echo "</tr>";
		 }
		 echo "</tbody>";
		 echo "</table>";
	}

	// training maps (practice range, tutorial)
	$query = "SELECT Map.Map_ID, Map.Map_Name AS Training_Maps, Game_Mode.Map_Mode as Game_Mode, Map.Map_Release 
	FROM Map LEFT JOIN Game_Mode ON Game_Mode.Mode_ID = Map.Mode_ID 
	WHERE Map.Mode_ID IN (SELECT Mode_ID FROM Game_Mode WHERE Map_Mode = 'Practice Range' OR Map_Mode = 'Tutorial') 
	ORDER BY Map_Mode";

	 //  Prepare and execute query
	 $stmt6 = $mysqli -> prepare($query);
	 $stmt6 -> execute();
 
	 if ($stmt6) {
		echo '<br><br><br><center><h5>Incorporates a nested query: </h5>';
		echo '<h5>Purpose: Answers the following question: which maps are training maps (Practice Range, Tutorial)?</h5>';
		 echo "<div class='row'>";
		 echo "<center>";
		 echo "<h3>Training Maps</h3>";
		 echo "<table>";
		 echo "<thead>";
		 echo "<tr><th></th><th>Map Name</th><th>Game Mode</th><th>Map Release Date</th><th></th></tr>";
		 echo "</thead>";
		 echo "<tbody>";
 
		 while($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
			 // Retrieve information from query results
			 $ID = $row['Map_ID'];
			 $ID = (int)$ID;
 
			 $name = $row['Training_Maps'];
			 $mode = $row['Game_Mode'];
			 $release = $row['Map_Release'];
 
			 echo "<tr>";
			 // outputs a red x that links to deleting a map
			 echo "<td><a href='deleteMap.php?id=".urlencode($ID)."' onclick=return confirm('Are you sure you want to delete?');><img src='red_x_icon.jpg' alt='Delete button' height=15 width=15></a></td>";
			 // outputs information related to the character
			 echo "<td>".$name."</td>";
			 echo "<td>".$mode."</td>";
			 echo "<td>".$release."</td>";

			 // outputs an edit button that links to editing the map
			 echo "<td><a href='updateMap.php?id=".urlencode($ID)."'><img src = 'pencil_icon.jpg' alt = 'Edit button' height=30 width=30 ></a></td>";
			 echo "</tr>";
		 }
		 echo "</tbody>";
		 echo "</table>";
	}

	// link to add a map
	echo "<h4><a href='createMap.php'>Add a Map</a></h4>";
    echo "<br /><br />";
	echo "</center>";
	echo "</div>";

    // add footer
    echo "<br /><p>&laquo:<a href='rivalsIndex.php'>Back to Main Page</a></p>";
    new_footer("Marvel Rivals Database");	
    Database::dbDisconnect($mysqli);
?>