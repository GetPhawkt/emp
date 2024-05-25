<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$xmlFile = "users/{$username}.xml";

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    
    echo '<form method="post">';
    foreach ($xml->children() as $child) {
        echo '<label for="' . $child->getName() . '">' . $child->getName() . '</label>';
        echo '<input type="text" name="' . $child->getName() . '" value="' . $child . '"><br>';
    }
    echo '<button type="submit" name="save">Save</button>';
    echo '</form>';
    
    if (isset($_POST['save'])) {
        foreach ($_POST as $key => $value) {
            $xml->$key = $value;
        }
        $xml->asXML($xmlFile);
        echo 'Data saved successfully!';
    }
} else {
    echo 'XML file not found for the user.';
}
?>