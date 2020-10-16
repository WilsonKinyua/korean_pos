
<!--
 * 
 * author:wilson kinyua
 * email: wilsonkinyuam@gmail.com
 * year created : May 2020
 * start date: 21 Sep 2020
 * end date: 
 * 
 * 
 * -->

<?php include "database.php";

/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */

function fetch_array($result) {
  return  mysqli_fetch_array($result);
}


/**=================================================query function================================ */

function query($sql) {
    global $connection;
    return mysqli_query($connection,$sql);
}


/**=================================================redirect function================================ */

function redirect($location) {
    return header("Location: ".$location);
}

/**=================================================last id insterted function======================== */

function last_insert_id() {
    global $connection;
    return mysqli_insert_id($connection);
}

/**==============================================set message function================================= */

function set_message($msg) {

    if(!empty($msg)) {

        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }

}

/**============================================display the message create through the session========== */

function display_message() {

    if(isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }
}

/**=====================================function to check whtether there an error to the query========== */

function confirm($result) {
    global $connection;

    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

/**============================================prevent mysql stringinjuction=============================== */

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection,$string);
}

/**============================================function to count rows===================================== */

function count_rows($result) {
    return mysqli_num_rows($result);
}

/**===========function to generate a unique token and set it to session===================================== */

function token_generator() {
    return $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
}

/**===========function to hast user password========================================================== */

function hash_password($password) {

}

/**===========clean from htmlentities========================================================== */

function clean($string) {
    return htmlentities($string);
}


/**===========send email to user email========================================================== */

function send_email($email,$subject,$message,$headers) {
    return mail($email,$subject,$message,$headers);
}

/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */



/**=================================================check if email exists ================================ */

function email_exists($email) {
    $query = query("SELECT id FROM users WHERE email = " . $email);
    confirm($query);
    if(count_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}

/**=================================================check if username exists ================================ */

function username_exists($username) {
    $query = query("SELECT id FROM users WHERE username = ". $username);
    confirm($query);
    if(count_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}

/**=================================================USER LOGIN VALIDATION FUNCTIONS ============================== */

function validate_user_login() {
    $errors = [];

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $remember_me = isset($_POST['remember_me']);

        /***********************email validation******************************************** */
        if(empty($email)) {
            $errors[] = "<div class ='alert alert-danger'>The email field cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

       /***********************password validation******************************************** */

      if(empty($password)) {

        $errors[] = "<div class ='alert alert-danger'>The password field cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
     
        }

        if(!empty($errors)) {
            foreach($errors as $error) {
                echo $error;
            }
        } else {
            if(login($email,$password,$remember_me)) {
                redirect("index.php");
            } else {
                set_message("<div class ='alert alert-danger'>Error occurred while trying to login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect("login.php");
            }
        }
    }
}

/**=================================================LOGIN USER ============================== */

function login($email,$password,$remember_me) {
    $result = query("SELECT username,password,id FROM users WHERE user_email = '" . escape($email) . "'AND active = 1");
    confirm($result);
    if(count_rows($result) == 1) {

        $row = fetch_array($result);
        $db_username = $row['username'];
        $db_password = $row['password'];
        /********************pulling out the password and changing it to its original************************************** */
        if(md5($password) == $db_password) {

             /**============setting and checking the cookie******************************************************************** */
            if($remember_me == "on") {

                setcookie("email",$email,time() + 100);
            }
              /**============setting session for the email to be available in the whole site************************************* */
            $_SESSION['username'] = $db_username;
            return true;
        } else {

            return false;
        }
        return true;
    } else {

        return false;
    }
}

/**=================================================REGISTER USERS TO THE SYSTEM============================== */
/**=================================================REGISTER USERS TO THE SYSTEM============================== */

function validate_user_register() {

}