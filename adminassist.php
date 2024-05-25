<?php
// Receive POST data from radio button 'user' and select menu 'action'
$user = $_POST['user'];
$action = $_POST['action'];

// Handle different actions based on the selected option
if ($action === 'delete') {
    // Unlink the user folder and delete its contents
    $folderPath = "{$user}";
    $xmlFile = "./users/{$user}.xml";
    if (is_dir($folderPath)) {
        $files = glob($folderPath . '/*');
        foreach ($files as $file) {
            unlink($file);
        }
         $logEntry = "User {$user} was deleted on " . date('m-d-y H:i:s') . "\n";
    file_put_contents('notifications/logs.txt', $logEntry, FILE_APPEND);
        rmdir($folderPath);
        unlink($xmlFile);
        echo "User folder and contents deleted successfully.";
    } else {
        echo "User folder not found.";
    }
} elseif ($action === 'make_admin') {
    // Update user role to 'admin' in the XML file
    $filePath = "./users/{$user}.xml";
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        $xml->role = 'admin';
        $xml->asXML($filePath);
        echo "User role updated to admin.";
    } else {
        echo "User XML file not found.";
    }
} elseif ($action === 'get_info') {
    // Retrieve user information from the XML file and display in a table
    $filePath = "./users/{$user}.xml";
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        echo "<table border='1'>";
        foreach ($xml as $key => $value) {
            echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "User XML file not found.";
    }
} elseif ($action === 'pay_bill') {
    // Update payment date to today's date in the XML file
    $filePath = "./users/{$user}.xml";
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        $xml->date = date('m-d-y');
        $xml->asXML($filePath);
        echo "Payment date updated to today.";
    } else {
        echo "User XML file not found.";
    }
} else {
    echo "Invalid action selected.";
}
?>
