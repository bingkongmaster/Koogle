<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#accordion" ).accordion();
  } );
  </script>

  <style>
    * {
        font-family:Arial, Helvetica, sans-serif;
    }
  </style>
</head>

<?php

include "db_connect.php";
$keywordfromform = $_GET["keyword"];

//Search database for key word
echo "<h1>Searched: $keywordfromform</h1>";
$keywordfromform = "%" . $keywordfromform . "%";
/*
$sql = "
SELECT JokeID, Joke_question, Joke_answer, users_id, username
FROM Jokes_table
JOIN users ON users.id = jokes_table.users_id
WHERE Joke_question LIKE '%$keywordfromform%'
";
$result = $mysqli->query($sql);
*/
//Search matching username/password
$stmt = $mysqli->prepare("
  SELECT JokeID, Joke_question, Joke_answer, users_id, username
  FROM Jokes_table
  JOIN users ON users.id = jokes_table.users_id
  WHERE Joke_question LIKE ?
  ");
$stmt->bind_param("s", $keywordfromform);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($JokeID, $Joke_question, $Joke_answer, $users_id, $username);
?>
<!-- jQuery accodion UI start -->
<div id="accordion">
<?php
if ($stmt->num_rows > 0) {
  // output data of each row
  while($stmt->fetch()) {
    //echo "id: " . $row["JokeID"]. " - Name: " . $row["Joke_question"]. " " . $row["Joke_answer"]. "<br>";
    echo "<h3>" . $Joke_question . "</h3>";
    echo "<div><p>$Joke_answer<br>By: $username</p></div>";
  }
} else {
  echo "0 results";
}

?>
</div>
<!-- jQuery accodion UI end -->

<!-- Return Button start -->
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->

<!-- Button -->
<a href="index.php" class="btn btn-info" role="button" style="margin:20px;">Return</a>
<!-- Return Button end -->
