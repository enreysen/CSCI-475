<?php
    // required files
    require_once("session.php");
    require_once("included_functions.php");
    require_once("database.php");

    new_header("Marvel Rivals Database"); 

    // connect to database
    $mysqli = Database::dbConnect(); 
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
 

    // output message (if there is one)
    if (($output = message()) !== null) {
		echo $output;
	}

    $_SESSION['message'] = null;

    echo "<h3>Add a Season</h3>";
    echo "<center>";
    echo "<div class='row'>";
    echo "<label for='left-label' class='left inline'>";

    // check if form was submitted
    if (isset($_POST["submit"])) {
        // check if values are set
        if((isset($_POST['Season_Name']) && $_POST['Season_Name'] != "") && (isset($_POST['Season_Description']) && $_POST['Season_Description'] != "") 
        && (isset($_POST['Start_Date']) && $_POST['Start_Date'] != "") && (isset($_POST['End_Date']) && $_POST['End_Date'] != "")){            
            // check if name is taken
            // if name exists, print out error message
            $query = "SELECT Season_ID FROM Season WHERE Season_Name = ?";
            $stmtCheck = $mysqli -> prepare($query);
            // execute query
            $stmtCheck -> execute([$_POST['Season_Name']]);
                
            if($stmtCheck){
                $count = $stmtCheck -> rowCount();
                    
                if($count > 0){
                    $_SESSION["message"] = "Unable to add Season. Season name already exists.";
                    redirect("createSeason.php");
                } else {

                    // check if another season starts or ends at inputted date
                    $query = "SELECT Season_ID FROM Season WHERE Start_Date <= ? AND End_Date >= ?";
                    $stmtCheck2 = $mysqli -> prepare($query);
                    $stmtCheck2->execute([$_POST['End_Date'], $_POST['Start_Date']]);
                        
                    if($stmtCheck2){
                        $count = $stmtCheck2 -> rowCount();
                        if($count > 0){
                            $_SESSION["message"] = "Season cannot occur at the same time of another season.";
                            redirect("createSeason.php");
                        }
                        else{
                            // check if end date is before start date
                            if($_POST['Start_Date'] > $_POST['End_Date']){
                                $_SESSION["message"] = "Start Date cannot be after End Date.";
                                redirect("createSeason.php");
                            }
                            else{
                                 // create and prepare query to insert information that has been posted into the table
                                $query = "INSERT INTO Season (Season_Name, Season_Description, Start_Date, End_Date) VALUES (?,?,?,?)";
                                $stmt1 = $mysqli -> prepare($query);
                                // execute query
                                $stmt1 -> execute([$_POST['Season_Name'],$_POST['Season_Description'],$_POST['Start_Date'],$_POST['End_Date']]);

                                // if query works, send message that season was created
                                if($stmt1){
                                    $_SESSION["message"] = "Season ".$_POST['Season_Name']." added!";
                                    echo 'season added!';
                                    redirect("readSeason.php");
                                }
                            
                                else{
                                    // otherwise, output that there was an error
                                    $_SESSION["message"] = "Unable to add Season.";
                                    redirect("createSeason.php");
                                }
                            }
                        }
                    }   
                }
            }
        }
        else{
            // values are not set, output an error

           $_SESSION["message"] = "Unable to add Season. Fill in all information!";
           redirect("createSeason.php");
       }
    } else{
        // create a form that posts to this page
        echo '<div><form method="POST" action="createSeason.php">
        <p>Season Name: <input type="text" name="Season_Name"></p>
        <p>Description: <input type="text" name="Season_Description"></p>
        <p>Season Start Date: <input type="date" name="Start_Date" lang="en-CA"></p>
        <p>Season End Date: <input type="date" name="End_Date" lang="en-CA"></p>';
        
        // submit button and closing the form
        echo '<input type="submit" name="submit" class="button tiny round" value="Add Season" /> 
			</form></div>';
    }

    echo "</label>";
    echo "</div>";
	echo "</center>";
    // on click, user will be redirected back to main page
    echo "<br /><p>&laquo:<a href='readSeason.php'>Back to Main Page</a></p>";
?>