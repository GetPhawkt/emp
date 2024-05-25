<?php
session_start();
if( isset($_SESSION["username"])){
$username = $_SESSION['username'];

   echo("almost done!<br> ".$username);


header('Location: user.php');
//header( "refresh:10;url=index.php" );

}

?>

