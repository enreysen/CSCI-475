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
    echo "<center>";
    echo '<h2>Welcome to the Marvel Rivals Database!</h2>';
    echo '<br><h3>Click the links below to learn more about each topic.</h3><br>';

    // link to character information
   
    echo "<h4><a href='readCharacter.php'>Characters</a></h4>";

    // link to team ups (Davidson's Query)
    //For each Team_Name, list all Role_Name on one line - use group-concat.
    //For each Team_Name, list all Char_Name on one line - use group concat.
    echo "<h4>Incorporates Dr. Davidson's Queries: <a href='readTeam.php'>Team Ups</a></h4>";

    // link to maps (Query 2: Nested query): Question: Which maps are standard maps (convoy, convergence, domination)?
    echo "<h4>Incorporates Query 2: Nested Query: <a href='readMap.php'>Maps</a></h4>";


    // link to Ranks
    // (Query 1: ) Question: 
    // Summing the tiers of each rank and listing the ranks in desc order by player percentage.
    echo "<h4>Incorporates Query 1: Aggregate Query: <a href='readRank.php'>Ranks</a></h4>";


    // link to Season Information
    echo "<h4><a href='readSeason.php'>Seasons and Season Rewards</a></h4>";


    echo "</center>";
    // add footer
    new_footer("Marvel Rivals Database");	
?>