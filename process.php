<?php
    require 'connection.php';
    session_start();

    if(isset($_POST['submit']))
    {
        $firstName=$_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email =$_POST['email'];
        $password = $_POST['password'];
        
        $checkEmailQuery = "SELECT * FROM registration WHERE `email`= '$email'" ;
        $found = $connect->query($checkEmailQuery); //mysqli_query($connect, $checkEmailQuery);
          
        if($found)
        {
            if($found->num_rows>0)
            {
                $_SESSION['error_message']='Email already exist';
                header('location:signUp.php');
            }
            else
            {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //echo $hashedPassword;
                $query="INSERT INTO `registration`( `firstName`,`lastName`,`email`,`password` ) VALUES ( '$firstName', '$lastName', '$email', '$hashedPassword')" ;
                $dbconnection = $connect->query($query);

                if($dbconnection)
                {
                    $_SESSION['response']= 'Registration Successful, please login';
                    header('location:login.php');
                } 
                else
                {
                    $_SESSION['error_message']='Registration Failed';
                    header('location:signUp.php');
                }
            }
        }
        else
        {
            $_SESSION['error_message']='Database Connection Error';
        }
    }

    if(isset($_POST['login']))
    {
        $email = $_POST['email']; 
        $password = $_POST['password'];
        $query = "SELECT * FROM registration WHERE email = '$email' ";
        $found = $connect->query($query);
        
        if($found)
        { 
            if ($found->num_rows>0)
            {
                $user=$found->fetch_assoc();
                $hashedPassword= $user['password'];
                $verify=password_verify($password, $hashedPassword);
                if ($verify)
                {
                    $_SESSION['user_id']=$user['id'];
                    header('location:dashboard.php');
                }
                else
                {
                    $_SESSION['response2']='Invalid Password';
                    header('location:login.php');
                }
            }
            else
            {
                $_SESSION['response2']='Email not found';
                header('location:login.php');
            }
        }
        else
        {
            $_SESSION['response2']='Db connection Error';
        }
        
    }


    if (isset($_POST['contact_submit']))
    {
        $firstName= $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email =$_POST['email'];
        $phoneNumber= $_POST['phoneNumber'];
        $id=$_SESSION['user_id'];

        $query="INSERT INTO `contact_tb`(`firstName`, `lastName`, `phoneNumber`, `email`, `id` ) VALUES('$firstName', '$lastName', '$phoneNumber', '$email', '$id')";
        $dbconnection = $connect->query($query);

        if($dbconnection)
        {
            $_SESSION['response']='Contact Saved Successfully';
            header('location:dashboard.php');
        }
        else
        {
            $_SESSION['response2']='Contact Could not be saved';
            header('location:dashboard.php');
        }
    }


?>