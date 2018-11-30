<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function getProfileData($userId) {
    global $mysqli;

    $query = "
        SELECT 
          *
        FROM
          user
        WHERE user_id=" . $userId . ";
    ";
    $mysqli->query($query);
}