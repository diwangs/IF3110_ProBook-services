<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function getBookDetail($orderId) {
    global $mysqli;
    $query = "
      SELECT DISTINCT
        book.title,
        book.author,
        book.image_link
      FROM
        orders INNER JOIN  book ON orders.book_id = book.book_id
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