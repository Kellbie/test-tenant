<?php
$Firstname = $_POST['First-Name'];
$Lastname = $_POST['Last-Name'];
$Email = $_POST['Email'];
$Phone = $_POST['Phone-Number'];
$Location = $_POST['Location'];
$Country = $_POST['Country'];

if (!empty($Firstname) || !empty($Lastname) || !empty($Email) ||!empty($Phone) || !empty($Location) || !empty($Country) ){
    $host ="localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "register";

    //create connection

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT= "SELECT email From register Where email = ? limit 1";
        $INSERT = "INSERT Into register (First Name, Last Name, Address, Phone, Location, Country) values(?,?,?,?,?,?)";

    //Prepare Statement
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $stmt->bind_result($Email);
    $stmt->store_result();
    $rnum =$stmt->num_rows;

    if($rnum==0){
        $stmt->close();

        $stmt =$conn->prepare($INSERT);
        $stmt->bind_param("ssssii", $Firstname, $Lastname, $Email, $Phone, $Location, $Country);
        $stmt->execute();
        echo "New Record inserted successfully";
    } else {
        echo "Someone Already Registered Using This Email";
    }
    $stmt->close();
    $conn->close();
}  

    
} else {
    echo "All Fields Are Required";
    die();
}
?>