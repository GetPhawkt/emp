<?php


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
    echo '<form action="info.php" method="post">';
    echo '<table>';
    echo '<tr><th>Users</th><th>Action</th><th>Size</th></tr>';
    
    foreach ($userFiles as $user) {
        echo '<tr>';
        echo '<td><input type="radio"  name="user" id="'. $user .'" value="' . $user . '">' . $user . '</td>';
        echo '<td><select name="action"><option value="delete">Delete</option><option value="make_admin">Make Admin</option><option value="get_info">Get Info</option><option value="pay_bill">Pay Bill</option></select></td>';
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
