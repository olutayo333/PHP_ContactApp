<?php
    session_start();
    require 'connection.php';
    //print_r($_SESSION['user_id']);
    $id=$_SESSION['user_id'];
    $query = "SELECT * FROM registration WHERE id =$id" ;
    $found = $connect->query($query);
    $user = $found->fetch_assoc();
    $firstname = $user['firstName']; 
    $lastname = $user['lastName']; 
    
    //FETCHING NOTE
    $query_contact= "SELECT * FROM contact_tb WHERE id = $id";
    $found_contact = $connect->query($query_contact);
    $contacts = $found_contact->fetch_all(MYSQLI_ASSOC);
    //print_r($note);
    echo "</br>";
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center text-center my-5"> 
            <div class="col-5 shadow my-3 py-3">
            <?php
                  if (isset($_SESSION['response'])){
                        echo "<div class='alert alert-success fs-5'>" .$_SESSION['response']. "</div>";
                    }
                    unset($_SESSION['response']);
                    if (isset($_SESSION['response2'])){
                        echo "<div class='alert alert-danger fs-5'>" .$_SESSION['response2']. "</div>";
                    }
                    unset($_SESSION['response2']);
            ?>
                <h3> Welcome  <?php  echo $firstname. " ". $lastname ?> </h3>
                
                <h4 class="display-3"> <u>Create Contact</u></h4>
                <form action="process.php" method="post" >
                    <input type="text" name="firstName" placeholder="First Name" class="form-control my-2">
                    <input type="text" name="lastName" placeholder="First Name" class="form-control my-2">
                    <input type="number" name="phoneNumber" placeholder="Phone Number" class="form-control my-2"> 
                    <input type="email" name="email" placeholder="Email" class="form-control my-2">
                    <input type="submit" name="contact_submit" value="Save" class="btn w-100 btn-dark my-2">
                </form>
                
            </div>
            <div class="col-5 shadow  ">
                    <p class="display-4"> <b><u>Contacts</u></b></p>
                    <?php 
                      //  print_r($note);
                        foreach($contacts as $each ){
                            echo '</br>';
                            echo '<div>'. "First Name: ".$each['firstName']. " ". "Last Name: ". $each['lastName']. " ". "Phone Number: ". $each['phoneNumber'] . '</div>';
                            
                           
                        }
                    ?>
            </div>
        </div>

    </div>
</body>
</html>