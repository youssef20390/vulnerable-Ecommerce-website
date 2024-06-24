<?php
include "../../conn.php"; 
include "../../init.php";
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["logemail"]) && !empty($_POST["logpass"])){
        $email = $_POST["logemail"];
        $password = $_POST["logpass"];
        $sql = "SELECT `password`,`Email`,`username`,`UserID`  FROM `users` WHERE `Email`=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetchObject();
        if(!empty($data)){
                    
            if(password_verify(strval($password), $data->password)){
                $_SESSION["user"] = $data->username;
                $_SESSION["user_id"] = $data->UserID ;
                header("location:../../profile.php?id=".$_SESSION["user_id"]);
                exit();
                
            }else{
                $_SESSION["Userserror"] = "Invalid email or password";
                header("location:../../login.php");
                exit();
            }

        }else{
            $_SESSION["Userserror"] = "Invalid email or password";
            header("location:../../login.php");
            exit();

        }
           
            

    }else{
        $_SESSION["missing_user_data"] = "Write your email and password ";
        header("location:../../login.php");
        exit();
    };
}else{
    echo "Invalid Method";
};


