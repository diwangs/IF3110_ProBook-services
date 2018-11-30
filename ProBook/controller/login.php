<?php

include($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST["username"]) and isset($_POST["password"])) {
    $user = findUsernamePassword($_POST["username"], $_POST["password"]);
    if (isset($user)) {
        $redirectLink = "/view/profile";
        // Store token in db
        $token = generateRandomString(16);
        setcookie("accessToken", $token, 0, "/");
        storeToken($token, $user["user_id"]);
        setcookie("userId", $user["user_id"], 0, "/");
    } else {
        $redirectLink = "/view/login?loginFailed=true";
    }
    header("Location: " . $redirectLink);
    exit();
}
