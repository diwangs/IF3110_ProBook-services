<?php

if (isset($_COOKIE['userId'])) {
    unset($_COOKIE['userId']);
    setcookie('userId', null, -1, '/');
}

header("Location: /view/login");
exit();