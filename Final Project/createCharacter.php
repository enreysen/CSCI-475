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

    echo "<h3>Add a Character</h3>";
    echo "<center>";
    echo "<div class='row'>";
    echo "<label for='left-label' class='left inline'>";

    // check if form was submitted
    if (isset($_POST["submit"])) {

        // check if values are set
        if((isset($_POST['Name']) && $_POST['Name'] != "") &&  (isset($_POST['Role']) && $_POST['Role'] != "") && (isset($_POST['Attack']) && $_POST['Attack'] != "") && 
        (isset($_POST['Health']) && $_POST['Health'] != "") && (isset($_POST['Move_Speed']) && $_POST['Move_Speed'] != "") && (isset($_POST['Win_Rate']) && $_POST['Win_Rate'] != "") && 
        (isset($_POST['Pick_Rate']) && $_POST['Pick_Rate'] != "") && (isset($_POST['Difficulty']) && $_POST['Difficulty'] != "") && (isset($_POST['Char_Release']) && $_POST['Char_Release'] != "")){

            // checks if name alreay exists

            // if name exists, print out error message
            $query = "SELECT Char_ID FROM Characters WHERE Char_Name = ?";
            $stmtCheck = $mysqli -> prepare($query);
            // execute query
            $stmtCheck -> execute([$_POST['Name']]);
                
            if($stmtCheck){
                $count = $stmtCheck -> rowCount();
                    
                if($count > 0){
                    $_SESSION["message"] = "Unable to add Character. Character name already exists.";
                    redirect("createCharacter.php");
                } else {
                    // create and prepare query to insert information that has been posted into the table
                    $query = "INSERT INTO Characters (Char_Name, Role_ID, Attack_ID, Health, Move_Speed, Win_Rate, Pick_Rate, Difficulty, Char_Release) VALUES (?,?,?,?,?,?,?,?,?)";
                    $stmt1 = $mysqli -> prepare($query);
                    // execute query
                    $stmt1 -> execute([$_POST['Name'],(int)$_POST['Role'],(int)$_POST['Attack'],(int)$_POST['Health'],(float)$_POST['Move_Speed'],(float)$_POST['Win_Rate'],(float)$_POST['Pick_Rate'],(int)$_POST['Difficulty'],$_POST['Char_Release']]);
                    
        
                    // if query works, send message that character was created
                    if($stmt1){
                         $_SESSION["message"] = "Character ".$_POST['Name']." added!";
                        redirect("readCharacter.php");
                    }
                    else{
                        // otherwise, output that there was an error
                        $_SESSION["message"] = "Unable to add character.";
                        redirect("createCharacter.php");
                    }
                }
            }
                
            
        }
        // values are not set, output an error
        else{
            // error message
            echo 'fill in info!';
            $_SESSION["message"] = "Unable to add character. Fill in all information!";
            redirect("createCharacter.php");
        }

        
    } else{
        // create a form that posts to this page
       
       
        echo '<div><form method="POST" action="createCharacter.php">
        <p>Name: <input type="text" name="Name"></p>';

        // output roles 
        $query = "SELECT Role_ID, Role_Name FROM Roles";
		$stmt2 = $mysqli -> prepare($query);
		$stmt2 -> execute();		

        echo '<p>Role: <select name="Role"><option></option>';
					
		if ($stmt2){
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $role = $row['Role_Name'];
                $roleID = $row['Role_ID'];
                echo '<option value="'.$roleID.'">'.$role.'</option>';
			}
		}

        echo '</select></p>';

        // output attack types 
        $query = "SELECT Attack_ID, Attack_Name FROM Attack_Type";
		$stmt3 = $mysqli -> prepare($query);
		$stmt3 -> execute();		

        echo '<p>Attack Type: <select name="Attack"><option></option>';
					
		if ($stmt3){
			while($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                $attack = $row['Attack_Name'];
                $attackID = $row['Attack_ID'];
                echo '<option value="'.$attackID.'">'.$attack.'</option>';
			}
		}

        echo '</select></p>';

        echo '<p>Health: <input type="text" name="Health"></p>
            <p>Movement Speed (m/s): <input type="text" name="Move_Speed"></p>
            <p>Win Rate (%): <input type="text" name="Win_Rate"></p>
            <p>Player Pick Rate (%): <input type="text" name="Pick_Rate"></p>';
        
            
        // output difficulty levels (1-5)
        echo '<p>Difficulty Level: <select name="Difficulty"><option></option>';
        for ($x = 1; $x <= 5; $x++) {
            echo '<option value="'.$x.'">'.$x.'</option>';
        }
        echo '</select></p>';


        echo '<p>Character Release Date: <input type=date name="Char_Release" lang="en-CA"></p>';
        
        // submit button and closing the form
        echo '<input type="submit" name="submit" class="button tiny round" value="Add Character" /> 
			</form></div>';
    }

    echo "</label>";
    echo "</div>";
	echo "</center>";
    // on click, user will be redirected back to main page
    echo "<br /><p>&laquo:<a href='readCharacter.php'>Back to Main Page</a></p>";


    
    



?>