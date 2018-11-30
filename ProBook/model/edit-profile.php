<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function updateProfile($userId, $picturePath, $name, $address, $phoneNumber) {
    global $mysqli;

    $query = "
        UPDATE user
        SET
          fullname='" . $name . "',
          prof_pic='" . $picturePath . "',
          addrs='" . $address . "',
          phone_num='" . $phoneNumber . "'
        WHERE user_id='" . $userId . "';
    ";
    $mysqli->query($query);
}