<?php

if(!isset($_SESSION))
    session_start();

include "../database/db.php";

include "../database/auth.php";

include "../helper/validation.php";


// Required, !Empty, username:min3, max:50
if(isset($_POST["regform"])) {
    $message = "";
    $path = "/";
    $form_is_valid = checkForm($_POST, ["username", "email", "password", "password_confirm"]);

    if($form_is_valid) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password_confirm = $_POST["password_confirm"];

        $credentials_valid = checkLength($username, 3, 50) && checkLength($password, 5);
        if($credentials_valid) {
            $user = getUserByEmail($email);
            if(!$user) {
                if($password === $password_confirm) {

                    $user_id = create_user($username, $email, $password);
                    if($user_id != 0) {
                        $message = "Account is created successfully, please login";
                        $path = "/blogger/views/auth/login.php";
                    }
                    else {
                        $message = "Something went wrong.";
                        $path = "/blogger/views/auth/register.php";
                    }
                }
                else {
                    $message = "Password does not match the confirmation";
                    $path = "/blogger/views/auth/register.php";
                }
            }
            else {
                $message = "Email already exists.";
                $path = "/blogger/views/auth/register.php";
            }

            
        }
        else {
            $message = "Invalid username or password.";
            $path = "/blogger/views/auth/register.php";
        }
    
    }
    else {
        $message = "Data is missing";
        $path = "/blogger/views/auth/register.php";
    }
    
    $_SESSION["message"] = $message;
    header("location: $path");
}


if(isset($_POST["loginform"])) {
    // Login
    $message = "Invalid email or password.";
    $path = "/blogger/views/auth/login.php";

    // Validate data
    $form_is_valid = checkForm($_POST, ["email", "password"]);
    if($form_is_valid) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = getUserByEmail($email);
        if($user) {
            if($user["password"] === $password) {
                $message = "You've logged in successfully";
                $path = "/blogger";
                $_SESSION["user"] = $user;
            }

        }
        else {
            $message = "Account does NOT exist, please create a new account.";
            $path = "/blogger/views/auth/register.php";
        }
        
    }
    $_SESSION["message"] = $message;
    header("location: $path");

}

if(isset($_POST["logout"])) {
    unset($_SESSION["user"]);
    $_SESSION["message"] = "You've Signed out.";
    header("location: /blogger");
}

?>
