<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function getHistory($userId) {
    global $mysqli;
    $query = "
      SELECT 
        orders.order_id,
        orders.num_book,
        orders.order_date,
        review.rating,
        book.book_id,
        book.title,
        book.image_link
      FROM
        orders LEFT OUTER JOIN review ON orders.order_id = review.order_id
        INNER JOIN book ON orders.book_id = book.book_id
      WHERE user_id=" . $userId . "
      ORDER BY orders.order_id DESC;
    ";

    $result = $mysqli->query($query);

    return $result;
}