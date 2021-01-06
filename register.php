<?php
if(isset($_POST["submit"]))
{
    $fn = $_POST["fname"];
    $ln = $_POST["lname"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $score = $_POST["score"];
    

function OpenCon()
 {
 	$dbhost = "localhost";
 	$dbuser = "root";
 	$dbpass = "adityadev";
 	$db = "wp_project";
 	$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
 
 	return $conn;
 }
 

function CloseCon($conn)
 {
 	$conn -> close();
 }
 

 $conn = OpenCon();
 if($conn === false){
    die("ERROR: Could not connect.<br>" . $conn->connect_error);
}


$sql = "CREATE TABLE IF NOT EXISTS persons(
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE,
    gender VARCHAR(30) NOT NULL
)";

if($conn->query($sql) === true){
	//echo "Table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql.<br>" . $conn->error;
}


$sql3="SELECT * FROM persons WHERE email='$email'";
$result = $conn->query($sql3);

if ($result->num_rows> 0) {
	echo "Registration already exists for the given Email address.<br>";
} else{

    $name = $fn.' '.$ln;

	$sql1="INSERT INTO leaderboard SET full_name='$name', score='$score'";

	$sql2="INSERT INTO persons SET first_name = '$fn', last_name='$ln', email='$email', gender='$gender'";


	if($conn->query($sql1) === true and $conn->query($sql2) === true){
        header('Location: home.html');
        exit;
	} else{
	    echo "ERROR: Could not able to execute $sql1.<br>" . $conn->error;
    }
}


CloseCon($conn);
}
?>