<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $user = $_POST['user'];

    if ($action == 'backup') {
        $userFolder = "./$user";
        $backupFolder = "./backup";

        if (!file_exists($backupFolder)) {
            mkdir($backupFolder);
        }

        $zip = new ZipArchive;
        $zipFileName = "$user.zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            $zip->addEmptyDir($user);
            $zip->close();
        }

        copy($zipFileName, "$user/$zipFileName");
        copy($zipFileName, "backup/$zipFileName");
    } elseif ($action == 'delete') {
        $userFolder = "./$user";
        $filesDeleted = 0;

        if (file_exists($userFolder)) {
            $files = glob("$userFolder/*");
            foreach ($files as $file) {
                if (is_file($file)||(is_dir($file))) {
                    unlink($file);
                    $filesDeleted++;
                }
            }
            rmdir($userFolder);
        }

        $xmlFile = "./users/$user.xml";
        if (file_exists($xmlFile)) {
            unlink($xmlFile);
        }

        $logFile = "./notifications/logs.txt";
        $logEntry = date('Y-m-d H:i:s') . " - User $user was deleted. $filesDeleted files were deleted.\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);

        echo "User $user and associated directories and XML were deleted. $filesDeleted files were deleted.";
    } elseif ($action == 'make_admin') {
        $xmlFile = "./users/$user.xml";
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
            $xml->role = 'admin';
            $xml->asXML($xmlFile);

            $logFile = "./logs/admin.txt";
            $logEntry = date('Y-m-d H:i:s') . " - User $user was edited to admin.\n";
            file_put_contents($logFile, $logEntry, FILE_APPEND);

            echo "Changes have been made for user $user. User is now an admin.";
        }
    } elseif ($action == 'pay_bill') {
        $xmlFile = "./users/$user.xml";
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
            $xml->last_paid = date('d-m-y');
            $xml->asXML($xmlFile);

            $logFile = "./notifications/logs.txt";
            $logEntry = date('Y-m-d H:i:s') . " - User $user bill was paid.\n";
            file_put_contents($logFile, $logEntry, FILE_APPEND);

            echo "User $user bill was successfully paid.";
        }
    } elseif ($action == 'get_info') {
        $xmlFile = "./users/$user.xml";
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
            foreach ($xml as $key => $value) {
                echo "$key: $value\n";
            }

            $userFolder = "./$user";
            if (file_exists($userFolder)) {
                $folderSize = 0;
                $files = glob("$userFolder/*");
                foreach ($files as $file) {
                    $folderSize += filesize($file);
                }
                $dateCreated = date("F d Y", filectime($userFolder));
                echo "Folder Size: $folderSize bytes\n";
                echo "Date Created: $dateCreated\n";
            }
        }
    }
}



function processUserData() {
    $userFiles = [];
    $directory = 'users';
    
    // Check if the directory exists
    if (is_dir($directory)) {
        // Open the directory
        if ($handle = opendir($directory)) {
            // Read directory contents
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) == 'xml') {
                    // Extract filename without extension
                    $fileName = pathinfo($file, PATHINFO_FILENAME);
                    $userFiles[] = $fileName;
                }
            }
            closedir($handle);
        }
    }
    
    // Generate HTML form
    echo '<form action="" method="post">';
    echo '<table>';
    echo '<tr><th>Users</th><th>Action</th><th>Size</th></tr>';
    
    foreach ($userFiles as $user) {
        echo '<tr>';
        echo '<td><input type="radio"  name="user" id="'. $user .'" value="' . $user . '">' . $user . '</td>';
        echo '<td><select name="action"><option value="delete">Delete</option>
        <option value="make_admin">Make Admin</option>
        <option value="backup">backup</option>
        <option value="get_info">Get Info</option>
        <option value="pay_bill">Pay Bill</option>
        </select></td>';
        echo '<td>' . getUserFolderSize($user) . ' MB</td>';
        echo '</tr>';
    }
    
    echo '</table>';
    echo '<input type="submit" value="Submit">';
    echo '</form>';
}

function getUserFolderSize($user) {
    $folder =  $user;
    $size = 0;
    
    if (is_dir($folder)) {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder)) as $file) {
            $size += $file->getSize();
        }
    }
    
    return round($size / 1048576, 2); // Convert bytes to MB
}

// Call the function to process user data

processUserData();
?>
