<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");  

function deleteToken($accessToken) {
    $query = "DELETE FROM active_token WHERE token='".$accessToken."';";
    global $mysqli;
    $mysqli->query($query);
}
?>