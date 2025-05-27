<?php
//  Update Reward
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Update Reward"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//  Output message
if (($output = message()) !== null) {
    echo $output;
}
$_SESSION['message'] = null;

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("SELECT * FROM Rank_Rewards WHERE Reward_ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //  Reward exists
    if (!$row) {
        $_SESSION["message"] = "Reward not found.";
        redirect("readSeason.php");
    }

    $stmtRanks = $mysqli->query("SELECT Rank_ID, Rank_Name FROM Ranks");
    $ranks = $stmtRanks->fetchAll(PDO::FETCH_ASSOC);

    $stmtSeasons = $mysqli->query("SELECT Season_ID, Season_Name FROM Season");
    $seasons = $stmtSeasons->fetchAll(PDO::FETCH_ASSOC);

    //  Formatting
    echo "<center>";
    echo "<div class='row'>";
    echo "<label for='left-label' class='left inline'>";

    echo "<form action='updateReward.php?id=" . urlencode($id) . "' method='POST'>";
    echo "<p>Reward Name: <input type='text' name='Reward_Name' value='" . htmlentities($row['Reward_Name']) . "'></p>";

    //  Rank
    echo "<p>Required Rank: <select name='Rank_Required'>";
    foreach ($ranks as $rank) {
        echo "<option value='" . $rank['Rank_ID'] . "'";
        if ($rank['Rank_ID'] == $row['Rank_Required']) {
            echo " selected";
        }
        echo ">" . htmlentities($rank['Rank_Name']) . "</option>";
    }
    echo "</select></p>";

    //  Season
    echo "<p>Season: <select name='Season_ID'>";
    foreach ($seasons as $season) {
        echo "<option value='" . $season['Season_ID'] . "'";
        if ($season['Season_ID'] == $row['Season_ID']) {
            echo " selected";
        }
        echo ">" . htmlentities($season['Season_Name']) . "</option>";
    }
    echo "</select></p>";

    //  Submit button
    echo "<input type='submit' name='submit' class='button tiny round' value='Update Reward'>";
    echo "</form>";

    echo "</label>";
    echo "</div>";
    echo "</center>";

} elseif (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $rewardName = $_POST['Reward_Name'];
    $rankRequired = $_POST['Rank_Required'];
    $seasonID = (int)$_POST['Season_ID'];

    //  Check if any field is empty
    if (empty($rewardName) || empty($rankRequired) || empty($seasonID)) {
        $_SESSION["message"] = "All fields are required.";
        redirect("updateReward.php?id=" . urlencode($id));
    }

    //  Check if same reward name already exists in the same season (excluding itself)
    $stmtCheckName = $mysqli->prepare("SELECT Reward_ID FROM Rank_Rewards WHERE Reward_Name = ? AND Season_ID = ? AND Reward_ID != ?");
    $stmtCheckName->execute([$rewardName, $seasonID, $id]);
    if ($stmtCheckName->rowCount() > 0) {
        $_SESSION["message"] = "A Rank Reward with that name already exists for this season.";
        redirect("updateReward.php?id=" . urlencode($id));
    }

    $stmt = $mysqli->prepare("UPDATE Rank_Rewards SET Reward_Name = ?, Rank_Required = ?, Season_ID = ? WHERE Reward_ID = ?");

    //  Success
    if ($stmt->execute([$rewardName, $rankRequired, $seasonID, $id])) {
        $_SESSION["message"] = "Reward updated successfully.";
        redirect("readSeason.php");
    //  Fail
    } else {
        $_SESSION["message"] = "Reward update failed.";
        redirect("updateReward.php?id=" . urlencode($id));
    }

//  Invalid action
} else {
    $_SESSION["message"] = "Invalid action.";
    redirect("readSeason.php");
}

//  Add footer
echo "<br /><p><a href='rivalsIndex.php'>&laquo; Back to Main Page</a></p>";
new_footer("Marvel Rivals Database");
Database::dbDisconnect($mysqli);
?>
