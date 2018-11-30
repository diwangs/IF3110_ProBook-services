<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function createUser($fullname, $username, $email, $password, $address, $phonenumber) {
    $query = "INSERT INTO user (fullname, username, email, pass, addrs, phone_num) VALUES ('" . $fullname . "', '" . $username . "', '" . $email . "', '" . $password . "', '" . $address . "', '" . $phonenumber . "');"; 
    
    global $mysqli;

    $result = $mysqli->query($query);
    error_log($result, 0);
    return $result;
}