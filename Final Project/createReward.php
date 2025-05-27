<?php
// required files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Marvel Rivals Database"); 

// connect to database
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

// output message
if (($output = message()) !== null) {
	echo $output;
}
$_SESSION['message'] = null;

echo "<h3>Add a Season Reward</h3>";
echo "<center>";
echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";

// check if form was submitted
if (isset($_POST["submit"])) {
    // check if values are set
    if (!empty($_POST['Reward_Name']) && !empty($_POST['Rank_Required']) && !empty($_POST['Season_ID'])) {
        
        // check if reward name already exists during the same season
        $query = "SELECT Reward_ID FROM Rank_Rewards WHERE Reward_Name = ? AND Season_ID = ?";
        $stmtCheck = $mysqli->prepare($query);
        $stmtCheck->execute([$_POST['Reward_Name'], (int)$_POST['Season_ID']]);

        if ($stmtCheck) {
            $count = $stmtCheck->rowCount();

            if ($count > 0) {
                $_SESSION["message"] = "Unable to add Season Reward. The reward already exists for this season.";
                redirect("createReward.php");
            } else {
                // insert the new reward
                $query = "INSERT INTO Rank_Rewards (Reward_Name, Rank_Required, Season_ID) VALUES (?, ?, ?)";
                $stmt1 = $mysqli->prepare($query);
                $stmt1->execute([$_POST['Reward_Name'], (int)$_POST['Rank_Required'], (int)$_POST['Season_ID']]);

                //  Success
                if ($stmt1) {
                    $_SESSION["message"] = "Season Reward " . htmlentities($_POST['Reward_Name']) . " added!";
                    redirect("readSeason.php");
                //  Fail    
                } else {
                    $_SESSION["message"] = "Unable to add Season Reward.";
                    redirect("createReward.php");
                }
            }
        } else {
            $_SESSION["message"] = "Database error occurred.";
            redirect("createReward.php");
        }
    } else {
        //  fields are empty
        $_SESSION["message"] = "Unable to add Reward. Fill in all information!";
        redirect("createReward.php");
    }
} else {
    //  create a form that posts to this page
    echo '<div><form method="POST" action="createReward.php">';
    echo '<p>Reward Name: <input type="text" name="Reward_Name"></p>';

    //  output ranks
    $query = "SELECT Rank_ID, Rank_Name FROM Ranks";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();

    echo '<p>Minimum Required Rank for Reward: <select name="Rank_Required"><option value="">Select Rank</option>';
    if ($stmt2) {
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['Rank_ID'] . '">' . htmlentities($row['Rank_Name']) . '</option>';
        }
    }
    echo '</select></p>';

    //  output seasons
    $query = "SELECT Season_ID, Season_Name FROM Season";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();

    echo '<p>Season the Reward is Offered: <select name="Season_ID"><option value="">Select Season</option>';
    if ($stmt2) {
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['Season_ID'] . '">' . htmlentities($row['Season_Name']) . '</option>';
        }
    }
    echo '</select></p>';

    //  submit button
    echo '<input type="submit" name="submit" class="button tiny round" value="Add Season Reward">';
    echo '</form></div>';
}

//  Add footer
echo "<br /><p><a href='rivalsIndex.php'>&laquo; Back to Main Page</a></p>";
new_footer("Marvel Rivals Database");
Database::dbDisconnect($mysqli);
?>
