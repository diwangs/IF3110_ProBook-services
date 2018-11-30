<?php
include($_SERVER["DOCUMENT_ROOT"] . "/model/logout.php");

deleteToken($_COOKIE['accessToken']);
setcookie('userId', null, -1, '/');
setcookie('accessToken', null, -1, '/');

header("Location: /view/login");
exit();
?>