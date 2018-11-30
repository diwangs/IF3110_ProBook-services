<?php
//    echo "hello";
    if (isset($_COOKIE["userId"])) {
        $redirectLink = "/view/profile";
    } else {
        $redirectLink = "/view/login";
    }
    header("Location: " . $redirectLink);
    exit();