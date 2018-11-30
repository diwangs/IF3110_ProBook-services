<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function findUsernamePassword($username, $password) {
    $query = "SELECT * FROM user WHERE username='" . $username . "' AND pass='" . $password . "'";
    global $mysqli;

    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function getUser($userId) {
    global $mysqli;

    $query = "SELECT * FROM user WHERE user_id=" . $userId;
    $result = $mysqli->query($query);

    return $result->fetch_assoc();
}