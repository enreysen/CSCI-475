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

    // Rank information
	$query = "SELECT SUBSTRING_INDEX(Rank_Name, 'I', 1) AS Tier, 
	GROUP_CONCAT(Rank_Name ORDER BY Rank_Name ASC SEPARATOR ', ') AS Tiers,
	Round(SUM(Distributions), 2) AS Percent_of_Players
		FROM Ranks
		GROUP BY Tier
		ORDER BY Percent_of_Players DESC";


	//  Prepare and execute query
	$stmt3 = $mysqli -> prepare($query);
	$stmt3 -> execute();

	if ($stmt3) {
		echo "<br><br><br><center><h5>Incorporates Query 1: Aggregate Query</h5>";
		echo '<h5>Purpose: Sums the tiers of each rank and lists the ranks in descending order by player percentage.</h5>';
		echo "<br><br><div class='row'>";
		echo "<h3>Rank Information</h3>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th>Rank Name</th><th>Tiers</th><th>Player Distribution</th></tr>";
		echo "  </thead>";
		echo "  <tbody>";

		while($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
			// Retrieve information from query results

			$name = $row['Tier'];
			$tiers = $row['Tiers'];
			$distributions = $row['Percent_of_Players'];

			echo "<tr>";
			// outputs information related to the character
			echo "<td>".$name."</td>";
			echo "<td>$tiers</td>";
			echo "<td>".$distributions."</td>";

			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		
		echo "</center>";
		echo "</div>";
	}

    // add footer
    echo "<br /><p>&laquo:<a href='rivalsIndex.php'>Back to Main Page</a></p>";
    new_footer("Marvel Rivals Database");	
    Database::dbDisconnect($mysqli);
?>