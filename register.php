<?php
//https://medium.com/@mursaleen5959/stripe-subscriptions-integration-in-php-e96a2313fb2
//https://phppot.com/php/how-to-manage-recurring-payments-using-paypal-subscriptions-in-php/
/*function createDirectoriesAndCopyFile($username) {
 
    $basePath = 'ClientBin/';
    
    // Create main user folder
    mkdir($basePath . $username, 0777, true);
    
    // Create logs directory
    mkdir($basePath . $username . '/logs', 0777, true);
    
    // Create msg directory
    mkdir($basePath . $username . '/msg', 0777, true);
    
    // Create user-specific directory
    mkdir($basePath . $username . '/' . $username, 0777, true);
    
    // Copy a.php file to user-specific directory
    copy('a.php', $basePath . $username . '/' . $username . '/a.php');
}

*/
function mkindex($username) {
    $html = '
<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="emp hosting">
    <style>
        body {
            background-color: black;
            color: white;
        }
    </style>
    <script src="js/bar.js"></script>
</head>
<body>
    <h1>Coming Soon, ' . $username . '\'s Page!</h1>
    <marquee behavior="scroll" direction="left" style="color: red;">
        <a href="https://www.alternativeware.space">Visit AlternativeWare</a>
    </marquee>
</body>
</html>
    ';

    $folder = './' . $username;
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    file_put_contents($folder . '/index.html', $html);
}
function validateUsername($username) {
    // Check username length
    if (strlen($username) < 3 || strlen($username) > 20) {
        return false;
    }

    // Check for at least one number
    if (!preg_match('/[0-9]/', $username)) {
        return false;
    }

    // Check for at least one capital letter
    if (!preg_match('/[A-Z]/', $username)) {
        return false;
    }

    // Check for at least one special character
    if (!preg_match('/[^a-zA-Z0-9]/', $username)) {
        return false;
    }

    return true;
}

function createDirectoriesAndCopyFile($username) {
    $directory = "$username";
    
    if (is_dir($directory)) {
        echo "Username is already in the system.";
    } else {
        mkdir($directory, 0777);
        copy('a.php', "$directory/a.php");
        chmod("$directory/a.php",0777); 
        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head> 
            <meta name='description' content='alternativeware.space'>
       <script src='js/bannerbottom.js'></script>
       <style>
       body { background-color: black; 
             color: yellow; }
             h1 {background-color:red; 
             color: white; }
             
       </head>
        <body>
            <div style='text-align: center;'>
                <h1>Coming Soon! ".$username."'s page!</h1><br>
                <a href=\"https://www.alternativeware.space\"> EMP-net solutions</a>
               
            </div>
        </body>
        </html>";
        
        file_put_contents("$directory/index.html", $htmlContent);
        
        $clientBinDirectory = "./ClientBin/$username";
        mkdir($clientBinDirectory, 0777);
        
        $subDirectories = ['logs', 'media', 'uploads', 'profile'];
        foreach ($subDirectories as $subDir) {
            mkdir("$clientBinDirectory/$subDir", 0777, true);
            copy('upload.php', "$clientBinDirectory/$subDir/upload.php");
        }
    }
} 
function copyFileContents($username) {
    $sourceFile = 'scripts/fm.emp';
    $destinationFolder = $username . '/a.php';
    
    if (!file_exists($username)) {
        mkdir($username);
    }
    
    copy($sourceFile, $destinationFolder);
}
function userid() {
    $path = 'users/';
    $highestUserId = 0;

    foreach (glob($path . '*.xml') as $file) {
        $xml = simplexml_load_file($file);
        $userId = (int)$xml->userid;

        if ($userId > $highestUserId) {
            $highestUserId = $userId;
        }
    }

    return $highestUserId;
}





$errors = array();
if(isset($_POST['login'])){
    $username = preg_replace('/[^A-Za-z]/', '', $_POST['username']);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $package = isset($_POST['package']) ? $_POST['package'] : 'free';
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    
    $userid = userid() +1;
    $date = date("m-d-y");
    $role = 'member';
    
    if(file_exists('users/' . $username . '.xml')){
        $errors[] = 'Username already exists';
    }
    if($username == ''){
        $errors[] = 'Username is blank';
    }
    if($email == ''){
        $errors[] = 'Email is blank';
    }
    if($phone == ''){
        $errors[] = 'Phone number is blank';
    }
    if($password == '' || $c_password == ''){
        $errors[] = 'Passwords are blank';
    }
    if($password != $c_password){
        $errors[] = 'Passwords do not match';
    }
    if($userid == ''){
        $errors[] = 'contact support, and tell them that there is an error retrieving a new userid for you ';
    }
    
    if (validateUsername($username)) {
    echo "Username is valid.";
} else {
    $errors[] = ' your username must be over three characters long and contain one capital and one number.';
}
    
    if(count($errors) == 0){
  
    } 
    
   
   createDirectoriesAndCopyFile($username);
   copyFileContents($username);
   mkindex($username);
    // Create the XML file
    $xml = new SimpleXMLElement('<user></user>');
    $xml->addChild('userid', $userid);
    $xml->addChild('username', $username);
    $xml->addChild('package', $package);
    $xml->addChild('role', $role);
    $xml->addChild('password', $password);
    $xml->addChild('email', $email);
    $xml->addChild('phone', $phone);
    $xml->addChild('date', $date);
    $xml->addChild('lastlogged', $date);
    $xml->asXML('users/' . $username . '.xml');
   
   

       session_start();
      $_SESSION['userid'] = $_POST['userid'];
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['password'] = $_POST['password'];
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['phone'] = $_POST['phone'];
      $_SESSION['date'] = $_POST['date'];
        header('Location: complete.php');
        die;
    }

?>
 <html> 
<head><title>Sign up for EMP!!</title>

   <style>
   body {background-color: black; color:white;}
       * {box-sizing: border-box;}

/* Style the input container */
.input-container {
  display: flex;
  width: 100%;
  margin-bottom: 15px;
}

/* Style the form icons */
.icon {
  padding: 10px;
  background: dodgerblue;
  color: white;
  min-width: 50px;
  text-align: center;
}

/* Style the input fields */
.input-field {
  width: 100%;
  padding: 10px;
  outline: none;
}

.input-field:focus {
  border: 2px solid dodgerblue;
}

/* Set a style for the submit button */
.btn {
  background-color: dodgerblue;
  color: white;
  padding: 15px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.btn:hover {
  opacity: 1;
}
.form2 { width:650; background-color:black;
opacity:0.8; }
   </style> 
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>
<body>
    <center>
    <div class="form2" >
      <form method="post"  action="" name="create" id="create">
          <?php
        if(count($errors) > 0){
            echo '<ul>';
            foreach($errors as $e){
                echo '<li>' . $e . '</li>';
            }
            echo '</ul>';
        }
        ?>
  <h2>Sign up!</h2><div class="input-container">
      <ul style="list-style-type: none;">
      <label style="color: dodgerblue; font-weight: bold;">
  <i class="fa-solid fa-tag"></i> Package Type:
</label><br>

<li><input type="radio" id="free" name="package" value="free">
<label for="free" style="color: white;" width="90" height="30" background-color="dodgerblue" width="90" height="35" ><font color="yellow" size="6"><u>$1 Standard Package</u></font> </label><br>
<font color="tomato" ></font>
    <ul style="list-style-type: none;">
    <li>   
comes with 1 subdomain</li> 
    <li>2 gigs of unmoderated space</li> 
    <li>1 email address.</li> 
    <li>Community Media </li>
    <li><br> <small>After active for 90 days, <u>account costs $3 total a year as standard private club membership fee.</u><br> All other club membership priviledgess are still considered valid. </small></li>
    </ul>
</li>
<li><br>
<input type="radio" id="silver" name="package" value="silver">
<label for="silver" style="color: white;" background-color="dodgerblue" width="90" height="35" background-color="dodgerblue" width="90" height="35" color:white; ><font color="tomato"></font><font color="yellow"><font size="6"><u>$2 Silver</u></font> <br> 
<font color="tomato" size="3">Small but mighty!</font>
More bandwidth for traffic </font><br>
    <ul style="list-style-type: none;"><li>1 subdomain </li>
    <li>5 emails</li>  
    <li>5 gigs of space</li>
    <li>7 days of community advertisement credits on all emp sites</li>
    <li>club community media package lite. </li>
    </ul>
</li>
<li>
<input type="radio" id="gold" name="package" value="gold">
<label for="gold" style="color: white;" background-color="dodgerblue" width="90" height="35" background-color="dodgerblue" width="90" height="35" color:white;><font color="yellow" size="6"><u>$3 Gold Package</u></font></label><br>
<font color="tomato" size="3">Internet Entrepreneur</font>
    <ul style="list-style-type: none;">
    <li>2 sub domains</li> 
    <li>10 gigs</li> 
    <li>plus 10 emails </li> 
    <li>community media production and publication package. </li>
    <li><br>WordPress, joomla, mastadon, hosting available</li>
    </ul>
</li>
<li>
<input type="radio" id="platinum" name="package" value="platinum">
<label for="platinum" style="color: white;" background-color="dodgerblue" width="90" height="35" color:white;><font color="yellow" size="6">$5 Premium</font></label><br>
<font color="tomato" size="3">Pimpin Platinium</font>
    <ul style="list-style-type: none;"><li>Explicit Content priviledges and management systems provided with %5 commission club fees. </li>
    <li>2 Subdomains </li>
    <li>10 emails</li> 
    <li>15 gigs</li>
    <li>Wordpress, joomla, Forums , etc ..</li><li> 
<Font color="blue">Webspace Reseller programs available!!</Font></li><br>
    </ul>
</li><small><small> specific items and addons are all available, despite package size or deal, in the dashboard, and does not recquire to be purchased in package deal, or contract. example, explicit contract dashboard, or word press hosting special , does not recquire $5 a month membership fee, but just the purchase of the addon and the code agreement of commission. </small></small>
  </div> 
 </li> 
 </ul>
  <div class="input-container">
    <i class="fa fa-user icon"></i>
    <input class="input-field" type="text" placeholder="Username" name="username" id="username">
  </div>
  
  <div class="input-container">
    <i class="fa fa-envelope icon"></i>
    <input class="input-field" type="text" placeholder="Email" name="email" id="email">
  </div>
  
  <div class="input-container">
    <i class="fa fa-envelope icon"></i>
    <input class="input-field" type="text" placeholder="phone" name="phone" id="phone">
  </div>

  <div class="input-container">
    <i class="fa fa-key icon"></i>
    <input class="input-field" type="password" placeholder="Password" name="password" id="password">
  </div> 
  
  <div class="input-container">
    <i class="fa fa-key icon"></i>
    <input class="input-field" type="password" placeholder="Repeat Password" name="c_password" id="c_password">
  </div> 
  

  <button type="submit"  name="login" class="btn" id="login">Submit</button>
</form> 
</div>
</center>

</html>


