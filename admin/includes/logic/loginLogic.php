<?php
include "../../conn.php"; 
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["email"]) & !empty($_POST["password"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT `password`,`Email`,`GroupID`,`username`,`UserID` FROM `users` WHERE `Email`=? AND `GroupID`=1 ";
        // var_dump(get_class_methods($conn));
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetchObject();
        var_dump($data);
        if(!empty($data)){
                    
            if(password_verify(strval($password), $data->password)){
                $_SESSION["username"] = $data->username;
                $_SESSION["id"] = $data->UserID;
                header("location:../../dashboard.php");
                exit();
                
            }else{
                $_SESSION["Error"] = "Invalid email or password";
                header("location:../../index.php");
                exit();
            }

        }else{
            $_SESSION["Error"] = "Invalid email or password";
            header("location:../../index.php");
            exit();

        }
           
            

    }else{
        $_SESSION["missing_data"] = "Write your email and password ";
        header("location:../../index.php");
        exit();
    };
}else{
    echo " very bad";
};


