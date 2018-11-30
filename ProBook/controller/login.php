<?php

include($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");

if (isset($_POST["username"]) and isset($_POST["password"])) {
    $user = findUsernamePassword($_POST["username"], $_POST["password"]);
    if (isset($user)) {
        $redirectLink = "/view/profile";
        setcookie("userId", $user["user_id"], 0, "/");
    } else {
        $redirectLink = "/view/login?loginFailed=true";
    }
    header("Location: " . $redirectLink);
    exit();
}
