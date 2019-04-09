<?php

include('connection.php');


if( isset( $_POST["add"] ) ) {


// change post date format

$deadline = $_POST["deadline"];
$task = $_POST["task"];
$importanceDeadline = $_POST["importanceDeadline"];
// echo $task;
// echo $deadline;
$monthDeadStr = substr($deadline, 0, 2);
$dayDeadStr = substr($deadline, 3, 2);
$yearDeadStr = substr($deadline, 6, 4);

// echo $yearDeadStr;

$formattedDeadline = $yearDeadStr . "-" . $monthDeadStr . "-" . $dayDeadStr;
// echo $formattedDeadline;


    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    
    if( !$_POST["task"] ) {
        $taskError = "Please enter a task <br>";
    }

    if( !$_POST["deadline"] ) {
        $deadlineError = "Please enter your deadline <br>";
    }

    if( !$_POST["importanceDeadline"] ) {
        $deadlineError = "Please enter your deadline <br>";
    }

    
    // check to see if each variable has data
    if( $task && $deadline && $importanceDeadline) {
        $query = "INSERT INTO tasks (id, task, deadline, importanceDeadline)
        VALUES (NULL, '$task', '$formattedDeadline', '$importanceDeadline')";

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
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Prioritisation Tool</title>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        
        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!-- jQuery UI -->
        <script src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="js/scripts.js"></script>


        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" type="text/css" href="styleImportance.css">


</head>
<body>



<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">

<div class="blackBox">




<div class="search-box1">
    <input autocomplete="off" class="search-txt1" type="text" name="task" placeholder="Add Task">
    <a class="search-btn1">
        <i class="fas fa-tasks"></i>
    </a>
</div>


<div class="search-box2">
    <input autocomplete="off" class="date search-txt2" type="text" name="deadline" placeholder="Add Deadline">
    <a class="search-btn2">
          <i class="far fa-calendar-alt"></i>
    </a>
</div>

<div class="search-box3">
    <input class="search-txt3" type="text" name="">
    <a class="search-btn3">
        <i class="fas fa-ban"></i>
    </a>
</div>


<div class="search-box4">
    <button class="search-txt4" type="text" name="add">
    <a class="search-btn4">
        <i class="fas fa-plus"></i>
    </a>
    </button>
</div>




</div>


<div class="hidden">  

<div class="search-box1">
<input type="text" name="importanceDeadline" list="languages" placeholder="Importance of your deadline" class="inputImportance">

<datalist id="languages">
    <option value=1>
    <option value=2>
    <option value=3>
</datalist>

<a class="search-btn2">
    <i class="fas fa-exclamation"></i>    
</a>
</div>
</div>



<div class="search-box1">
<input type="text" name="completionTime" list="languages" placeholder="Importance of your deadline" class="inputImportance">

<datalist id="languages">
    <option value=1>
    <option value=2>
    <option value=3>
</datalist>

<a class="search-btn2">
    <i class="fas fa-exclamation"></i>    
</a>
</div>
</div>



</form>





<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'Today')" id="defaultOpen">
        Today
    </button>
    <button class="tablinks" onclick="openCity(event, 'Tomorrow and after')">   
        Tomorrow and after
    </button>
        <button class="tablinks" onclick="openCity(event, 'Overdue')">
        Overdue
    </button>
    <button class="tablinks" onclick="openCity(event, 'Completed')">
        Completed Tasks
    </button>
</div>

<div id="Today" class="tabcontent">
  <h3>Today</h3>
<?php
$sql = "SELECT id, task, deadline FROM tasks";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        // accessing deadline in database and putting month, year, day into discrete variables

        $deadStrSQL = $row["deadline"]. "<br>";
        $deadID = $row["id"];

        $yearDeadStrSQL = substr($deadStrSQL, 0, 4);
        $dayDeadStrSQL = substr($deadStrSQL, 8, 2);
        $monthDeadStrSQL = substr($deadStrSQL, 5, 2);

        // convert previous string variables into number variables
        $yearDeadFloSQL = floatval($yearDeadStrSQL);
        $monthDeadFloSQL = floatval($monthDeadStrSQL);
        $dayDeadFloSQL = floatval($dayDeadStrSQL);

        // access current date and store month, year, day into discrete float variables
        $yearNowFlo = date(Y);
        $monthNowFlo = date(m);
        $dayNowFlo = date(d);


        // store the tasks of current date in div
        if ($yearDeadFloSQL == $yearNowFlo && $monthNowFlo == $monthDeadFloSQL && $dayDeadFloSQL == $dayNowFlo) {
            echo $row["task"]."     ".
        "<form action = delete.php method=POST>

            <input type = hidden name=ID value =".$row['id'].">
            <input type = submit name=submit value=Remove>
    

        </form>".

    "<form action = completed.php method=POST>

        <input type = hidden name=IDComplete value =".$row['id'].">
        <input type = submit name=submit value=Complete>

    </form>"                

        . "<br><br>";
        }
    }
} else {
    echo "0 results";
}


?>
</div>

<div id="Tomorrow and after" class="tabcontent">
  <h3>Tomorrow and after</h3>
<?php
$sql = "SELECT id, task, deadline FROM tasks";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        // accessing deadline in database and putting month, year, day into discrete variables

        $deadStrSQL = $row["deadline"]. "<br>";

        $yearDeadStrSQL = substr($deadStrSQL, 0, 4);
        $dayDeadStrSQL = substr($deadStrSQL, 8, 2);
        $monthDeadStrSQL = substr($deadStrSQL, 5, 2);

        // convert previous string variables into number variables
        $yearDeadFloSQL = floatval($yearDeadStrSQL);
        $monthDeadFloSQL = floatval($monthDeadStrSQL);
        $dayDeadFloSQL = floatval($dayDeadStrSQL);

        // access current date and store month, year, day into discrete float variables
        $yearNowFlo = date(Y);
        $monthNowFlo = date(m);
        $dayNowFlo = date(d);


        // store the tasks of current date in div
        if (($yearDeadFloSQL > $yearNowFlo) ||
    ($yearDeadFloSQL == $yearNowFlo && $monthDeadFloSQL > $monthNowFlo ) ||
    ($yearDeadFloSQL == $yearNowFlo && $monthDeadFloSQL == $monthNowFlo && $dayDeadFloSQL > $dayNowFlo)) {
            echo $row["task"]."     ".
        "<form action = delete.php method=POST>

    <input type = hidden name=ID value =".$row['id'].">
    <input type = submit name=submit value=Remove>

</form>".

    "<form action = completed.php method=POST>

        <input type = hidden name=IDComplete value =".$row['id'].">
        <input type = submit name=submit value=Complete>

    </form>"                

        . "<br><br>";
        }
    }
} else {
    echo "0 results";
}
?>
</div>

<div id="Overdue" class="tabcontent">
  <h3>Overdue</h3>
<?php
$sql = "SELECT id, task, deadline FROM tasks";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        // accessing deadline in database and putting month, year, day into discrete variables

        $deadStrSQL = $row["deadline"]. "<br>";

        $yearDeadStrSQL = substr($deadStrSQL, 0, 4);
        $dayDeadStrSQL = substr($deadStrSQL, 8, 2);
        $monthDeadStrSQL = substr($deadStrSQL, 5, 2);

        // convert previous string variables into number variables
        $yearDeadFloSQL = floatval($yearDeadStrSQL);
        $monthDeadFloSQL = floatval($monthDeadStrSQL);
        $dayDeadFloSQL = floatval($dayDeadStrSQL);

        // access current date and store month, year, day into discrete float variables
        $yearNowFlo = date(Y);
        $monthNowFlo = date(m);
        $dayNowFlo = date(d);


        // store the tasks of current date in div
        if (($yearDeadFloSQL < $yearNowFlo) ||
    ($yearDeadFloSQL == $yearNowFlo && $monthDeadFloSQL < $monthNowFlo ) ||
    ($yearDeadFloSQL == $yearNowFlo && $monthDeadFloSQL == $monthNowFlo && $dayDeadFloSQL < $dayNowFlo)) {
            echo $row["task"]."     ".
        "<form action = delete.php method=POST>

    <input type = hidden name=ID value =".$row['id'].">
    <input type = submit name=submit value=Remove>

</form>".

    "<form action = completed.php method=POST>

        <input type = hidden name=IDComplete value =".$row['id'].">
        <input type = submit name=submit value=Complete>

    </form>"                

        . "<br><br>";
        }
    }
} else {
    echo "0 results";
}


mysqli_close($conn);


?>
</div>

<div id="Completed" class="tabcontent">
  <h3>Completed tasks</h3>
<?php

include('connection.php');

$sql = "SELECT * FROM completed_tasks";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    
while($row = mysqli_fetch_assoc($result)) {
    echo $row['task']."    ";
    echo $row['deadline']."<br><br>";
}

} else {
    echo "you have no completed tasks";
}


echo "<a href='add.php'>Return to home page</a>";

?>
</div>



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

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>


</body>

<footer>
    <script language="javascript" type="text/javascript">



$(document).ready(function(){
    $(".search-btn1").click(function(){
        $(".search-txt1").animate({width: "240px"}, 0);
        }, function(){
        $(".search-txt1").animate({width: "240px"}, 0);
    });
});



$(document).ready(function(){
    $(".search-btn1").click(function(){
        $(".search-txt2").animate({width: "140px"}, 200);
        }, function(){
        $(".search-txt2").animate({width: "140px"}, 200);
    });
});

$(document).ready(function(){
    $(".search-btn2").click(function(){
        $(".search-txt1").animate({width: "240px"}, 0);
        }, function(){
        $(".search-txt1").animate({width: "240px"}, 0);
    });
});

$(document).ready(function(){
    $(".search-btn2").click(function(){
        $(".search-txt2").animate({width: "140px"}, 200);
        }, function(){
        $(".search-txt2").animate({width: "140px"}, 200);
    });
});



$(document).ready(function(){
    $(".search-btn3").click(function(){
        $(".search-txt1").animate({width: "0px"}, 200);
        }, function(){
        $(".search-txt1").animate({width: "0px"}, 200);
    });
});

$(document).ready(function(){
    $(".search-btn3").click(function(){
        $(".search-txt2").animate({width: "0px"}, 0);
        }, function(){
        $(".search-txt2").animate({width: "0px"}, 0);
    });
});


// $(document).ready(function(){
//     $(".search-btn3").click(function(){
//         $(".blackBox").animate({height: "0px"}, 500);
//         }, function(){
//         $(".blackBox").animate({height: "0px"}, 500);
//     });
// });


$(document).ready(function(){
  $(".search-btn3").click(function(){
    $(".hidden").slideUp();
  });
  $(".search-btn1").click(function(){
    $(".hidden").slideDown();
  });
});


// prevent task from adding every reload of page
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}




    </script>
</footer>

</html>

