

<?php
session_start();
if(!file_exists('users/' . $_SESSION['username'] . '.xml')){
    header('Location: login.php');
    die;
}
$error = false;
if(isset($_POST['change'])){
    $old = $_POST['o_password'];
    $new = $_POST['n_password'];
    $c_new = $_POST['c_n_password'];
    $xml = new SimpleXMLElement('users/' . $_SESSION['username'] . '.xml', 0, true);
    if($old == $xml->password){
        if($new == $c_new){
            $xml->password = $new;
            $xml->asXML('users/' . $_SESSION['username'] . '.xml');
            header('Location: logout.php');
            die;
        }
    }
    $error = true;
}

?>

<head>
</head>
<body>
    <span style='text-shadow: 1 0 0 black;'><font size=2>Change Password:</span>
    <form method="post" action="">
        <?php 
        if($error){
            echo '<p><u><h6>ERROR: A Password(s) has been typed Wrong! Try Again!</u></h6></p>';
        }
        ?>
        <p>Old password <input type="password" name="o_password" size=10 /></p>
        <p>New password <input type="password" name="n_password" size=10 /></p>
        <p>Confirm new password <input type="password" name="c_n_password" size=10 /></p>
        <p><input type="submit" name="change" value="Change Password" size=10 /></p>
    </form>
<hr />
<font size=1>IP Logged on you're Account: <span style='text-shadow: 1 0 0 black;'>
<?
$ip = getenv(REMOTE_ADDR);

print "".$ip;

?></span>

