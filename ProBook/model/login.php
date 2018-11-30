<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");
date_default_timezone_set("Asia/Jakarta");

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

function storeToken($accessToken, $userId) {
    $query = "INSERT INTO active_token VALUES ('".$accessToken."', ".$userId.", '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['REMOTE_ADDR']."', NOW() + INTERVAL 1 MINUTE);";
    global $mysqli;
    $mysqli->query($query);
}

function updateToken($accessToken) {
    $query = "UPDATE active_token SET expiry_time=NOW() + INTERVAL 1 MINUTE WHERE token='".$accessToken."';";
    global $mysqli;
    $mysqli->query($query);
}

function isTokenValid($accessToken) {
    $query = "SELECT * FROM active_token WHERE token='" . $accessToken ."';";
    global $mysqli;
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if (time() < strtotime($result['expiry_time'])) {
            if ($_COOKIE['userId'] == $result['user_id'] && $_SERVER['HTTP_USER_AGENT'] == $result['user_agent'] && $_SERVER['REMOTE_ADDR'] == $result['ip_address']) {
               updateToken($accessToken);
               return true;
            }
        } else {
            include($_SERVER["DOCUMENT_ROOT"] . "/model/logout.php");
            deleteToken($_COOKIE['accessToken']);
            setcookie('userId', null, -1, '/');
            setcookie('accessToken', null, -1, '/');
            header("Location: /view/login?expired=true");
        }
    } 
    return false;
}