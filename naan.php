<?php

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

if (!empty($name) && !empty($email) && !empty($message)) {

    $host = "localhost";
    $dbusername = "sivaraj";
    $dbpassword = "sabari@2005";
    $dbname = "vasan";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Connect Error ('. $conn->connect_errno .') '. $conn->connect_error);
    } else {
        $SELECT = "SELECT email FROM naan WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO naan (name, email, message) VALUES (?, ?, ?)";

        // Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $name, $email, $message);
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "Someone already registered using this email";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
?>
