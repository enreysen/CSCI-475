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

//Season information
$query = "SELECT Season_ID, Season_Name, Season_Description, Start_Date, End_Date FROM Season ORDER BY Start_Date";

//  Prepare and execute query
$stmt4 = $mysqli -> prepare($query);
$stmt4 -> execute();

if ($stmt4) {
    echo "<br><br><div class='row'>";
    echo "<center>";
    echo "<h3>Season Information</h3>";
    echo "<table>";
    echo "<thead>";
    echo "<tr><th></th><th>Name</th><th>Description</th><th>Start Date</th><th>End Date</th>
        <th></th></tr>";
    echo "</thead>";
    echo "<tbody>";

    while($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        // Retrieve information from query results
        $ID = $row['Season_ID'];
        $ID = (int)$ID;

        $name = $row['Season_Name'];
        $description = $row['Season_Description'];
        $start = $row['Start_Date'];
        $end = $row['End_Date'];

        echo "<tr>";
        // outputs a red x that links to deleting a season
        echo "<td><a href='deleteSeason.php?id=" . urlencode($ID) . "' onclick=\"return confirm('Are you sure you want to delete?');\"><img src='red_x_icon.jpg' alt='Delete button' height=15 width=15></a></td>";
        // outputs information related to the character
        echo "<td>".$name."</td>";
        echo "<td>".$description."</td>";
        echo "<td>".$start."</td>";
        echo "<td>".$end."</td>";
        // outputs an edit button that links to editing a season
        echo "<td><a href='updateSeason.php?id=" . urlencode($ID) . "'><img src='pencil_icon.jpg' alt='Edit button' height=30 width=30></a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    
    // link to add a season
    echo "<h4><a href='createSeason.php'>Add a Season</a></h4>";
    echo "<br /><br />";
    echo "</center>";
    echo "</div>";
}

// rank season rewards
$query = "SELECT Reward_ID, Reward_Name, Rank_Name as Rank_Required, Season_Name FROM Rank_Rewards
NATURAL JOIN Season 
LEFT JOIN Ranks on Ranks.Rank_ID = Rank_Rewards.Rank_Required
ORDER BY Season_Name";

 //  Prepare and execute query
 $stmt5 = $mysqli -> prepare($query);
 $stmt5 -> execute();

 if ($stmt5) {
     echo "<div class='row'>";
     echo "<center>";
     echo "<h3>Season Rewards</h3>";
     echo "<table>";
     echo "<thead>";
     echo "<tr><th></th><th>Reward Name</th><th>Minimum Rank Required</th><th>Season Offered</th>
         <th></th></tr>";
     echo "</thead>";
     echo "<tbody>";

     while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
         // Retrieve information from query results
         $ID = $row['Reward_ID'];
         $ID = (int)$ID;

         $name = $row['Reward_Name'];
         $rank = $row['Rank_Required'];
         $season = $row['Season_Name'];

         echo "<tr>";
         // outputs a red x that links to deleting a rank reward
         echo "<td><a href='deleteReward.php?id=" . urlencode($ID) . "' onclick=\"return confirm('Are you sure you want to delete?');\"><img src='red_x_icon.jpg' alt='Delete button' height=15 width=15></a></td>";
         // outputs information related to the character
         echo "<td>".$name."</td>";
         echo "<td>".$rank."</td>";
         echo "<td>".$season."</td>";
         // outputs an edit button that links to editing a rank reward
         echo "<td><a href='updateReward.php?id=" . urlencode($ID) . "'><img src='pencil_icon.jpg' alt='Edit button' height=30 width=30></a></td>";
         echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
     
     // link to add a season reward
    echo "<h4><a href='createReward.php'>Add a Season Reward</a></h4>";
    echo "<br /><br />";
    echo "</center>";
    echo "</div>";
}

    // add footer
    echo "<br /><p><a href='rivalsIndex.php'>&laquo; Back to Main Page</a></p>";
    new_footer("Marvel Rivals Database");	
    Database::dbDisconnect($mysqli);
?>
