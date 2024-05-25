<?php
require_once('classes/geoplugin.class.php');
function short($url) { return file_get_contents("http://tinyurl.com/api-create.php?url=".$url); } 

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
    $filePath = 'notifications/notes.txt';
    
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





// Example usage
//validateUser(123, "john_doe", "password123", "1234567890", "john@example.com", "01-01-2022");


// Usage example
//$folderPath = '/path/to/folder';
//listZipFiles($folderPath);

session_start();
      
if(isset($_SESSION['username'])) 
{
$username =  $_SESSION['username'];

$url = 'https://www.alternativeware.space/'.$username.'/';

$xmlFile = "users/" . $username . ".xml";

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);

    foreach ($xml->children() as $child) {
        $sessionName = $child->getName();
        $sessionValue = (string) $child;

        $_SESSION[$sessionName] = $sessionValue;
        ${$sessionName} = $sessionValue;
    }
} else {
    echo "XML file not found for the given username.";
}




} else header("Location: billing.php"); 

copyFileToUserDirectory($username);
?>

<html>
    <head>
        <title> <?php echo($username.' AlternativeWare - EMP Dashboard'); ?></title>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <script src="//code.jivosite.com/widget/WhAo9nyAVr" async></script>
       
        <style>
        /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
            .tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #cccc;
}
#downloadBtn {
    height: 40px;
    width: 88px;
}

#downloadBtn:active {
    background-color: royalblue;
    color: black;
}
#right {
    position: absolute;
    right: 0;
}
/* Style the buttons that are used to open the tab content */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
     padding: 15px 26px;
  background-color: RoyalBlue;
}

/* Create an active/current tablink class */
.tab button.active {
    color:white;
  background-color: DodgerBlue;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.notification {
  background-color:DodgerBlue;
  color: white;
  text-decoration: none;
  padding: 15px 26px;
  position: relative;
  display: inline-block;
  border-radius: 1px;
}
.notification:hover {
  background: red;
}
.notification .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background: red;
  color: white;
} 
.btn {
  background-color: DodgerBlue; /* Blue background */
  border: none; /* Remove borders */
  color: white; /* White text */
  padding: 15px 26px; /* Some padding */
  font-size: 16px; /* Set a font size */
  cursor: pointer; /* Mouse pointer on hover */
 transition: all 0.3s;
    }
   
.button.menu {
    background-color: DodgerBlue;
    color: white;
}

.button.menu:hover {
    background-color: RoyalBlue;
}

.button.menu:active {
    background-color: Blue;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
   padding: 15px 26px;
    font-size: 16px; /* Set a font size */
}
h3 {
  text-shadow: 2px 2px  DodgerBlue;
}


    .context-menu { 
        position: absolute; 
        text-align: center; 
        background: lightgray; 
        border: none; 
    } 
  
    .context-menu ul { 
        padding: 0px; 
        margin: 0px; 
        min-width: 150px; 
        list-style: none; 
    } 
  
    .context-menu ul li { 
        padding-bottom: 7px; 
        padding-top: 7px; 
        border: 1px solid black; 
    } 
  
    .context-menu ul li a { /*<div id="errorDiv"></div> */
        text-decoration: none; 
        color: black; 
    } 
  
    .context-menu ul li:hover { 
        background: darkgray; 
    } 
    span.x {right:10px;}

        </style>
        <script>
        function fillDeviceId() {
    let deviceType = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? 'Mobile' : 'Desktop';
    document.getElementById('device').id = deviceType;
}
</script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script><!--//include jquery -->
    <script>
     function readErrorFile(){ // the function will load the contents of the php file to the errorDiv
        $('#errorDiv').load('profile/dashTabs.php');
      }
     $(function() { ///will load the function on page ready
         setTimeout(readErrorFile(), 50000); //set timeout
     });
    </script>
        <script src="https://kit.fontawesome.com/800e3fc42f.js" crossorigin="anonymous"></script>
       <script>
       function displayImageForFiveSeconds() {
    const imageUrl = 'https://www.alternativeware.space/images/loading.gif';
    
    const div = document.createElement('div');
    const img = document.createElement('img');
    
    img.src = imageUrl;
    div.appendChild(img);
    
    div.style.position = 'fixed';
    div.style.top = '50%';
    div.style.left = '50%';
    div.style.transform = 'translate(-50%, -50%)';
    div.style.zIndex = '9999';
    
    document.body.appendChild(div);
    
    setTimeout(() => {
        div.remove();
    }, 3000);
}

window.onload = displayImageForFiveSeconds();
</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">

    </script>
 <script>
     function displayforum() {
    const url = 'https://www.alternativeware.space/smf';
    const divElement = document.getElementById('forum');

    fetch(url)
        .then(response => response.text())
        .then(data => {
            divElement.innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
     </script>
<script>
function copyText(){
    let selection = window.getSelection().toString();
    if (selection) {
        navigator.clipboard.writeText(selection)
            .then(() => {
                alert('Text copied to clipboard: ' + selection);
            })
            .catch(err => {
                alert('Unable to copy text: ', err);
            });
    } else {
        alertt('No text selected to copy.');
    }
}
</script>
    <script>

        /* Add "https://api.ipify.org?format=json" to 

        get the IP Address of user*/

        $(document).ready(()=>{

            $.getJSON("https://api.ipify.org?format=json",

            function (data) {
 

                // Displayin IP address on screen

                $("#gfg").html(data.ip);

            })

        });

    </script>
        <script>
    
   
       function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
        </script>
        <script type="text/javascript"> 
        document.oncontextmenu = rightClick; 
  
        function rightClick(clickEvent) { 
            clickEvent.preventDefault(); 
            // return false; 
        } 
        
        </script><script>
        window.frames["myframe"].contentDocument.oncontextmenu = function(){
 return false; 
};
    </script> 
    <script> 
    document.onclick = hideMenu; 
    document.oncontextmenu = rightClick; 
      
    function hideMenu() { 
        document.getElementById("contextMenu") 
                .style.display = "none" 
    } 
  
    function rightClick(e) { 
        e.preventDefault(); 
  
        if (document.getElementById("contextMenu") 
                .style.display == "block") 
            hideMenu(); 
        else{ 
            var menu = document.getElementById("contextMenu") 
  
            menu.style.display = 'block'; 
            menu.style.left = e.pageX + "px"; 
            menu.style.top = e.pageY + "px"; 
        } 
    } 
</script> 
    <script>
    function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            const locationString = `Latitude: ${latitude}, Longitude: ${longitude}`;
            document.cookie = `location=${locationString}`;
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

setInterval(getLocation, 2000); // Call getLocation every 2 seconds

    </script>  
<script>
    function copyHighlightedText() {
    let selection = window.getSelection().toString();
    navigator.clipboard.writeText(selection);
}

</script>
<script>
    function pasteFromClipboard() {
    navigator.clipboard.readText()
        .then(text => {
            document.getElementById('myInput').value = text;
        })
        .catch(err => {
            console.error('Failed to read clipboard contents: ', err);
        });
}

</script>
    </head>
<body onload = displayImageForFiveSeconds();>
    <div id="contextMenu" class="context-menu" 
    style="display: none"> 
    <ul> 
        <li><a href="https://www.alternativeware.space/support" target="_blank"><i class="fa-solid fa-clipboard-question"></i> Support</a></li> 
        <li><a href="#" onclick="copyHighlightedText();"></a>Copy</a></li> 
        <li><a href="#" onclick="pasteFromClipboard();">Paste</a></li> 
        <li><a href="#">Element-4</a></li> 
        <li><a href="#">Element-5</a></li> 
        <li><a href="#">Element-6</a></li> 
        <li><a href="#">Element-7</a></li> 
    </ul> 
</div> 
    <!-- Tab links -->
<div class="tab" onload="getLocation()">
   <button class="tablinks" onclick="openCity(event, 'home')" id="defaultOpen"><i class="fa fa-home"></i> Home </button>
  <button class="tablinks" onclick="openCity(event, 'filemanager')"><i class="fa fa-folder"></i> File Manager</button>
  <button class="tablinks" onclick="openCity(event, 'Tools')"><i class="fa-solid fa-screwdriver-wrench"></i>Tools</button><button class="tablinks" onclick="openCity(event, 'Comms')"><i class="fa-regular fa-comment"></i> Comms</button>
  <button class="tablinks" onclick="openCity(event, 'Dashboard')"><i class="fa-solid fa-users"></i> Dashboard</button>
  <button class="tablinks" onclick="openCity(event, 'Maps')"><i class="fa-solid fa-file-invoice"></i>Account</button>
  <button class="tablinks" onclick="openCity(event, 'Forum')"><i class="fa-solid fa-screwdriver-wrench"></i>Forum</button>
  <button class="tablinks" onclick="openCity(event, 'Support')"><i class="fa-solid fa-screwdriver-wrench"></i>Support</button>
</div>

<!-- Tab content -->

<div id="home" class="tabcontent">
  <span class="x" onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
  <div id="ad-container"></div>
  <h3>Home</h3>
  <p id="demo"></p>
<div id="enter"></div>
<script>
document.getElementById("demo").innerHTML = 
"The full URL of this page is :" + window.location.href;
</script>
<?php $coords = getLocationCookie(); echo '<br>. '.$coords; ?>
 
    <pre id="output"></pre>

<!--
    <script type="text/javascript">
        document.getElementById('inputfile')
            .addEventListener('change', function () {
 
                let fr = new FileReader();
                fr.onload = function () {
                    document.getElementById('output')
                        .textContent = fr.result;
                }
 
                fr.readAsText(this.files[0]);
            })
    </script>
    -->
    <script>
        /**
	 * Sets the HTML content of a div element to the contents of a chosen text file.
	 *
	 * @param {string} fileAddress - The address of the text file to be loaded.
	 * @param {string} divId - The id of the div element to set the HTML content.
	 * @returns {Promise<void>} A promise that resolves when the HTML content is set successfully.
	 *
	 * @example
	 * loadTextFileToDiv('path/to/file.txt', 'myDiv')
	 *     .then(() => {
	 *         console.log('Text file loaded successfully.');
	 *     })
	 *     .catch((error) => {
	 *         console.error('Error loading text file:', error);
	 *     });
	 */
	 -->
	 </script>
	
</div>

<div id="filemanager" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
  <h3>Software</h3>
  <p>
      <script>
function change_audio_file()
{
  var file_list = document.getElementById('audio_list') ;
  var file_to_play = file_list.options[ file_list.selectedIndex ].value ;
  var player = document.getElementById('audio_player');
  player.src = file_to_play ;
}
</script>
<form>
<label for="audio_list">
Select an audio clip to load into the player. Then click the Play button on the player to start it.
</label><br>
<select onchange="change_audio_file();" id="audio_list">
<option selected value="https://www.alternativeware.space/audio/demo.mp3">thesitewizard.com</option>
<option value="https://www.alternativeware.space/audio/thefreecountry.mp3">thefreecountry.com</option>
<option value="https://www.alternativeware.space/audio/howtohaven.mp3">howtohaven.com</option>
</select>
</form>
<div id="audio_container">
<audio controls id="audio_player" src="audio/demo.mp3">
<div style="border: 1px solid black ; padding: 8px ;">
Sorry, your browser does not support this audio player.
</div>
</audio>
</div>

<div id="editor">
    <p>wysiwyg editor , go to source button to copy and paste into file manager</p>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );
</script><br><hr>
 

</p>
  <?php 
  copyFM($username);
 //generateUploadForm($username);
 generateIframe($username);
 generateUserPage($username);

?>
</div>

<div id="Tools" class="tabcontent">
   <span onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
   <h3>Tools</h3>
  <p>
  <a href="https://play.google.com/store/apps/details?id=com.fazil.code"><button class="btn">code editor for android</button></a>
  <a href="https://zzzcode.ai/code-generator?id=e654f0ea-1a47-4750-aa56-fbb008c90001" target="_blank"><button class="btn"> zzz Ai codewriter</button></a>
  </p>
 
</div>
<div id="Comms" class="tabcontent">
   <span onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
   <h3>Comms</h3>
   <iframe src="https://www.alternativeware.space/IAU/chat" width="100%" height="100%"></iframe>
 
</div>
<div id="Dashboard" class="tabcontent">
   <span onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
   <h3>Dashboard</h3>
   <script> 
   function getUserOS() {
    const userOS = window.navigator.platform;
    const osParagraph = document.getElementById('os');
    
    if (osParagraph) {
        osParagraph.textContent = `Your operating system is: ${userOS}`;
    } else {
        console.error('Paragraph element with id "os" not found.');
    }
} 
</script>
   <?php 
   $geoplugin = new geoPlugin();
// If we wanted to change the base currency, we would uncomment the following line
// $geoplugin->currency = 'EUR';
 
$geoplugin->locate();
   $website = short($url);
   $folders = countUserFolders($username);
   $fileCount = countFilesInNestedDirectories($username);
   $userEmail = getUserEmail($username);
   $phoneNumber = getUserPhoneNumber($username);
   $folderSize = getUserFolderSize($username);
   $imagecount = countUserMediaFiles($username);
   $userDevice = getUserDeviceType(); 
   $userOS = getUserOS();
   $duedate = duedate($username);
   echo('<!DOCTYPE html>
<html lang="en">
<head>
  <title>EMP USER</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script>
  function showCoordinates() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(displayCoordinates);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function displayCoordinates(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    document.getElementById("coords").innerHTML = "Latitude: " + latitude + "<br>Longitude: " + longitude;
}

</script>

  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    #upper1 {
    background-color: red;
    color: white;
    }
    
    #upper2 {
    background-color: orange;
    color: white;
    }
    #upper3 { 
    background-color:DodgerBlue;
    color: white;
    }
    
    #upper4 { background-color: Tomato;
    color: white;
    } 
     #upper5 {
    background-color: SlateBlue;
    color: white;
    }
    #side { 
    width: 155px;
    height: 300px;
    overflow: auto;
    background-color:black;
    color: white;
}
#upper6 { height: 130px;
         background-color: yellowgreen; 
         color: white;
         overflow: auto;
}
#upper7 { height: 130px;
         background-color: 800000; 
         color: white;
         overflow: auto;
} 
#upper8 { height: 130px;
         background-color: MidnightBlue; 
         color: white;
         overflow: auto;
} 

#upper9 { height: 130px;
         background-color: CD5C5C; 
         color: white;
         overflow: auto;
} 
        
    /* On small screens, set height to \'auto\' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  </style>
</head>
<body onload="getUserOS();
">

<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid"> lt225 / 75 / r16  115/112Q
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><img src="https://www.alternativeware.space/images/emp_small.png" width="150" height="100"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
       <!-- <ul class="nav navbar-nav"> -->
       <ul>
        <li><a href="#">Dashboard</a><br></li>
        <li><a href="#">Age</a><br></li>
        <li><a href="#">Gender</a><br></li>
        <li><a href="#">Geo</a><br></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs" id="side">
      <h2><img src="https://www.alternativeware.space/images/emp_small.png" width="150" height="100"></h2>
      <!-- <ul class="nav nav-pills nav-stacked"> --> 
      <ul>
        <li><a href="#">Dashboard</a><br></li>
        <li><a href="#section2">Age</a><br></li>
        <li><a href="#section3">Gender</a><br></li>
        <li><a href="#section3">Geo</a><br></li>
      </ul><br>
    </div>
    <br>
    
    <div class="col-sm-9">
      <div class="well">
        <h3>'.$username.'</h3>
        '.checkUserRole($username).'<br>
       <p> Your website url is: '.$website.'</p>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well" id="upper1">
            <h3> <i class="fa-regular fa-folder"></i>Total folders</h3>
            <p><big>'.$folders.'</big></p> 
            
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" id="upper2">
            <h3><i class="fa-regular fa-file"></i>Total Pages</h3>
            <p><big>'.$fileCount.'</big></p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" id="upper4">
            <h3><i class="fa-regular fa-floppy-disk"></i> Directory Size</h3>
            <p>'.$folderSize.'</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" id="upper3">
            <h3><i class="fa-solid fa-photo-film"></i><br> Media Files</h3>
            <p>'.$imagecount.'</p> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4" >
          <div class="well" id="upper6">
            <p><h3> <i class="fa-solid fa-globe"></i> Ip address</h3></p> 
             <p id="gfg"></p>
            <p><b>Device Type </b>: '.$userDevice.'</p>
            <p><b>O.S. </b> :'.$userOS.'</p>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well" id="upper8"> <h3><i class="fa-solid fa-code"></i> Parent Files:</h3>
            '.listUserFiles($username).'

          </div>
        </div>
        <div class="col-sm-4" >
          <div class="well" id="upper7">
          <h3>details</h3>
            <p><b>Email </b>:'.$userEmail.'</p> 
            <p><b>Phone </b>:'.$phoneNumber.'</p> 
            <p> <b>City </b>: '.$geoplugin->city.' </p>
            <p<b> Region </b>: '.$geoplugin->regionCode.'</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="well">
            <p>News</p><br>
            '.checkNotifications().'
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <p>'.checkNotifications().'</p> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>');
   ?>
  
</div>
<div id="Maps" class="tabcontent">
   <span onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
   <h3>Acount invoice</h3>
  <p><?php $userdate = getUserDate($username);
  
  echo 'hi '.$username.' last time you paid was: '.$userdate;
  echo '<br>Next time your bill is due is :'.$duedate.'<br
  Your billing is :'.checkLate($userdate);
  echo '<hr color="red"> <h1> Directory contents & info </h1> <br>';
  $userDirectoryInfo = getUserDirectoryInfo($username);
echo 'your directory information is :'.$userDirectoryInfo.'<br><hr color-"Dodgerblue"';
echo $username.'\'s file list<br>'.generateFileList($username);
  ?>
  </p>
 
</div> 

<script>
function comment() {
    document.getElementById('content').innerHTML = '';
    fetch('comment.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
        });
</script> 

<div id="Forum" class="tabcontent">
   <span onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
   <h3 >Forum</h3>
  <div id="smf"><iframe src="https://www.alternativeware.space/mybb" width="100%" height="100%" style="border: none;"></iframe></div>
 
</div> 
<div id="Support" class="tabcontent">
   <span onclick="this.parentElement.style.display='none'"><button class="btn"><i class="fa fa-close"></i> Close</button></span>
   <h3>Support</h3>
  <p>
  </p>
  <iframe src="https://www.alternativeware.space/hesk" width="100%" height="100%"></iframe>
 
</div> 
<script>
    function toggleDarkMode() {
    const checkbox = document.getElementById('darkmode');
    const body = document.body;

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            body.style.backgroundColor = 'black';
            body.style.color = 'white';
        } else {
            body.style.backgroundColor = 'white';
            body.style.color = 'black';
        }
    });
}
</script>
<script>
function goHome() {
  document.getElementsByName('main')[0].src = 'https://www.alternativeware.space/weather/weather-app/weather-app/dist';
}
</script>
<script>
function downloads() {
  document.getElementsByName('main')[0].src = 'https://alternativeware.space/downloads.php';
}
</script>
<script>
function freebooks() {
  document.getElementsByName('main')[0].src = 'https://www.alternativeware.space/books.php';
}
</script>
<script>
function freebooks() {
  document.getElementsByName('main')[0].src = 'https://www.alternativeware.space/books.php';
}
</script>
<hr color="Red">
<div id="right"><label class="switch" value="Darkmode"> 
  <input type="checkbox" id="darkmode" name="darkmode" onclick="toggleDarkMode()">
  <span class="slider"></span>
</label><h2>Dark Mode</h2></div><br>
<hr color="red">
<button id="downloadBtn"  style="background-color: dodgerblue; color: white; border-radius: 20px;" onclick="goHome()">Weather</button>
<button id="downloadBtn"  style="background-color: dodgerblue; color: white; border-radius: 20px;" onclick="downloads()">Downloads</button>
<button id="downloadBtn"  style="background-color: dodgerblue; color: white; border-radius: 20px;" onclick="freebooks()">Free Books</button>


 <iframe name="main" src="https://www.alternativeware.space/weather/weather-app/weather-app/dist" height="100%" width="100%"></iframe>   
    
<?php


$footer = file_get_contents('footer.php');
echo $footer;
?>
</body>