<!-- The following algorithm enables to prioritise tasks to perform -->




<!DOCTYPE html>
<html>
<head>
    <title>Outil</title>
    <link rel="stylesheet" type="text/css" href="outilStyles.css">
</head>
<body>

<form action="" method="post">
    


</form>



<p id="result"></p> 
<p id="result2"></p>
<p id="result3"></p>




 <script type="text/javascript">


    var text = "";
    var text2 = "";
    var i;
    var j;
    var k;
    var l;
    var m;
    var sumDelay;
    var a, b;
    var n;
    var o;
    var p;
    var timeToDeadline;


    // var numbers is the variable that contains the number of tasks to prioritise

    var numbers = [0, 1, 2, 3, 4, 5]

// the time to the deadline is tasks[0][0], tasks[1][0], tasks[2][0], tasks[3][0] and so on...
// the expected time to complete the task is tasks[0][1], tasks[0][2], tasks[0][3] and so on... 
// the importance of the deadline is tasks[2][0], tasks[2][1], tasks[2][2] and so on...



    var tasks = [
        [9, 5, 3],
        [5, 4, 2],
        [5, 2, 2],
        [2, 1, 3],
        [12, 3, 3],
        [7, 3, 2]
    ];

    var delays = [];
    console.log(tasks);

    var combinations = [];


    // find all possible orders of the tasks
 
var swap = function (numbers, pos1, pos2) {
  var temp = numbers[pos1];
  numbers[pos1] = numbers[pos2];
  numbers[pos2] = temp;
};

var heapsPermute = function (numbers, output, n) {
  n = n || numbers.length; // set n default to numbers.length
  if (n === 1) {
    output(numbers);
  } else {
    for (var i = 1; i <= n; i += 1) {
      heapsPermute(numbers, output, n - 1);
      if (n % 2) {
        var j = 1;
      } else {
        var j = i;
      }
      swap(numbers, j - 1, n - 1); // -1 to account for javascript zero-indexing
      // combinations.push(swap(numbers, j - 1, n - 1));
    }
  }
};


// For testing:
var print = function(input){
  combinations.push(input.slice(0));
}

var printLog = function(input){
  console.log(input);
}




heapsPermute(numbers, print);

heapsPermute(numbers, printLog);

console.dir(combinations);

// console.dir(combinations[2][1]);


// calculate the total delay for each combination of tasks

var sumDelay = 0;


for (m = 0; m < combinations.length; m++) {
    a = 0;
    b = 0;
    for (l = 0; l < numbers.length; l++) {    
        a = tasks[combinations[m][l]][0];
        b += tasks[combinations[m][l]][1];  
        if (a - b > 0) {
            sumDelay += 0;
        } else if ((a - b < 0) && (tasks[combinations[m][l]][2] === 3)) {
            sumDelay = sumDelay + (a - b) * 1000
        } else if ((a - b < 0) && (tasks[combinations[m][l]][2] === 2)) {
            sumDelay = sumDelay + (a - b) * 50;
        } else {
            sumDelay += (a - b);
        }
    }
    console.log("the delay coefficient for combination " + (m+1) + " is " + -(sumDelay));
    delays.push(-(sumDelay));
    sumDelay = 0;
}

console.log(delays);




// find the other combinations with a delay equal to the lowest delay (= delays.indexOf(Math.min.apply(Math, delays)) ) and store in variable called lowestDelays

var lowestDelays = [];

for (k = delays.indexOf(Math.min.apply(Math, delays)); k < combinations.length; k++) {
    if (delays[delays.indexOf(Math.min.apply(Math, delays))] - delays[k] === 0) {
        lowestDelays.push(k);
        console.log(k);
    }
}

console.log(lowestDelays);
// console.log(tasks[combinations[lowestDelays[0]][0]][2]);



var timeForCompletion = 0;




timeToDeadline = [];



for ( o = 0; o < lowestDelays.length; o++) {
    for (n = 0; n < numbers.length; n++) {

// for each combination which has the lowest delays, go through the combination and find the task with an importance of 3

        if ( tasks[combinations[lowestDelays[o]][n]][2] === 3) {

// first create a loop that will generate a variable that will store the estimated time of completion of the task with importance 3 + the time of completion of all the tasks that come before

            for ( p = 0; p < (n + 1); p++) {
                timeForCompletion += tasks[combinations[lowestDelays[o]][p]][1];
            }

// take off from the time to the deadline with importance 3, the variable above to find the time between the completion of the task with importance 3 and its deadline
            timeToDeadline.push(tasks[combinations[lowestDelays[o]][n]][0] - (timeForCompletion)); 
        }
    }
    timeForCompletion = 0;
}



// find the combination that has the lowest time between the completion of the task with importance 3 and its deadline between all the combinations with the lowest delay


console.log("The combination with the lowest delay is combination " + combinations[lowestDelays[timeToDeadline.indexOf(Math.max.apply(Math, timeToDeadline))]]);










 </script>



</body>
</html>