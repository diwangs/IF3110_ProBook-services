<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function updateProfile($userId, $picturePath, $name, $address, $phoneNumber, $cardNumber) {
    global $mysqli;

    $query = "
        UPDATE user
        SET
          fullname='" . $name . "',
          prof_pic='" . $picturePath . "',
          addrs='" . $address . "',
          phone_num='" . $phoneNumber . "',
          card_num=" . $cardNumber . " 
        WHERE user_id='" . $userId . "';
    ";
    file_put_contents("php://stdout", $query);
    $mysqli->query($query);
}