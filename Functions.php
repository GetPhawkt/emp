<?php  
// twilio pass sixteenCharecter1
/*ftpupload.net
FTP Username:	ezyro_36951227
FTP Password:	0a7dac479ff 

Nameserver 1:	ns1.unaux.com
Nameserver 2:	ns2.unaux.com 

Username:	ezyro_36951227
Status:	Active
Main Domain:	emp-net.unaux.com
Builders Created:	0
Created On:	2024-07-21 22:34:05 
*/ 


// Create an instance of the EMPMaster class
/*$emp = new EMPMaster('john_doe', 'password123');

// Accessing methods
echo $emp->getUsername(); // Output: john_doe
echo $emp->getPassword(); // Output: password123
$emp->hello_world(); // Output: Hello World 
*/

 function updateLastLoggedDate($username) {
    $xmlFile = "users/{$username}.xml";

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        $xml->lastlogged = date('m-d-y');
        $xml->asXML($xmlFile);
        echo '<h1> Welcome ' . $username . '! </h1>';
    } else {
        echo "Can't find user";
    }
}


function getDirContents($dir, $filter = '', &$results = array()) {
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 

        if(!is_dir($path)) {
            if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
        } elseif($value != "." && $value != "..") {
            getDirContents($path, $filter, $results);
        }
    }

    return $results;
}  

function editFile($fileName) {
    if (!file_exists($fileName)) {
        echo "File doesn't exist.";
    } else {
        $fileContent = file_get_contents($fileName);
        $editedContent = str_replace('public function', 'function', $fileContent);
        $newFileName = $fileName . '(edited)';
        
        file_put_contents($newFileName, $editedContent);
        
        echo "Success! <br> <small> make sure to rename the file !!</small><br>";
        echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #f9f9f9; padding: 20px; border: 1px solid #ccc;'>";
        echo "<button style='position: absolute; top: 0; right: 0;' onclick='this.parentNode.style.display=\"none\"'>Close</button>";
        echo "<textarea style='width: 100%; height: 100%;'>$editedContent</textarea>";
        echo "</div>";
    }
}  
function generateXMLFromFolder($folder, $email) {
    $xml = new SimpleXMLElement('<root></root>');
    $directories = scandir($folder);
    
    foreach($directories as $item) {
        if(is_dir($folder.'/'.$item) && $item != '.' && $item != '..') {
            $folderNode = $xml->addChild('folder', $item);
            $files = scandir($folder.'/'.$item);
            
            foreach($files as $file) {
                if(is_file($folder.'/'.$item.'/'.$file)) {
                    $fileNode = $folderNode->addChild('file', $file);
                }
            }
        }
    }
    
    $xml->asXML('EMP/public/logs/search.xml');
    echo 'done';
}

function loadsiteNav(){
    echo'<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Navbar with Bootstrap and Font Awesome</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="https://www.alternativeware.space/images/emp_small.png" alt="Logo" height="40"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Menu
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#dealsOffcanvas">Deals</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">About</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="EMP/login.php" method="post">
          <input type="text" id="username" name="username" placeholder="Username">
          <input type="password" id="password" name="password" placeholder="Password">
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> 
      <div class="modal-body">
        <iframe width="100%" height="100%" src="./EMP/register.php"></iframe><p></p>
      </div>
    </div>
  </div>
</div>

<!-- Deals Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="dealsOffcanvas" aria-labelledby="dealsOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 id="dealsOffcanvasLabel">Deals</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      <iframe src="EMP/deals.php" style="width: 100%; height: 100%;" frameborder="0"></iframe>
    </div>
    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Close</button>
  </div>
</div>

<!-- About Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="aboutModalLabel">About EMP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>EMP is a non-profit, for-profit entity that empowers its members and the community with networking and providing services and connections to resources in a variety of solutions that change by what each specific chapter and teams provide.</p>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
';
}

function postFilesToUrl($directory, $url) {
    $files = scandir($directory);
    $fileCount = count($files) - 2; // Subtract 2 for . and ..
    
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $ch = curl_init();
            $postFields = array('file' => new CURLFile($directory . '/' . $file));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_exec($ch);
            curl_close($ch);
            
            $fileCount--;
            echo "Files remaining: $fileCount\n";
        }
    }
    
    echo "Success!";
}

function uploadFilesToUrl($directory, $url) {
    $files = glob($directory . '/*');
    $zip = new ZipArchive();
    $zipName = 'files.zip';
    $zip->open($zipName, ZipArchive::CREATE);

    foreach ($files as $file) {
        $zip->addFile($file, basename($file));
    }
    $zip->close();

    $ch = curl_init();
    $fileSize = filesize($zipName);
    $completedBytes = 0;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_INFILE, fopen($zipName, 'r'));
    curl_setopt($ch, CURLOPT_INFILESIZE, $fileSize);
    curl_setopt($ch, CURLOPT_UPLOAD, true);

    $fp = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $str) use ($fp, &$completedBytes, $fileSize) {
        $completedBytes += strlen($str);
        echo round($completedBytes / $fileSize * 100, 2) . '% transferred / ' . $completedBytes . ' bytes transferred' . PHP_EOL;
        echo 'Progress: ' . round($fileSize / $completedBytes, 2) . PHP_EOL;
        fwrite($fp, $str);
        return strlen($str);
    });

    curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        echo 'Complete' . PHP_EOL;
        echo 'File transfer completed successfully';
    }

    curl_close($ch);
    fclose($fp);
}

function fixmyPhp($fileName) {
    $fileInfo = pathinfo($fileName);
    $fileContent = file_get_contents($fileName);
    $modifiedContent = str_replace('function', 'public function', $fileContent);
    $newFileName = $fileInfo['filename'] . '(1).' . $fileInfo['extension'];
    file_put_contents($newFileName, $modifiedContent);
}

function generateImageDivs($price,$email) {
    $serverDomain = $_SERVER['SERVER_NAME'];
    $currentFolder = basename(__DIR__);
    $address = $serverDomain . '/' . $currentFolder;

    $categoryFolder = 'category1';
    if (!is_dir($categoryFolder)) {
        mkdir($categoryFolder);
    }
    $email = $email; 
    
$url = $serverDomain . '/' . $currentFolder.'/'.$categoryFolder;
    $imageFiles = glob($categoryFolder . '/*.jpg');
    foreach ($imageFiles as $image) {
        $url = $serverDomain . '/' . $currentFolder.'/'.$categoryFolder.'/'.$image;
        echo "<div id='image'>";
        echo "<div style='width: 300px; height: 300px; border-radius: 50%; background: url($image) center/cover; filter: blur(5px);'></div>";
        generatePayPalBuyNowButton($email, $price, $url);
        echo "</div>";
    }
}
function mailCount($username) {
    $userFolder = "ClientBin/{$username}";
    $msgFolder = "{$userFolder}/msg";

    if (!is_dir($msgFolder)) {
        mkdir($msgFolder, 0777, true);
    }

    $xmlFiles = glob("{$msgFolder}/*.xml");
    $fileCount = count($xmlFiles);

    return strval($fileCount);
}

function generatePayPalButton($email, $price, $url) {
    echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>";
    echo "<input type='hidden' name='cmd' value='_xclick'>";
    echo "<input type='hidden' name='business' value='$email'>";
    echo "<input type='hidden' name='currency_code' value='USD'>";
    echo "<input type='hidden' name='amount' value='$price'>";
    echo "<input type='hidden' name='item_name' value='Esales'>";
    echo "<input type='hidden' name='return' value='$url'>";
    echo "<input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online'>";
    echo "</form>";
}


function generatePayPalBuyNowButton($email, $price, $url) {
    echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>";
    echo "<input type='hidden' name='cmd' value='_xclick'>";
    echo "<input type='hidden' name='business' value='$email'>";
    echo "<input type='hidden' name='currency_code' value='USD'>";
    echo "<input type='hidden' name='amount' value='$price'>";
    echo "<input type='hidden' name='return' value='$url'>";
    echo "<input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online'>";
    echo "</form>";
}


function generateVenmoQRCode($email, $price) {
    $venmoURL = "https://venmo.com/{$email}?txn=pay&amount={$price}";
    $qrCodeURL = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($venmoURL);
    
    echo "<img src='{$qrCodeURL}' alt='Venmo QR Code'>";
}

function generateCashAppQR($email, $price) {
    $cashAppLink = "https://cash.app/\$".urlencode($price)."?recipient=".$email;
    echo "<img src='https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=".$cashAppLink."' alt='CashApp QR Code'>";
}

function short($url) { return file_get_contents("http://tinyurl.com/api-create.php?url=".$url); } 

function updateUserAuth($username) {
    $usersFolder = 'users/';
    $assetsFolder = 'assets/scripts/';
    
    $xml = simplexml_load_file($usersFolder . $username . '.xml');
    $password = (string)$xml->password;
    
    $fileContents = file_get_contents($assetsFolder . 'fm.emp');
    $fileContents = str_replace("\$http_host = \$_SERVER['HTTP_HOST'];", "\$_SERVER['HTTP_HOST'].'/ $username'", $fileContents);
    
    $userFolder = $username . '/';
    if (!is_dir($userFolder)) {
        mkdir($userFolder, 0777, true);
    }
    
    $newFile = $userFolder . 'a.php';
    if (file_exists($newFile)) {
        $existingContents = file_get_contents($newFile);
        if ($existingContents !== $fileContents) {
            file_put_contents($newFile, $fileContents);
            chmod($newFile, 0777);
        }
    } else {
        file_put_contents($newFile, $fileContents);
        chmod($newFile, 0777);
    }
}


function displayDynamicContent($username) {
    if (!isset($_COOKIE['username'])) {
        setcookie('username', $username, time() + 3600, '/');
    }

    $file = file_get_contents('public/feeds/feeds.emp');

    $file = str_replace(':)', '<i class="fa-regular fa-face-smile"></i>', $file);
    $file = str_replace(':(', '<i class="fa-regular fa-face-frown"></i>', $file);
    $file = str_replace(':x', '<i class="far fa-kiss-beam"></i>', $file);
    $file = str_replace(':-x', '<i class="far fa-kiss-beam"></i>', $file);

    $file = '<div id="feeds" style="width: 70%; height: 80%; overflow-y: scroll; margin: 0 auto;">' . $file . '</div>';

    echo $file;
}

function displayFiles($directory) {
    $images = [];
    $videos = [];

    // Read files from the directory
    $files = scandir($directory);

    // Separate images and videos
    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        $extension = strtolower($fileInfo['extension']);

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $images[] = $file;
        } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
            $videos[] = $file;
        }
    }

    // Display images in a table column
    echo '<table><tr><th>Images</th><th>Videos</th></tr>';
    echo '<tr><td><div id="picture" style="width: 500px; height: 700px;">';
    foreach ($images as $image) {
        echo '<img src="' . $directory . '/' . $image . '" alt="Image">';
    }
    echo '</div></td>';

    // Display videos in a table column
    echo '<td>';
    foreach ($videos as $video) {
        echo '<video controls width="500" height="300">';
        echo '<source src="' . $directory . '/' . $video . '" type="video/mp4">';
        echo 'Your browser does not support the video tag.';
        echo '</video>';
    }
    echo '</td></tr></table>';
}

// Call the function with the directory path
//displayFiles('/path/to/directory');
function createEmpdateFile() {
    if (is_dir('addons')) {
        $files = scandir('addons');
        $phpFiles = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });

        $content = "<?php\n";
        foreach ($phpFiles as $phpFile) {
            $content .= "include 'addons/$phpFile';\n";
        }

        file_put_contents('addons/empdate.php', $content);
    }
}

function generateUserPage($username) {
    $folderPath = "./$username/";
    if (!file_exists($folderPath . "index.php") && !file_exists($folderPath . "index.html")) {
        $fileContent = "<!DOCTYPE html>\n<html>\n<head>\n<meta name='description' content='emp hosting'>\n<style>body {background-color: black; color: white;}</style>\n<script src='js/bar.js'></script>\n</head>\n<body>\n<h1>Coming Soon, $username's Page!</h1>\n<marquee behavior='scroll' direction='left' style='color: red;'><a href='https://www.alternativeware.space'>https://www.alternativeware.space</a></marquee>\n</body>\n</html>";
        file_put_contents($folderPath . "index.html", $fileContent);
    }
}


function generateUploadForm($username) {
     $directory = "./$username";
    $file = "a.php";

    if (!file_exists("$directory/$file") || (fileperms("$directory/$file") & 0777) !== 0777) {
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        copy($file, "$directory/$file");
        chmod("$directory/$file", 0777);
    }
}
function getLocationCookie() {
    sleep(2); // Wait for 2 seconds
    if(isset($_COOKIE['location'])) {
        return $_COOKIE['location'];
    } else {
        return "Cookie 'location' not found.";
    }
}

function countUserMediaFiles($username) {
    $userDirectory = $username;
    $fileTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
    $fileCount = 0;

    if (is_dir($userDirectory)) {
        $files = scandir($userDirectory);
        
        foreach ($files as $file) {
            $fileExt = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($fileExt, $fileTypes)) {
                $fileCount++;
            }
        }
    }

    return $fileCount;
}
function copyFM($username) {
    $sourceFile = 'a.php';
    $destinationDirectory = './' . $username;

    if (!is_dir($destinationDirectory)) {
        return; // Exit if the directory doesn't exist
    }

    copy($sourceFile, $destinationDirectory . '/' . $sourceFile);
    chmod($destinationDirectory . '/' . $sourceFile, 0777);
}
function duedate($username) {
    $filePath = "users/{$username}.xml";
    
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        $date = (string)$xml->date;
        
        $currentDate = DateTime::createFromFormat('m-d-y', $date);
        $currentDate->modify('+1 month');
        
        return $currentDate->format('m-d-y');
    } else {
        return "User data not found.";
    }
}
function getUserOS() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $os = "Unknown";
    
    if (strpos($userAgent, "Windows") !== false) {
        $os = "Windows";
    } elseif (strpos($userAgent, "Mac") !== false) {
        $os = "Mac";
    } elseif (strpos($userAgent, "Linux") !== false) {
        $os = "Linux";
    } elseif (strpos($userAgent, "Android") !== false) {
        $os = "Android";
    } elseif (strpos($userAgent, "iOS") !== false) {
        $os = "iOS";
    }
    
    return $os;
}

function countFilesInNestedDirectories($username) {
    $directory = $username;

    $fileCount = 0;

    if (is_dir($directory)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $fileCount++;
            }
        }
    }

    return $fileCount;
} 


function getUserFolderSize($username) {
    if (is_dir($username)) {
        $total_size = 0;
        $files = scandir($username);

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $total_size += filesize($username . '/' . $file);
            }
        }

        return round($total_size / 1048576, 2) . ' MB';
    } else {
        return 'Directory not found';
    }
} 


function getUserPhoneNumber($username) {
    $filePath = "users/{$username}.xml";
    
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        $phoneNumber = (string) $xml->phone;
        return $phoneNumber;
    } else {
        return "Phone number not found for {$username}.";
    }
}

function getUserEmail($username) {
    $filePath = "users/{$username}.xml";
    
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        $email = (string) $xml->email;
        return $email;
    } else {
        return "User email not found.";
    }
}

function getUserDeviceType() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    $deviceTypes = array(
        'Windows Phone' => 'Windows Phone',
        'iPhone' => 'iPhone',
        'iPad' => 'iPad',
        'Android' => 'Android',
        'BlackBerry' => 'BlackBerry',
        'Kindle' => 'Kindle',
        'Opera Mini' => 'Opera Mini',
        'Mobile' => 'Mobile'
    );

    foreach ($deviceTypes as $device => $value) {
        if (stripos($userAgent, $device) !== false) {
            return $value;
        }
    }

    return 'Desktop';
}



//twiliocode YMEVQPL96K5Z1T6UWTFNFRPJ
//https://stackoverflow.com/questions/73536640/save-div-contents-as-a-file-and-load-div-contents-from-file - div content uplosd code

//https://stackoverflow.com/questions/46202340/fine-uploader-php-endpoint-specify-upload-folder - fine uploader edit
function listUserFiles($username) {
    $directory = "./$username";
    $files = scandir($directory);
    $fileList = "";

    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $fileList .= $file . "\n <br>";
        }
    }

    return $fileList;
}

// Example Usage

//echo listUserFiles($username);


function checkNotifications() {
    $filePath = 'assets/notifications/notes.txt';
    
    if (file_exists($filePath)) {
        $fileContent = file_get_contents($filePath);
        
        if (empty($fileContent)) {
            echo "No new notifications at this time";
            return "No new notifications at this time";
        } else {
            // Process the notifications if needed
            return $fileContent;
        }
    } else {
        return "File not found";
    }
}

// Call the function
//echo checkNotifications();


// Call the function to check notifications
//checkNotifications()

//https://www.htmlbasix.com/generator/rotating-banner-code-generator
   function copyFileToUserDirectory($username) {
    $sourceFile = 'a.php';
    $destinationDirectory = $username;

    if (!file_exists($destinationDirectory)) {
        mkdir($destinationDirectory, 0777, true);
    }

    copy($sourceFile, $destinationDirectory . '/' . $sourceFile);
}


function generateIframe($username) {
    echo "<iframe src='./$username/a.php' width='100%' height='100%'></iframe>";
}
function generateFileList($username) {
    $basePath = '/' . $username . '/';
    
    if (is_dir($basePath)) {
        $files = scandir($basePath);
        $fileList = [];

        foreach ($files as $file) {
            if (is_file($basePath . $file)) {
                $fileList[$file] = filesize($basePath . $file) . ' bytes';
            }
        }

        asort($fileList); // Sort the file list alphabetically

        foreach ($fileList as $fileName => $fileSize) {
            echo $fileName . ' - ' . $fileSize . PHP_EOL;
        }
    } else {
        echo 'Directory not found.';
    }
}

// Usage
//generateFileList('example_username');


function countUserFolders($username) {
    $path = $username;
    $folderCount = 0;

    if (is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if (is_dir($path . '/' . $file) && $file != '.' && $file != '..') {
                $folderCount++;
            }
        }
    }

    return $folderCount;
}

// Example Usage
//$username = 'john_doe';
//$Folders = countUserFolders($username);
//echo "Total folders for user $username: $folderCount";


function checkUserRole($username) {

$filePath = "users/{$username}.xml";
    
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        $role = (string)$xml->role;
        
        if ($role !== "member") {
            echo 'admin';
        } else {
            echo ('member');
        }
    } else {
        echo "User not found";
    }
}

function getUserDirectoryInfo($username) {
    $directoryPath = "{$username}";

    if (!is_dir($directoryPath)) {
        return "Directory not found for user: {$username}";
    }

    $totalSize = 0;
    $totalItems = 0;
    $directoryInfo = "";

    $directoryIterator = new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS);
    $iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        if ($item->isDir()) {
            $directoryInfo .= "Directory: {$item} (Size: " . filesize($item) . " bytes)<br>";
        } else {
            $totalSize += filesize($item);
            $totalItems++;
            $directoryInfo .= "File: {$item} (Size: " . filesize($item) . " bytes)<br>";
        }
    }

    $totalSizeInGB = number_format($totalSize / 1073741824, 2);
    $directoryInfo .= "\nTotal Size: {$totalSizeInGB} GB\nTotal Items: {$totalItems}<br>";

    return $directoryInfo;
}
function checkLate($givenDate) {
    $today = date("d-m-Y");
    $givenDateTime = strtotime($givenDate);
    $todayDateTime = strtotime($today);
    
    $difference = ($todayDateTime - $givenDateTime) / (60 * 60 * 24);
    
    if ($difference < 30) {
        echo "late";
    } else echo "on time<br>";
}

function getUserDate($username) {
    $filePath = "users/{$username}.xml";
    
    if (file_exists($filePath)) {
        $xml = simplexml_load_file($filePath);
        $date = (string) $xml->date;
        return $date;
    } else {
        return "User data not found";
    }
}



function retrieveUserInfo($username) {
    $xmlFile = "users/" . $username . ".xml";
    
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        
        foreach ($xml->children() as $child) {
            $sessionName = $child->getName();
            $sessionValue = (string) $child;
            
            $_SESSION[$sessionName] = $sessionValue;
        }
        
        foreach ($_SESSION as $sessionName => $sessionValue) {
            echo $sessionName . ": " . $sessionValue . "<br>";
        }
    } else {
        echo "data file not found for username: " . $username;
    }
}


function countusers() {
    $directory = 'users';
    $files = glob($directory . '/*.xml');
    $count = count($files);
    return strval($count);
}




function encrypt($input) {
    $alphabet = range('a', 'z');
    $half = count($alphabet) / 2;
    $firstHalf = array_slice($alphabet, 0, $half);
    $secondHalf = array_slice($alphabet, $half);

    $encrypted = str_split($input);
    foreach ($encrypted as $key => $char) {
        if (is_numeric($char)) {
            $encrypted[$key] = chr($char + 96);
        } elseif (ctype_alpha($char)) {
            $index = array_search(strtolower($char), $firstHalf);
            if ($index !== false) {
                $encrypted[$key] = $secondHalf[$index];
            } else {
                $index = array_search(strtolower($char), $secondHalf);
                $encrypted[$key] = $firstHalf[$index];
            }
        }
    }

    return implode('', $encrypted);
}

function decrypt($input) {
    $alphabet = range('a', 'z');
    $half = count($alphabet) / 2;
    $firstHalf = array_slice($alphabet, 0, $half);
    $secondHalf = array_slice($alphabet, $half);

    $decrypted = str_split($input);
    foreach ($decrypted as $key => $char) {
        if (is_numeric($char)) {
            $decrypted[$key] = ord($char) - 96;
        } elseif (ctype_alpha($char)) {
            $index = array_search(strtolower($char), $firstHalf);
            if ($index !== false) {
                $decrypted[$key] = $secondHalf[$index];
            } else {
                $index = array_search(strtolower($char), $secondHalf);
                $decrypted[$key] = $firstHalf[$index];
            }
        }
    }

    return implode('', $decrypted);
}

// the next is aes enryption 
function encryptMessage($message, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($message, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptMessage($encrypted, $key) {
    $data = base64_decode($encrypted);
    $iv = substr($data, 0, 16);
    $encrypted = substr($data, 16);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
} 
// you have to enter key , example
/*
$message ='hello world';
$key = '114';
$encrypt = encryptMessage($message, $key);
$decrypt = decryptMessage($message, $key);
echo($message);
echo($encrypt); 
*/ 
function echoUrlPage($url) {
    $file = fopen($url, 'r');
    while (!feof($file)) {
        echo fgets($file);
    }
    fclose($file);
}

// Call the function with a URL
//echoUrlPage("https://www.example.com");

function generateDivWithRandomId($url) {
    $randomId = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 6)), 0, 6);
    $randomInt = rand(100, 999);
    $divId = $randomId . $randomInt;
    $divName = $divId;

    echo "<div id='$divId' name='$divName'></div>";
    echo "<script>";
    echo "var xhr = new XMLHttpRequest();";
    echo "xhr.open('GET', '$url', true);";
    echo "xhr.onreadystatechange = function() {";
    echo "if (xhr.readyState == 4 && xhr.status == 200) {";
    echo "document.getElementById('$divId').innerHTML = xhr.responseText;";
    echo "}";
    echo "}";
    echo "xhr.send();";
    echo "</script>";
}

// Call the function with a sample URL
// generateDivWithRandomId('https://example.com');

function searchfile($directory, $keywords) {
    $keywords = strtolower($keywords);
    
    $allowedExtensions = ['html', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'mp3', 'wav', 'pdf'];
    
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    
    foreach ($iterator as $file) {
        if ($file->isFile() && in_array(pathinfo($file, PATHINFO_EXTENSION), $allowedExtensions)) {
            $filename = strtolower(pathinfo($file, PATHINFO_FILENAME));
            
            if (strpos($filename, $keywords) !== false) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['html'])) {
                    $lines = file($file);
                    foreach ($lines as $line) {
                        if (stripos($line, $keywords) !== false) {
                            echo "<a href='$file'>$file</a><br>";
                            break;
                        }
                    }
                } elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "<img src='$file' alt='$filename'><br>";
                } elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), ['mp3', 'wav'])) {
                    echo "<audio controls><source src='$file' type='audio/mpeg'></audio><br>";
                } elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), ['mp4', 'avi', 'mov'])) {
                    echo "<video controls><source src='$file' type='video/mp4'></video><br>";
                    echo "<a href='$file'>Download Video</a><br>";
                } elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), ['pdf'])) {
                    echo "<a href='$file'>Download PDF</a><br>";
                }
            }
        }
    }
}


function generateDuckDuckGoSearchURL($keywords) {
    $keywords = str_replace(' ', '+', $keywords);
    return 'https://duckduckgo.com/?q=' . $keywords;
}

function generateBingSearchURL($keywords) {
    $keywords = str_replace(' ', '+', $keywords);
    return 'https://www.bing.com/search?q=' . $keywords;
}


function generateGoogleSearchURL($keywords) {
    $searchQuery = str_replace(' ', '+', $keywords);
    $url = 'https://www.google.com/search?q=' . $searchQuery;
    return $url;
}

function generateAmazonSearchURL($keywords) {
    $keywords = str_replace(' ', '+', $keywords);
    return "https://www.amazon.com/s?k={$keywords}&ref=nb_sb_noss_2";
}

function generateAskJeevesSearchURL($keywords) {
    $keywords = str_replace(' ', '+', $keywords);
    return "https://www.askjeeves.com/search?q=$keywords";
}

function generateDogpileSearchURL($keywords) {
    $keywords = str_replace(' ', '+', $keywords);
    return 'https://www.dogpile.com/search/web?q=' . $keywords;
}

function generateGitHubSearchURL($keywords) {
    $searchQuery = str_replace(' ', '+', $keywords);
    $url = "https://github.com/search?q={$searchQuery}";
    return $url;
}

?>
