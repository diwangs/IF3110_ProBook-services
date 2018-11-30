<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function getOrderDetail($orderId) {
    global $mysqli;
    $query = "
      SELECT
        *
      FROM
        orders
      WHERE order_id=" . $orderId . ";
    ";

    $result = $mysqli->query($query);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function insertReview($orderId, $rating, $content) {
    global $mysqli;

    $query = "INSERT INTO review (order_id, rating, content) VALUES (" . $orderId . ", " . $rating . ", '" . $content . "');";
    $result = $mysqli->query($query);
}