<?php
include "../../conn.php"; 
include "../../init.php";
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user 	= $_POST['logname'];
    $pass 	= $_POST['logpass'];
    $email 	= $_POST['logemail'];

    $hashPass = password_hash($pass,PASSWORD_DEFAULT);

    // Validate The Form

    $formErrors = array();

    if (strlen($user) < 4) {
        $formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
    }

    if (strlen($user) > 50) {
        $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
    }

    if (empty($user)) {
        $formErrors[] = 'Username Cant Be <strong>Empty</strong>';
    }

    if (empty($pass)) {
        $formErrors[] = 'Password Cant Be <strong>Empty</strong>';
    }

    if (empty($email)) {
        $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
    }

    // Loop Into Errors Array And Echo It

    foreach($formErrors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    $check = checkItem("Username","users",$user);
    $check2 = checkItem("Email","users",$email);
    if($check == 1 ){
        $_SESSION['signup-username-exists'] = "This username already exist";
        header("location:../../login.php");
    }elseif($check2 == 1 ){
        $_SESSION['signup-username-exists'] = "This Email already exist";
        header("location:../../login.php");
    }else{
        if (empty($formErrors)) {
            
            $sql = "INSERT INTO users (Username, Password, Email, RegStatus, Date) VALUES (:user, :pass, :mail, 0, now() )";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                
                'user' 	=> $user,
                'pass' 	=> $hashPass,
                'mail' 	=> $email,
                
            ]);
            $_SESSION['success'] = "Congratulations you are signed up";
            header('location:../../login.php');
            exit();
                       
           
                

        }
    };

    
}else{
    $theMsg="you cant acess this page directly";
    redirectHome($theMsg,null);
   };
