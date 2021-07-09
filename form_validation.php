<style>
    .err {
        color: red;
        font-weight: bold;
    }
</style>

<?php


//a function for the form. There are conditions to keep the user info
function form($email=null, $user=null, $DOB=null, $street=null, $city=null, $country=null) {
    echo '<h2><i>Your login information:</i></h2>';
    echo '<form action="form_validation.php" method="post">';
    echo   '<label for="email">Email:</label>';
    if ($email === null)
        echo   '<input type="text" name="email" maxlength="50" placeholder="John@Smith.com" required><br><br>';
    else
        echo   '<input type="text" name="email" maxlength="50" required value="' . $email .'"><br><br>';
    
   
    echo   '<label for="user_name">Username:</label>';
    if ($user === null)
        echo   '<input type="text" name="username" minlength="6" maxlength="10" placeholder="Alphanumeric" required><br><br>';
    else
    echo   '<input type="text" name="username" minlength="6" maxlength="10" required value="' . $user .'"><br><br>';

    echo   '<label for="password">Password:</label>';
    echo   '<input type="text" name="password" maxlength="30" required>';
    echo   '(at least one of each: uppercase, lowercase & number)<br><br>';
    echo   '<label for="DOB">Date of Birth:</label>';
    if ($DOB === null)
        echo   '<input type="date" name="DOB" required min="1900-01-01" max="2020-01-01"><br><br>';
    else
    echo   '<input type="date" name="DOB" required value="' . $DOB .'"><br><br>';
    echo '<div>';   

    echo   '<label for="gender">Gender: </label>';
    echo   '<label for="male">Male</label>';
    echo   '<input type="radio" name="gender" value="male" id="gender_male" required>';
    echo   '<label for="female">Female</label>';
    echo   '<input type="radio" name="gender" value="female" id="gender_female">';
    echo   '<label for="female">Other</label>';
    echo   '<input type="radio" name="gender" value="other" id="gender_other">';
    echo '</div><br>';
        
    echo '<div for="addr">';
    echo '<label for="address">Address:</label><br>';
    if ($street === null)
        echo '<input name="street" id="addr" placeholder="Street: 123 Main Rd" maxlength="50" required></input><br>';
    else 
    echo '<input name="street" id="addr" maxlength="50" required value="' . $street .'"></input><br>';
    if ($city === null)
        echo '<input name="city" id="addr" placeholder="City: London" maxlength="50" required></input><br>';
    else    
        echo '<input name="city" id="addr" placeholder="City: London" maxlength="50" required value="' . $city .'"></input><br>';
    if ($country === null)    
        echo '<input name="country" id="addr" placeholder="Country: England" maxlength="50" required></input><br>';
    else
        echo '<input name="country" id="addr" maxlength="50" required value="' . $country .'"></input><br>';    
    echo '</div>';
   
    echo '<button type="submit">Submit</button>';
    echo '</form>';
}




//If Server = post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

function error($msg) {
    echo '<p class="err">'.$msg.'</p>';
}


//get the variables from each field of the HTML
$email = $_POST['email'];

$user = $_POST['username'];

$password = $_POST['password'];

$DOB = $_POST['DOB'];

$gender = $_POST['gender'];

$street = $_POST['street'];
$city = $_POST['city'];
$country = $_POST['country'];

//flags for the email, user and passwords (used to make a success page)
//DOB, gender and other fields are all required by HTML
//the DOB is restricted - only between 1900 and 2020
$emailF = true;
$userF = true;
$passF = true;


//email check
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {                           //https://www.w3schools.com/php/php_form_url_email.asp
    error("Incorrect Email format: " . $email);
    $emailF = false;
    form($email, $user, $DOB, $street, $city, $country);


//check the username for alphanumerical only
} else if ($user) {
    $flag = true;
        for ($i = 0; $i < strlen($user); $i++) {
            $index = ord($user[$i]);

            //if there's a value that shouldn't be then flag as false and break out of loop
            if (($index > 122 || $index < 48) || ($index > 90 && $index < 97)) {
                $flag = false;
                break;
                }
            }
            
        //if the flag stays unchanged from the check above print it out, else if false print error message
        if (!$flag) {
            error("Username Incorrect: (" . $user . ") must be alphanumerical (a-z, A-Z, 0-9)!");
            $userF = false;
            form($email, $user, $DOB, $street, $city, $country);
        }


//checks password for 1 lower, upper and number digits
} if ($password) {
    //flags for lower, upper and number
    $lowercase = false;
    $uppercase = false;
    $num = false;

        //loop through the length of password and create a var at each index = to ASCII value
        for ($i = 0; $i < strlen($password); $i++) {
            $index = ord($password[$i]);

            //if a lower/upper/number exists at any index change the boolean variables for each to true
            if ($index >= 97 && $index <= 122) {
                $lowercase = true;
            } else if ($index >= 65 && $index <= 90) {
                $uppercase = true;
            } else if ($index >= 48 && $index <= 57) {
                $num = true;
            }
        }

        //if all of the boolean variables have passed the test, print password. Else, conditions have not been met.
        if ($lowercase && $uppercase && $num) {
      //      echo '<p><strong>Password</strong>: ' . $password . '</p>';
         } else {
            error("Invalid Password: must contain at least one of each (number, lowercase, uppercase)!");
            $passF = false;
            form($email, $user, $DOB, $street, $city, $country);
        }
}



//if the email, user and password flags are all true, then SUCCESS!!! displays information
if ($emailF && $userF && $passF) {
            echo '<h1>Thank you for submitting your information.</h1>';
            echo '<p><strong>Email</strong>: ' . $email . '</p>';
            echo '<p><strong>Username</strong>: ' . $user . '</p>';
            echo '<p><strong>Password</strong>: ' . $password . '</p>';
            echo '<p><strong>Date of Birth</strong>: ' . $DOB . '</p>';
            echo '<p><strong>Gender</strong>: ' . $gender . '</p>';
            echo '<p><strong>Address</strong>: ' . $street . ', ' . $city . ', ' . $country . '</span></p>';
     }
} else {
    form();
}

?>