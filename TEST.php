<!-- Undergoing project that aims to record what user has done during the day, whether this has offered satisfaction to the user, and offers a set of statistical analyses on the resulting data -->



<?php

include('connection.php');


if( isset( $_POST["addNewAction"] ) ) {


// change post date format

$newAction = $_POST["newAction"];


    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    
    if( !$_POST["newAction"] ) {
        $newActionError = "Please enter a new action <br>";
        echo $newActionError;
    }

    
    // check to see if each variable has data
    if( $newAction) {
        $query = "INSERT INTO dummynewaction (id, newAction)
        VALUES (NULL, '$newAction')";

        if( mysqli_query( $conn, $query ) ) {
            echo " ";
        } else {
            echo "Error: ". $query . "<br>" . mysqli_error($conn);
        }
    }
    

}





?>

<!DOCTYPE html>
<html>
<head>
    <title>TEST</title>
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="online_happiness_styles.css">


</head>
<body>



    <?php

    $todayDate = date("Y/m/d");
    echo $todayDate;


?>







    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'completed_action')">Add a completed action</button>
        <button class="tablinks" onclick="openCity(event, 'add_new_task')">Add a new task</button>
        <button class="tablinks" onclick="openCity(event, 'today_actions')">Today's actions</button>
        <button class="tablinks" onclick="openCity(event, 'unhappiness')">Unhappiness stats</button>        
    </div>

<div id="completed_action" class="tabcontent">



<?php
    $actions = array();

    $sql = "SELECT newAction FROM dummynewaction";
    $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        // accessing deadline in database and putting month, year, day into discrete variables

        // echo $row["completedAction"]. "<br>";
        array_push($actions, $row['newAction']);
    }
} else {
    echo "0 results";
}


?>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">

<input type="text" name="completedAction" list="languages" placeholder="Add a completed action" class="inputImportance">

<datalist id="languages">
    <?php

for ($i=0; $i < count($actions); $i++) { 

    echo "

        <option value=" . $actions[$i] . ">


    ";
}


    ?>
</datalist>


<input type='time' name='actionDuration' value='01:00:00'>

<input type='text' name='satisfactionRating' list='options' placeholder='rate your satisfaction'>
<datalist id='options'>
    <option value = satisfied> 
    <option value = neutral> 
    <option value = unhappy>
</datalist> 


<input autocomplete='off' type='date' name='date'>

<button type='text' name='addCompletedAction'>Add Activity</button>


</form>




        <?php

        $sql = "SELECT id, newAction FROM dummynewaction";
        $result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

            $completedAction = $_POST["completedAction"];
            $actionDuration = $_POST["actionDuration"];
            $satisfactionRating = $_POST["satisfactionRating"];
            $date = $_POST["date"];
    }



            if( isset( $_POST["addCompletedAction"] ) ) {

                    $query = "INSERT INTO dummycompletedaction (id, completedAction, duration, satisfaction, completed_date)
                    VALUES (NULL, '$completedAction', '$actionDuration', '$satisfactionRating', '$date')";

                    if( mysqli_query( $conn, $query ) ) {
                        echo "Task added successfully to completed actions";
                    } else {
                        echo "Error: ". $query . "<br>" . mysqli_error($conn);
                    }
                    
            }

    

} else {
    echo "0 results";
}



    ?>

</div>

<div id="add_new_task" class="tabcontent">

    <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">

        <input autocomplete="off" type="text" name="newAction" placeholder="Add to your list of activities">
        <br>


    <button type="text" name="addNewAction">
        Add new task
    </button>

    </form>

</div>

<div id="today_actions" class="tabcontent">
    <h3>Today</h3>


<?php

$sql = "SELECT id, completedAction, duration, satisfaction, completed_date FROM dummycompletedaction
WHERE completed_date = '$todayDate'
";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        echo $row["id"] . "<br>";
        echo $row["completedAction"] . "<br>";
        echo $row["duration"] . "<br>";
        echo $row["satisfaction"] . "<br>";
        echo $row["completed_date"] . "<br>" . "<br>";
        
        echo "
        <form action = test_delete_completedaction.php method=POST>

            <input type = hidden name=ID value =".$row['id'].">
            <input type = submit name=submit value=Remove>


        </form>

        ";
}



} else {
    echo "0 results";
}


?>

</div>


<div id="unhappiness" class="tabcontent">

    <h3>Check out stats on unhappiness</h3>

    <?php

        $unhappy_date = array();
        $sql = "SELECT * FROM completedaction WHERE satisfaction = 'unhappy'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {



            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                // echo $unhappy_date;
                $date=date_create($row['completed_date']);
                // echo date_format($date, "w") . "<br>";
                array_push($unhappy_date, date_format($date, "w"));
            }
        } else {
            echo "0 results";
        }


                echo "<br><br><br>";


                $days = array(0, 0, 0, 0, 0, 0);
                // $days[4] += 1;
                // echo $days[4];


                for ($j=0; $j < count($unhappy_date); $j++) { 
                    for ($k=0; $k < count($unhappy_date); $k++) { 
                        if ($unhappy_date[$j] = $unhappy_date[$k]) {
                            $days[$unhappy_date[$j]] += 1;
                        }
                    }
                }

                print_r($days);


                echo(max($days));


?>

<script>
   var days = <?php echo json_encode($days); ?>;
   console.log(days);
   console.log(Math.max(days));
</script>


<?php
echo "<br><br><br><br>";

// print_r($unhappy_date);


$today_date = date("Y/m/d");
// print_r($today_date);

// echo "<br><br><br><br>";

// $date=date_create("$unhappy_date");
// echo date_format($date,"Y/m/d D");



    ?>


</div>


<h3>Find specific date</h3>
    <?php

if( isset( $_POST["find_action"] ) ) {


// change post date format

$action_date = $_POST["action_date"];


    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function

    $sql = "SELECT id, completedAction, duration, satisfaction, completed_date FROM dummycompletedaction
WHERE completed_date = '$action_date'
";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        echo $row["id"] . "<br>";
        echo $row["completedAction"] . "<br>";
        echo $row["duration"] . "<br>";
        echo $row["satisfaction"] . "<br>";
        echo $row["completed_date"] . "<br>" . "<br>" . "<br>";

        echo "
        <form action = test_delete_completedaction.php method=POST>

            <input type = hidden name=ID value =".$row['id'].">
            <input type = submit name=submit value=Remove>


        </form>

        ";

}

} else {
    echo "0 results";
}


    
    if( !$_POST["action_date"] ) {
        $action_date_Error = "Please enter a date <br>";
        echo $newActionError;
    }

    
}


?>
<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">

    <input autocomplete="off" type="date" name="action_date" placeholder="Search for a date">
    <br>
    <br>

<button type="text" name="find_action">
    Find actions
</button>

</form>


<?php

print_r($actions)

?>





<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>




</body>

<footer>
    
    <script type="text/javascript">
        
// prevent task from adding every reload of page
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

    </script>

</footer>


</html>

